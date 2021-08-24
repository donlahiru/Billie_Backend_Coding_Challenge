<?php
namespace App\Services;

use App\Models\Company;
use App\Models\InvoiceDebtor;
use App\Models\InvoiceDetail;
use Validator;
use App\Models\Invoice;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function validator(array $data)
    {
        return Validator::make($data, [
            'company_id' => 'required|numeric',
            'debtor' => 'required',
            'debtor.name' => 'max:50',
            'debtor.address_street' => 'required|max:50',
            'debtor.address_zip_code' => 'required|max:10',
            'debtor.address_city' => 'required|max:50',
            'debtor.address_country' => 'required|max:50',
            'items' => 'required',
            'items.*.item_description' => 'required|max:255',
            'items.*.quantity' => 'required|integer|max:10',
            'items.*.amount' => 'required|numeric|between:0.00,9999999999.99'
        ]);
    }

    public function updateValidator(array $data)
    {
        return Validator::make($data, [
            'status' => ['required',Rule::in([
                Invoice::STATUS_DECLINED,
                Invoice::STATUS_PAID,
            ])],
            'remarks' => 'sometimes|required'
        ]);
    }

    public function checkDebtorLimitExceed(array $data)
    {
        $company = Company::find($data['company_id']);

        $pendingTotal = Invoice::where('status',Invoice::STATUS_PROCESSING)->sum('total_amount');

        $currentTotal = $this->getCurrentItemTotal($data);

        if(floatval($company->debtor_limit) < ($pendingTotal+$currentTotal)) {
            return [
                'error' => true,
                'limit' => $company->debtor_limit
            ];
        } else {
            return [
                'error' => false,
            ];
        }
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $invoiceData = new Invoice;
            $invoiceData->company_id = $data['company_id'];
            $invoiceData->invoice_no = $invoiceData->createNumber();
            $invoiceData->status = Invoice::STATUS_PROCESSING;
            $invoiceData->total_amount = $this->getCurrentItemTotal($data);
            $invoiceData->save();

            $data['debtor']['invoice_id'] = $invoiceData->id;
            InvoiceDebtor::create($data['debtor']);

            $invoiceDetail = [];
            foreach ($data['items'] as $item) {
                $item['invoice_id'] = $invoiceData->id;
                array_push($invoiceDetail, $item);
            }

            InvoiceDetail::insert($invoiceDetail);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function update($id, array $data)
    {
        $invoice = Invoice::find($id);

        if($invoice['status'] !== Invoice::STATUS_PROCESSING) {
            return [
                'error' => true,
                'message' => 'Update failed. This invoice already '.$invoice['status']
            ];
        }

        $invoice->status = $data['status'];
        $invoice->remarks = $data['remarks'];
        return $invoice->save();
    }

    public function getCurrentItemTotal($data)
    {
        $currentTotal = 0;
        foreach ($data['items'] as $item) {
            $currentTotal += $item['amount'];
        }

        return $currentTotal;
    }
}

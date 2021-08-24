<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InvoiceService as InvoiceService;

class InvoiceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function store(InvoiceService $invoiceService)
    {
        try {
            $validator = $invoiceService->validator($this->_request->all());

            if($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()->toArray()
                ],400);
            }

            $checkDebtorLimit = $invoiceService->checkDebtorLimitExceed($validator->getData());

            if($checkDebtorLimit['error']) {
                return response()->json([
                    'error' => true,
                    'message' => "debtor limit ".$checkDebtorLimit['limit']." exceeded."
                ],400);
            }

            $result = $invoiceService->create($validator->getData());
            if($result) {
                return response()->json([
                    'error' => false,
                    'message' => 'Successfully created.'
                ],200);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'error in saving.'
                ],400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ],401);
        }
    }

    public function update($id, InvoiceService $invoiceService)
    {
        try {
            $validator = $invoiceService->updateValidator($this->_request->all());

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()->toArray()
                ], 400);
            }

            $result = $invoiceService->update($id, $validator->getData());
            if(isset($result['error'])) {
                return response()->json([
                    'error' => false,
                    'message' => $result['message']
                ],400);
            } else if(!$result){
                return response()->json([
                    'error' => true,
                    'message' => 'error in updating.'
                ],400);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Successfully updated.'
                ],200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ],401);
        }
    }
}

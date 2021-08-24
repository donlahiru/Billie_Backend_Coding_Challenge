<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    const STATUS_PROCESSING = 'processing';

    const STATUS_PAID = 'paid';

    const STATUS_DECLINED = 'declined';

    protected $fillable = [
        'invoice_no',
        'company_id',
        'total_amount',
        'status',
        'remarks',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function invoiceDebtors()
    {
        return $this->hasOne(InvoiceDebtor::class);
    }

    public function createNumber()
    {
        $last = $this::all()->last();
        $lastNumber = $last ? 'INV-'.sprintf('%06d', ((int) str_replace("INV-","",$last->invoice_no) + 1)) : "INV-000001";
        return $lastNumber;
    }
}

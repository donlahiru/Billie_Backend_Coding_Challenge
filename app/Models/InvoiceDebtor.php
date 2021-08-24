<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDebtor extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'name',
        'address_street',
        'address_zip_code',
        'address_city',
        'address_country',
    ];
}

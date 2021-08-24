<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 'active';

    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'name',
        'address_street',
        'address_zip_code',
        'address_city',
        'address_country',
        'debtor_limit',
        'status'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}

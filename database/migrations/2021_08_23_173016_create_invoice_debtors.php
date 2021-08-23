<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDebtors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_debtors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->string('name',50);
            $table->string('address_street',50);
            $table->string('address_zip_code',10);
            $table->string('address_city',50);
            $table->string('address_country',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_debtors');
    }
}

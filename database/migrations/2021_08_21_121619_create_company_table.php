<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('address_street',50);
            $table->string('address_zip_code',10);
            $table->string('address_city',50);
            $table->string('address_country',50);
            $table->decimal('debtor_limit',10,2)->default(0.00);
            $table->enum('status',array( 'active', 'inactive'));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}

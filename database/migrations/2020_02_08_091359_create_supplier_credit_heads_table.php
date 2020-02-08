<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierCreditHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_credit_heads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('supplier_credit_date');
            $table->string('supplier_credit_invoice_no');
            $table->bigInteger('supplier_id')->unsigned();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_credit_heads');
    }
}

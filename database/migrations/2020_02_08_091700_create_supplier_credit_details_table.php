<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierCreditDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_credit_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('supplier_credit_head_id')->unsigned();
            $table->bigInteger('stock_details_id')->unsigned();
            $table->timestamps();

            $table->foreign('supplier_credit_head_id')->references('id')->on('supplier_credit_heads');
            $table->foreign('stock_details_id')->references('id')->on('stock_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_credit_details');
    }
}

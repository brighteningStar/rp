<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_heads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('quantity_invoice');
            $table->string('declaration_number');
            $table->dateTime('so_date');
            $table->string('so_number');
            $table->dateTime('invoice_date');
            $table->string('invoice_number');
            $table->string('tracking_number');
            $table->bigInteger('bill_to')->unsigned()->nullable();
            $table->bigInteger('ship_to')->unsigned()->nullable();
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->bigInteger('region_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('bill_to')->references('id')->on('shipping_billings');
            $table->foreign('ship_to')->references('id')->on('shipping_billings');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_heads');
    }
}

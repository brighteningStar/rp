<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sales_head_id')->unsigned();
            $table->bigInteger('stock_details_id')->unsigned();
            $table->decimal('unit_price');
            $table->decimal('discount');
            $table->decimal('amount');

            $table->foreign('sales_head_id')->references('id')->on('sales_heads');
            $table->foreign('stock_details_id')->references('id')->on('stock_details');
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
        Schema::dropIfExists('sales_details');
    }
}

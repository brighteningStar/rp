<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_head_id')->unsigned();
            $table->bigInteger('sys_id')->unique();
            $table->bigInteger('imei_no')->unique();
            $table->bigInteger('serial_no')->unique();
            $table->bigInteger('make_id')->unsigned();
            $table->bigInteger('model_id')->unsigned();
            $table->bigInteger('capacity_id')->unsigned();
            $table->bigInteger('color_id')->unsigned();
            $table->bigInteger('grade_id')->unsigned();
            $table->bigInteger('bank_deal_id')->unsigned();
            $table->bigInteger('fault_type')->unsigned();
            $table->string('stock_number');
            $table->text('part_description');
            $table->decimal('price_usd');
            $table->decimal('price_aed');
            $table->string('custom_duty');
            $table->string('freight');
            $table->string('total_cost');
            $table->enum('stock_status', ['in_stock', 'sold', 'rma', 'suppler_credit', 'damaged']);
            $table->enum('local_imported', ['local', 'imported']);
            $table->timestamps();

            $table->foreign('stock_head_id')->references('id')->on('stock_heads');
            $table->foreign('make_id')->references('id')->on('make');
            $table->foreign('model_id')->references('id')->on('make_models');
            $table->foreign('capacity_id')->references('id')->on('capacities');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('bank_deal_id')->references('id')->on('bank_deals');
            $table->foreign('fault_type')->references('id')->on('fault_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_details');
    }
}

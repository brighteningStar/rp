<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRmaDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rma_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rma_heads_id')->unsigned();
            $table->bigInteger('stock_details_id')->unsigned();
            $table->timestamps();

            $table->foreign('rma_heads_id')->references('id')->on('rma_heads');
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
        Schema::dropIfExists('rma_details');
    }
}

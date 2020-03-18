<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sales_head_id')->unsigned();
            $table->bigInteger('search_model_id')->unsigned()->nullable();
            $table->bigInteger('search_color_id')->unsigned()->nullable();
            $table->bigInteger('search_capacity_id')->unsigned()->nullable();
            $table->bigInteger('search_grade_id')->unsigned()->nullable();
            $table->string('quantity')->default('0');
            $table->timestamps();

            $table->foreign('sales_head_id')
                ->references('id')->on('sales_heads')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_filters');
    }
}

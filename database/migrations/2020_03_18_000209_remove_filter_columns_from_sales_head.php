<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFilterColumnsFromSalesHead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_heads', function (Blueprint $table) {
            $table->dropColumn('search_model_id');
            $table->dropColumn('search_color_id');
            $table->dropColumn('search_capacity_id');
            $table->dropColumn('search_grade_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_heads', function (Blueprint $table) {
            $table->bigInteger('search_model_id')->unsigned()->nullable();
            $table->bigInteger('search_color_id')->unsigned()->nullable();
            $table->bigInteger('search_capacity_id')->unsigned()->nullable();
            $table->bigInteger('search_grade_id')->unsigned()->nullable();
        });
    }
}

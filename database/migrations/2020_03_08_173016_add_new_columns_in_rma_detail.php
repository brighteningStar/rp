<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInRmaDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rma_details', function (Blueprint $table) {
            $table->bigInteger('fault_type_id')->unsigned()->after('stock_details_id');
            $table->bigInteger('location_id')->unsigned()->after('fault_type_id');
            $table->string('fault')->after('location_id');
            $table->string('sale_price')->after('fault');

            $table->foreign('fault_type_id')->references('id')->on('fault_types');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rma_details', function (Blueprint $table) {
            $table->dropForeign(['fault_type_id']);
            $table->dropForeign(['location_id']);

            $table->dropColumn('fault_type_id');
            $table->dropColumn('location_id');
            $table->dropColumn('fault');
            $table->dropColumn('sale_price');
        });
    }
}

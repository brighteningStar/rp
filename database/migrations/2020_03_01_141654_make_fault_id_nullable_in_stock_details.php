<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeFaultIdNullableInStockDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_details', function (Blueprint $table) {
            $table->dropForeign(['fault_type']);
            $table->dropColumn('fault_type');
        });

        Schema::table('stock_details', function (Blueprint $table) {
            $table->bigInteger('fault_type')->unsigned()->nullable()->after('stock_status');
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

    }
}

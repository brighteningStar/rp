<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_details', function (Blueprint $table) {
            $table->dropColumn('imei_no');
            $table->dropColumn('serial_no');
        });
        Schema::table('stock_details', function (Blueprint $table) {

            $table->string('imei_no')->after('sys_id');
            $table->string('serial_no')->after('imei_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_details', function (Blueprint $table) {
            $table->dropColumn('imei_no');
            $table->dropColumn('serial_no');
        });

        Schema::table('stock_details', function (Blueprint $table) {
            $table->bigInteger('imei_no')->after('sys_id');;
            $table->bigInteger('serial_no')->after('imei_no');
        });
    }
}

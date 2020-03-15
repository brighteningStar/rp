<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStockHeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_heads', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
            $table->decimal('custom_duty');
            $table->decimal('freight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_heads', function (Blueprint $table) {
            //
        });
    }
}

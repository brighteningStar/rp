<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFreightAndCustomDutyColumnsInStockHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_heads', function (Blueprint $table) {
            $table->decimal('custom_duty', 20, 2)->nullable()->change();
            $table->decimal('freight', 20, 2)->nullable()->change();
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

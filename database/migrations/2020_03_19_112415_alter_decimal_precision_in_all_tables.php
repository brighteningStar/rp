<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDecimalPrecisionInAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // bank_deals => 'exchange_rate' , 'deal_amount',
        Schema::table('bank_deals', function (Blueprint $table) {
            $table->decimal('exchange_rate', 20, 2)->change();
            $table->decimal('deal_amount', 20, 2)->change();
        });

        // sales_details => 'unit_price' , 'discount', 'amount',
        Schema::table('sales_details', function (Blueprint $table) {
            $table->decimal('unit_price', 20, 2)->change();
            $table->decimal('discount', 20, 2)->change();
            $table->decimal('amount', 20, 2)->change();
        });

        // stock_details => 'price_usd' , 'price_aed',
        DB::statement('ALTER TABLE `stock_details` MODIFY `price_usd` DECIMAL(20, 2)');
        DB::statement('ALTER TABLE `stock_details` MODIFY `price_aed` DECIMAL(20, 2)');

        // stock_heads => 'custom_duty' , 'freight',
        Schema::table('stock_heads', function (Blueprint $table) {
            $table->decimal('custom_duty', 20, 2)->change();
            $table->decimal('freight', 20, 2)->change();
        });

        // stock_details => alter SYS_ID from BIGINT to VARCHAR
        DB::statement('ALTER TABLE `stock_details` MODIFY `sys_id` VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::table('all_tables', function (Blueprint $table) {
            //
        //});
    }
}

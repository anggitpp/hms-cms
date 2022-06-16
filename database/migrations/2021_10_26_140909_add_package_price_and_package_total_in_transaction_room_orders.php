<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPackagePriceAndPackageTotalInTransactionRoomOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_hotel_orders', function (Blueprint $table) {
            $table->integer('package_total')->nullable();
            $table->string('package_price', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_hotel_orders', function (Blueprint $table) {
            //
        });
    }
}

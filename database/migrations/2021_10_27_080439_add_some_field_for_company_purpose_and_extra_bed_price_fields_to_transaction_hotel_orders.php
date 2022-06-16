<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldForCompanyPurposeAndExtraBedPriceFieldsToTransactionHotelOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_hotel_orders', function (Blueprint $table) {
            $table->string('extra_bed_price', 20)->nullable();
            $table->string('company_emergency_name', 50)->nullable();
            $table->string('company_phone', 15)->nullable();
            $table->char('company_accomodation', 1)->nullable();
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

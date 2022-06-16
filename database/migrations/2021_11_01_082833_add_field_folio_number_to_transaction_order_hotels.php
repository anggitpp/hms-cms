<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldFolioNumberToTransactionOrderHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_hotel_orders', function (Blueprint $table) {
            $table->string('folio_number', 10)->nullable()->after('payment_detail');
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

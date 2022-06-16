<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_hotel_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id');
            $table->string('name', 100);
            $table->string('identity_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('province_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('email', 20)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('company_name', 50)->nullable();
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->integer('number_of_nights');
            $table->integer('number_of_adults');
            $table->foreignId('package_id')->nullable();
            $table->text('rooms')->nullable();
            $table->integer('extra_bed')->nullable();
            $table->string('price', 20)->nullable();
            $table->integer('discount')->nullable();
            $table->string('discount_price', 15)->nullable();
            $table->string('fix_price', 15)->nullable();
            $table->text('note')->nullable();
            $table->char('status', 1);
            $table->char('payment_method', 1);
            $table->string('payment_detail', 30);
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_hotel_orders');
    }
}

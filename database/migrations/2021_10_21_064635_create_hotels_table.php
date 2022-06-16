<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', '10');
            $table->foreignId('type_id');
            $table->text('address')->nullable();
            $table->foreignId('province_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->char('phone_number', 16)->nullable();
            $table->string('email', 50)->nullable();
            $table->text('photo')->nullable();
            $table->text('longitude')->nullable();
            $table->text('latitude')->nullable();
            $table->text('description')->nullable();
            $table->char('status', 1);
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
        Schema::dropIfExists('hotels');
    }
}

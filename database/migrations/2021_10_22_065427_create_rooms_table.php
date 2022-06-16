<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id');
            $table->foreignId('type_id');
            $table->string('number', 10);
            $table->string('description')->nullable();
            $table->foreignId('status_id');
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
        Schema::dropIfExists('master_rooms');
    }
}

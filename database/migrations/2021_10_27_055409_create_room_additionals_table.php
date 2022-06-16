<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomAdditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_room_additionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id');
            $table->string('name', 100);
            $table->string('price', 20);
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
        Schema::dropIfExists('master_room_additionals');
    }
}

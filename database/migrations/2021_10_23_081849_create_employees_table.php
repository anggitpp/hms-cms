<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id');
            $table->string('name', 100);
            $table->string('employee_number', 20)->nullable();
            $table->foreignId('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->char('gender', 1);
            $table->foreignId('religion_id')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->text('photo')->nullable();
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
        Schema::dropIfExists('master_employees');
    }
}

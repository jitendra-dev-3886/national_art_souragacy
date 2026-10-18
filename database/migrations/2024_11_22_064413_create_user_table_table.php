<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_table', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('First_name');
            $table->string('Last_name');
            $table->string('Post');
            $table->string('designation');
            $table->string('mobile_no');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->integer('stateid')->nullable();
            $table->string('address');
            $table->timestamp('Created_date')->nullable();
            $table->timestamp('Update_date')->nullable();
            $table->integer('Is_Active_and_Deactive');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_table');
    }
};

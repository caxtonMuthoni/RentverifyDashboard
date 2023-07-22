<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('sir_name');
            $table->string('phone_number');
            $table->string('email');
            $table->text('avatar')->nullable();
            $table->unsignedBigInteger('national_id')->nullable();
            $table->text('national_id_front_id')->nullable();
            $table->text('national_id_back_id')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('next_of_kin_location')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->string('next_of_kin_phone_number')->nullable();
            $table->timestamp('next_of_kin_birth_day')->nullable();
            $table->foreignId('landlord_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('Set null');
            $table->boolean('is_complete')->default(false);
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
        Schema::dropIfExists('tenants');
    }
};

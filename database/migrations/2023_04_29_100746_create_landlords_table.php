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
        Schema::create('landlords', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->boolean('is_phone_number_visible')->default(false);
            $table->string('email');
            $table->unsignedBigInteger('allowed_rent_payment_days');
            $table->string('office_location');
            $table->double('security_deposit_percentage');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('Set null');
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
        Schema::dropIfExists('landlords');
    }
};

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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('code');
            $table->string('string_code');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->string('location');
            $table->text('description');
            $table->foreignId('landlord_id')->nullable()->constrained()->onDelete('Set null');
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
        Schema::dropIfExists('apartments');
    }
};

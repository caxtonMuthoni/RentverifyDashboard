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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->text('subject');
            $table->text('message');
            $table->text('reply')->nullable();
            $table->boolean('is_solved')->default(false);
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('landlord_id')->nullable()->constrained()->onDelete('Set null');
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
        Schema::dropIfExists('disputes');
    }
};

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
        Schema::create('defaulters', function (Blueprint $table) {
            $table->id();
            $table->double('amount', 8, 2);
            $table->string('month');
            $table->string('year');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('apartment_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('landlord_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('payment_id')->nullable()->constrained()->onDelete('Set null');
            $table->boolean('has_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('defaulters');
    }
};

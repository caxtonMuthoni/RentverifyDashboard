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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->double('amount', 8, 2);
            $table->string('month');
            $table->string('year');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('Set null');
            $table->text('narration')->nullable();
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('apartment_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('landlord_id')->nullable()->constrained()->onDelete('Set null');
            $table->boolean('is_collected')->default(false);
            $table->timestamp('collected_at')->nullable();
            $table->boolean('has_defualted')->default(false);
            $table->timestamp('defualted_at')->nullable();
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
        Schema::dropIfExists('payments');
    }
};

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
        Schema::create('lease_agreements', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_approved')->default(false);
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('Set null');
            $table->foreignId('landlord_id')->nullable()->constrained()->onDelete('Set null');
            $table->text('unsigned_pdf_path')->nullable();
            $table->text('signed_pdf_path')->nullable();
            $table->text('landlord_signed_pdf_path')->nullable();
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
        Schema::dropIfExists('lease_agreements');
    }
};

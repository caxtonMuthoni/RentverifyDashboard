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
        Schema::create('clearlance_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_room_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('landlord_id')->nullable()->constrained()->onDelete('set null');
            $table->text('unsigned_clearlance_report_path')->nullable();
            $table->boolean('is_processed')->default(false);
            $table->text('clearlance_report_path')->nullable();
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
        Schema::dropIfExists('clearlance_reports');
    }
};

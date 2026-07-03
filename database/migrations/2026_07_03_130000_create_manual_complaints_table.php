<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manual_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('source', 20); // call, paper, direct
            $table->string('complainant_name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('complaint_email')->nullable();
            $table->string('vehicle_number', 20)->nullable();
            $table->foreignId('complain_type_id')->nullable()->constrained('complain_types')->nullOnDelete();
            $table->text('complaint');
            $table->string('status', 20)->default('pending'); // pending, in_progress, closed
            $table->date('received_at')->nullable();
            $table->foreignId('entered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_complaints');
    }
};

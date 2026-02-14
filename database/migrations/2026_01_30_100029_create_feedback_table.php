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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counter_id')->nullable(); // link to DS Division / Counter
            $table->unsignedTinyInteger('rating')->nullable(); // 1-5 rating
            $table->string('service_quality')->nullable();
            $table->enum('has_complaint', ['yes', 'no'])->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('vehicle_number', 20)->nullable();
            $table->text('note')->nullable();

            $table->timestamps();

            $table->foreign('counter_id')->references('id')->on('counters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};

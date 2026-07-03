<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manual_complaint_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('manual_complaint_sources')->insert([
            ['name' => 'Call', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paper Box', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Direct', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_complaint_sources');
    }
};

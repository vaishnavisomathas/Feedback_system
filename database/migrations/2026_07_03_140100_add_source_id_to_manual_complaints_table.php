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
        Schema::table('manual_complaints', function (Blueprint $table) {
            if (!Schema::hasColumn('manual_complaints', 'source_id')) {
                $table->foreignId('source_id')->nullable()->after('source')->constrained('manual_complaint_sources')->nullOnDelete();
            }
        });

        $defaultSourceId = DB::table('manual_complaint_sources')->where('name', 'Direct')->value('id');

        if ($defaultSourceId) {
            DB::table('manual_complaints')
                ->whereNull('source_id')
                ->update(['source_id' => $defaultSourceId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manual_complaints', function (Blueprint $table) {
            if (Schema::hasColumn('manual_complaints', 'source_id')) {
                $table->dropConstrainedForeignId('source_id');
            }
        });
    }
};

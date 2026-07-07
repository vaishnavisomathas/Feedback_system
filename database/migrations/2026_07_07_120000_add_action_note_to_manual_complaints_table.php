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
        Schema::table('manual_complaints', function (Blueprint $table) {
            if (!Schema::hasColumn('manual_complaints', 'action_note')) {
                $table->text('action_note')->nullable()->after('complaint');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manual_complaints', function (Blueprint $table) {
            if (Schema::hasColumn('manual_complaints', 'action_note')) {
                $table->dropColumn('action_note');
            }
        });
    }
};

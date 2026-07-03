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
            if (!Schema::hasColumn('manual_complaints', 'ao_remarks')) {
                $table->text('ao_remarks')->nullable()->after('status');
            }

            if (!Schema::hasColumn('manual_complaints', 'commissioner_remarks')) {
                $table->text('commissioner_remarks')->nullable()->after('ao_remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manual_complaints', function (Blueprint $table) {
            if (Schema::hasColumn('manual_complaints', 'commissioner_remarks')) {
                $table->dropColumn('commissioner_remarks');
            }

            if (Schema::hasColumn('manual_complaints', 'ao_remarks')) {
                $table->dropColumn('ao_remarks');
            }
        });
    }
};

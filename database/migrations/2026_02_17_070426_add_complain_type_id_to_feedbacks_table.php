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
        Schema::table('feedbacks', function (Blueprint $table) {
              if (!Schema::hasColumn('feedbacks', 'complain_type_id')) {

                $table->foreignId('complain_type_id')
                    ->nullable()
                    ->constrained('complain_types')
                    ->nullOnDelete();

            }

        });
    }

    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {

            if (Schema::hasColumn('feedbacks', 'complain_type_id')) {
                $table->dropForeign(['complain_type_id']);
                $table->dropColumn('complain_type_id');
            }

        });
    }
};

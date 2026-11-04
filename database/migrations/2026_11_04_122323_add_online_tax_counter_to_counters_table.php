<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Counter;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Counter::firstOrCreate(
            [
                'division_name' => 'Online Services',
                'counter_name' => 'Online Tax',
            ],
            [
                'district' => 'Northern Province',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Counter::where('division_name', 'Online Services')
            ->where('counter_name', 'Online Tax')
            ->delete();
    }
};

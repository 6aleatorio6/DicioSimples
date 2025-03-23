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
        Schema::table('words', function (Blueprint $table) {
            $table->enum('status', ['COMPLETED', 'PARTIAL', 'FAILED', 'UNKNOWN', 'PROCESSING'])
                ->default('pending');
        });

        DB::table('words')->whereNull('meanings')->update(['status' => 'PARTIAL']);
        DB::table('words')->whereNotNull('meanings')->update(['status' => 'COMPLETED']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

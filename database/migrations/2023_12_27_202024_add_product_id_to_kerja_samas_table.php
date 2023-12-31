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
        Schema::table('kerja_samas', function (Blueprint $table) {
            $table->foreignId('kerjasama_id')->nullable()->constrained('kerja_samas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kerja_samas', function (Blueprint $table) {
            $table->dropColumn('kerjasama_id');
        });
    }
};

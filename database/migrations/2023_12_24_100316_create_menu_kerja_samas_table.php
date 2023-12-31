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
        Schema::create('kerja_samas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('masa_kerja_sama');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('nilai_kerja_sama_bulanan', 19, 2);
            $table->decimal('nilai_kerja_sama_semester', 19, 2);
            $table->decimal('nilai_kerja_sama_tahunan', 19, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerja_samas');
    }
};

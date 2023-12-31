<?php

use App\Models\ProdukKerjaSama;
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
        Schema::create('fitur_kerja_samas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_kerja_sama_id')->constrained('produk_kerja_samas')->cascadeOnDelete();
            $table->foreignId('fitur_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitur_kerja_samas');
    }
};

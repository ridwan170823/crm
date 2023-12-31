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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nama_institusi');
            $table->string('nama_penanggung_jawab');
            $table->string('nik_penanggung_jawab');
            $table->string('nip_penanggung_jawab');
            $table->string('alamat');
            $table->string('email');
            $table->string('no_hp_institusi');
            $table->string('no_hp_penanggung_jawab');
            $table->string('jabatan_penanggung_jawab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

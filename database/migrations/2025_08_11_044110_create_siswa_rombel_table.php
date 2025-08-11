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
        Schema::create('siswa_rombel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombel')->onDelete('cascade');
            $table->integer('tahun_ajaran');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->date('tanggal_masuk_rombel');
            $table->date('tanggal_keluar_rombel')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['siswa_id', 'rombel_id', 'tahun_ajaran', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_rombel');
    }
};

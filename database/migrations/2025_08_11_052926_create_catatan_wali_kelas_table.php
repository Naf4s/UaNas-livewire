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
        Schema::create('catatan_wali_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained('rombel')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('wali_kelas_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_catatan', ['akademik', 'non_akademik', 'perilaku', 'kehadiran', 'lainnya'])->default('akademik');
            $table->text('catatan');
            $table->enum('kategori', ['positif', 'negatif', 'netral'])->default('netral');
            $table->date('tanggal_catatan');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->integer('tahun_ajaran');
            $table->boolean('dibaca_ortu')->default(false);
            $table->date('tanggal_dibaca_ortu')->nullable();
            $table->text('tanggapan_ortu')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['rombel_id', 'semester', 'tahun_ajaran']);
            $table->index(['siswa_id', 'jenis_catatan']);
            $table->index(['wali_kelas_id', 'tanggal_catatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_wali_kelas');
    }
};

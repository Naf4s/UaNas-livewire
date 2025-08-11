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
        Schema::create('usulan_kenaikan_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained('rombel')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('wali_kelas_id')->constrained('users')->onDelete('cascade');
            $table->enum('status_usulan', ['naik_kelas', 'tinggal_di_kelas', 'lulus', 'tidak_lulus'])->default('naik_kelas');
            $table->text('alasan_usulan');
            $table->text('rekomendasi')->nullable();
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->integer('tahun_ajaran');
            $table->date('tanggal_usulan');
            $table->enum('status_approval', ['pending', 'disetujui', 'ditolak', 'revisi'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal_approval')->nullable();
            $table->text('catatan_approval')->nullable();
            $table->enum('status_final', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi usulan
            $table->unique(['rombel_id', 'siswa_id', 'semester', 'tahun_ajaran'], 'unique_usulan_kenaikan');
            
            // Index untuk optimasi query
            $table->index(['rombel_id', 'semester', 'tahun_ajaran']);
            $table->index(['siswa_id', 'status_final']);
            $table->index(['wali_kelas_id', 'tanggal_usulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_kenaikan_kelas');
    }
};

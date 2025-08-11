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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained('rombel')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alpha', 'terlambat'])->default('hadir');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->integer('tahun_ajaran');
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi absensi
            $table->unique(['rombel_id', 'siswa_id', 'tanggal'], 'unique_absensi');
            
            // Index untuk optimasi query
            $table->index(['rombel_id', 'tanggal']);
            $table->index(['siswa_id', 'semester', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};

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
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mapel')->unique();
            $table->string('nama_mapel');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis', ['Wajib', 'Peminatan', 'Lintas Minat', 'Muatan Lokal'])->default('Wajib');
            $table->integer('jumlah_jam')->default(2); // Jam per minggu
            $table->enum('kelompok', ['A', 'B', 'C'])->default('A'); // Kelompok mata pelajaran
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};

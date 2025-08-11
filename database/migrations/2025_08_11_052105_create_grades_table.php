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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_kurikulum_id')->constrained('template_kurikulum')->onDelete('cascade');
            $table->foreignId('aspek_penilaian_id')->constrained('aspek_penilaian')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombel')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->integer('tahun_ajaran');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->enum('jenis_penilaian', ['Harian', 'Tugas', 'UTS', 'UAS', 'Praktik', 'Proyek', 'Portofolio'])->default('Harian');
            $table->string('nilai')->nullable(); // Untuk nilai huruf atau deskripsi
            $table->decimal('nilai_angka', 5, 2)->nullable(); // Untuk nilai angka
            $table->text('catatan')->nullable();
            $table->date('tanggal_penilaian');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi nilai
            $table->unique([
                'template_kurikulum_id', 
                'aspek_penilaian_id', 
                'mata_pelajaran_id', 
                'rombel_id', 
                'siswa_id', 
                'guru_id', 
                'tahun_ajaran', 
                'semester', 
                'jenis_penilaian'
            ], 'unique_grade');
            
            // Index untuk optimasi query
            $table->index(['rombel_id', 'mata_pelajaran_id', 'tahun_ajaran', 'semester']);
            $table->index(['siswa_id', 'jenis_penilaian']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};

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
        Schema::create('grade_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_kurikulum_id')->constrained('template_kurikulum')->onDelete('cascade');
            $table->foreignId('aspek_penilaian_id')->constrained('aspek_penilaian')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->enum('input_type', ['number', 'select', 'text', 'checkbox', 'radio'])->default('number');
            $table->decimal('nilai_min', 5, 2)->default(0.00);
            $table->decimal('nilai_max', 5, 2)->default(100.00);
            $table->decimal('nilai_lulus', 5, 2)->default(75.00);
            $table->json('options')->nullable(); // Untuk opsi select, radio, checkbox
            $table->string('satuan')->nullable(); // Misal: poin, persen, skala
            $table->text('deskripsi_input')->nullable();
            $table->boolean('wajib_diisi')->default(true);
            $table->boolean('bisa_diubah')->default(true);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Unique constraint
            $table->unique([
                'template_kurikulum_id', 
                'aspek_penilaian_id', 
                'mata_pelajaran_id'
            ], 'unique_grade_setting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_settings');
    }
};

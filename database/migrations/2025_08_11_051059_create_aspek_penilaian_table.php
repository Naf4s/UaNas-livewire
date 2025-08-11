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
        Schema::create('aspek_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_kurikulum_id')->constrained('template_kurikulum')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('aspek_penilaian')->onDelete('cascade');
            $table->string('nama_aspek');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['domain', 'aspek', 'indikator'])->default('domain');
            $table->integer('urutan')->default(0);
            $table->decimal('bobot', 5, 2)->default(0.00); // Bobot dalam persentase
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Index untuk optimasi query hierarki
            $table->index(['template_kurikulum_id', 'parent_id']);
            $table->index(['template_kurikulum_id', 'tipe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspek_penilaian');
    }
};

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
        Schema::create('template_kurikulum', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_kurikulum', ['K13', 'Kurikulum Merdeka', 'Kurikulum 2024'])->default('K13');
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif');
            $table->integer('tahun_berlaku')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_kurikulum');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_masyarakat');
            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('masyarakat')->onDelete('cascade');
            $table->string('judul', 100);
            $table->text('isi_laporan');
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};
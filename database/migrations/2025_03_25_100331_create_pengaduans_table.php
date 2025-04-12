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
            $table->text('judul');
            $table->text('isi_laporan');
            $table->string('foto')->nullable();
            $table->date('tanggal_kejadian');
            $table->string('lokasi_kejadian');
            $table->boolean('anonim')->default(false);
            $table->string('status')->default('pending');
            $table->timestamps();

        $table->foreign('id_masyarakat')->references('id_masyarakat')->on('masyarakat')->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};
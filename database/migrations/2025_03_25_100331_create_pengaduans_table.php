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
        $table->string('status')->default('pending');
        $table->string('foto')->nullable();
        $table->timestamps();

        $table->foreign('id_masyarakat')->references('id_masyarakat')->on('masyarakat')->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};
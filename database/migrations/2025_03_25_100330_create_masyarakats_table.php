<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->id('id_masyarakat'); // Gunakan id() dengan parameter nama kolom
            $table->string('nik', 16)->unique();
            $table->string('nama', 100);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('telp', 15);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('masyarakat');
    }
};
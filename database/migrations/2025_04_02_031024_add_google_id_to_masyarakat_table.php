<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('id_masyarakat');
            $table->string('email')->nullable(); // Menambah kolom email, bisa null
        });
    }

    public function down()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('email');
        });
    }

};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('masyarakat', function (Blueprint $table) {
        $table->string('token')->nullable()->after('email');  // Menambahkan kolom 'token'
    });
}

public function down()
{
    Schema::table('masyarakat', function (Blueprint $table) {
        $table->dropColumn('token');  // Menghapus kolom 'token' jika rollback
    });
}

};

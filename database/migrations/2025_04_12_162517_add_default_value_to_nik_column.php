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
            $table->string('nik')->default('NIK_DEFAULT_VALUE')->change();  // Set default value
        });
    }
    
    public function down()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->string('nik')->nullable(false)->change();  // Hapus default value
        });
    }
    
};

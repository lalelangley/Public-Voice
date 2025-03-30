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
        Schema::table('tanggapan', function (Blueprint $table) {
            $table->timestamp('tgl_tanggapan')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tanggapan', function (Blueprint $table) {
            $table->dropColumn('tgl_tanggapan');
        });
    }    
};

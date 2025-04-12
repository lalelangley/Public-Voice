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
            if (!Schema::hasColumn('masyarakat', 'google_id')) {
                $table->string('google_id')->nullable()->after('id_masyarakat');
            }
        });
    }
    
    public function down()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->dropColumn('google_id');
        });
    }
    
};

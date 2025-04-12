<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToMasyarakatTable extends Migration
{
    public function up()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->string('email')->unique();
        });
    }
    
    public function down()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}


<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMasyarakatTable extends Migration
{
    public function up()
    {

        Schema::table('masyarakat', function (Blueprint $table) {
            $table->string('bio')->nullable();
            $table->string('tempat_tinggal')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('disabilitas')->nullable();
        });
        
    }

    public function down()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_tinggal',
                'tanggal_lahir',
                'jenis_kelamin',
                'pekerjaan',
                'disabilitas',
                'email'
            ]);
        });
    }
}

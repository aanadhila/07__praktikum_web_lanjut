<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahKolomMahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('mahasiswa', function (Blueprint $table) {
        //     $table->string('email')->after('nama')->unique();
        //     $table->date('tanggal_lahir')->after('email')->nullable();
        //     $table->string('alamat')->after('tanggal_lahir')->nullable();

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('mahasiswa', function (Blueprint $table) {
        //     $table->dropColumn('email');
        //     $table->dropColumn('tanggal_lahir');
        //     $table->dropColumn('alamat');
        // });
    }
}

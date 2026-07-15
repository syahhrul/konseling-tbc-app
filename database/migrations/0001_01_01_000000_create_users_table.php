<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['Laki-laki', 'Perempuan', 'Lainnya']);
            $table->integer('usia')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan', 'Lainnya'])->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->string('nomor_wa_pasien')->nullable();
            $table->string('nomor_wa_pmo')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('role')->default('pengguna'); 
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

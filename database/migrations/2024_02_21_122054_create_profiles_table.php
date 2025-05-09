<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->string('no_ktp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('no_sertifikat')->nullable();
            $table->string('masa_berlaku_sertifikat')->nullable();
            $table->string('tingkatan')->nullable();
            $table->string('sekolah_terakhir')->nullable();
            $table->text('file_ktp')->nullable();
            $table->text('file_sertifikat_andalalin')->nullable();
            $table->text('file_cv')->nullable();
            $table->text('file_sk_kepala_dinas')->nullable();
            $table->text('file_sertifikat')->nullable();
            $table->text('file_ijazah_terakhir')->nullable();
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
        Schema::dropIfExists('profiles');
    }
};

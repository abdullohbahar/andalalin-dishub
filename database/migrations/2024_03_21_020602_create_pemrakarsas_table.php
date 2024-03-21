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
        Schema::create('pemrakarsas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_id')->nullable();
            $table->foreign('pengajuan_id')->references('id')->on('pengajuans')->nullOnDelete();
            $table->string('pemrakarsa')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat')->nullable();
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
        Schema::dropIfExists('pemrakarsas');
    }
};

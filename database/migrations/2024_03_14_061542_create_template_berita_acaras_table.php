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
        Schema::create('template_berita_acaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_rencana_id')->nullable();
            $table->foreign('jenis_rencana_id')->references('id')->on('jenis_rencana_pembangunans')->nullOnDelete();
            $table->text('body');
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
        Schema::dropIfExists('template_berita_acaras');
    }
};

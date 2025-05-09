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
        Schema::table('template_berita_acaras', function (Blueprint $table) {
            $table->text('parent_id')->after('jenis_rencana_id')->nullable();
            $table->text('tipe')->after('parent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('template_berita_acaras', function (Blueprint $table) {
            //
        });
    }
};

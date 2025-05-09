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
            $table->longText('body_konstruksi')->after('body')->nullable();
            $table->longText('body_prakonstruksi')->after('body')->nullable();
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

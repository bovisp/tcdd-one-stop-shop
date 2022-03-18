<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodleMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moodle_medias', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->string('media');
            $table->json('keywords');
            $table->unsignedBigInteger('license_id');
            $table->timestamps();

            $table->foreign('license_id', 'FK_license_id')
                ->references('id')
                ->on('moodle_media_licenses')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moodle_medias');
    }
}

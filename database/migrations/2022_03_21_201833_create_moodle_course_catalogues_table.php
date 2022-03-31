<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodleCourseCataloguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moodle_course_catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->date('publish_date');
            $table->string('title');
            $table->longText('objective')->nullable();
            $table->string('completion_time')->nullable();
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
        Schema::table('moodle_course_catalogues', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodleCourseLanguagesTable extends Migration
{
    public function up() : void
    {
        Schema::create('moodle_course_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('language_id');

            $table->foreign('course_id', 'FK_course_id')
                ->references('id')
                ->on('moodle_courses')
                ->onDelete('cascade');

            $table->foreign('language_id', 'FK_language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('moodle_course_languages');
    }
}

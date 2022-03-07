<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodleCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moodle_courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('course_name');
            $table->unsignedBigInteger('category_id');
            $table->string('languages');
            $table->date('publish_date');
            $table->string('presenters');
            $table->string('tags');
            $table->string('minimum_estimated_time');
            $table->string('maximum_estimated_time')->nullable();
            $table->string('objectives');
            $table->string('descriptions');
            $table->timestamps();

            $table->foreign('category_id', 'FK_category_id')
                ->references('id')
                ->on('course_categories')
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
        Schema::dropIfExists('moodle_courses');
    }
}

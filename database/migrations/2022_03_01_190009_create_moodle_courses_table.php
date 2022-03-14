<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodleCoursesTable extends Migration
{
    public function up() : void
    {
        Schema::create('moodle_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('course_name_en');
            $table->string('course_name_fr');
            $table->text('description_en');
            $table->text('description_fr');
            $table->unsignedBigInteger('category_id');
            $table->date('publish_date');
            $table->json('presenters')->nullable();
            $table->json('keywords_en')->nullable();
            $table->json('keywords_fr')->nullable();
            $table->integer('minimum_estimated_time')->comment('in minutes');
            $table->integer('maximum_estimated_time')->nullable()->comment('in minutes');
            $table->json('objectives_topics')->nullable();
            $table->timestamps();

            $table->foreign('category_id', 'FK_category_id')
                ->references('id')
                ->on('course_categories')
                ->onDelete('cascade');
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('moodle_courses');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursecategoriesMoodlecoursecataloguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecategories_moodlecoursecatalogues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_category_id');
            $table->unsignedBigInteger('moodle_course_catalogue_id');

            $table->foreign('course_category_id','course_category_id')
                ->references('id')
                ->on('course_categories')
                ->onDelete('cascade');

            $table->foreign('moodle_course_catalogue_id','moodle_course_catalogue_id')
                ->references('id')
                ->on('moodle_course_catalogues')
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
        Schema::dropIfExists('coursecategories_mdlcoursecatalogues');
    }
}

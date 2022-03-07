<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsAttendanceTable extends Migration
{
    public function up() : void
    {
        Schema::create('webinars_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webinar_id');
            $table->unsignedBigInteger('language_id')->nullable();
            $table->string('name');
            $table->integer('attendance');
            $table->timestamps();

            $table->foreign('webinar_id', 'FK_webinars_attendance_webinar_id')
                ->references('id')
                ->on('webinars')
                ->onDelete('cascade');

            $table->foreign('language_id', 'FK_webinars_attendance_language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('set null');
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('webinars_attendance');
    }
}

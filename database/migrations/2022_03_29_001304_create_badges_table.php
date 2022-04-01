<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    public function up() : void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('moodle_id');
            $table->json('name');
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('badges');
    }
}

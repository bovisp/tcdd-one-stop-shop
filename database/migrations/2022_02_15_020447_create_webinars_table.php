<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsTable extends Migration
{
    public function up() : void
    {
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->nullable();
            $table->unsignedBigInteger('fiscal_year_id')->nullable();
            $table->unsignedBigInteger('quarter_id')->nullable();
            $table->timestamps();

            $table->foreign('fiscal_year_id', 'FK_webinars_fiscal_year_id')
                ->references('id')
                ->on('fiscal_years')
                ->onDelete('set null');

            $table->foreign('quarter_Id', 'FK_webinars_quarter_id')
                ->references('id')
                ->on('quarters')
                ->onDelete('set null');
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('webinars');
    }
}

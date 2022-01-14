<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportingStructurePositionsTable extends Migration
{
    public function up() : void
    {
        Schema::create('reporting_structure_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('role_id');
            $table->integer('hierarchy_position');
            $table->timestamps();

            $table->foreign('section_id', 'FK_reporting_structure_positions_section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');

            $table->foreign('role_id', 'FK_reporting_structure_positions_role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('reporting_structure_positions');
    }
}

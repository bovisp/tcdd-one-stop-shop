<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionIdToUsersTable extends Migration
{
    public function up() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id')->nullable()->after('role_id');

            $table->foreign('section_id', 'FK_users_section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('set null');
        });
    }

    public function down() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('section_id');
        });
    }
}

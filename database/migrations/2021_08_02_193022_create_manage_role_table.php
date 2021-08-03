<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('manage_id');
            $table->boolean('read')->default(0);
            $table->boolean('add')->default(0);
            $table->boolean('update')->default(0);
            $table->boolean('delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_role');
    }
}

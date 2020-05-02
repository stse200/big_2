<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string("name", 25);
            $table->integer("fkey_p1_id");
            $table->integer("fkey_p2_id");
            $table->integer("fkey_p3_id");
            $table->integer("fkey_p4_id");
            $table->boolean("p1_online");
            $table->boolean("p2_online");
            $table->boolean("p3_online");
            $table->boolean("p4_online");
            $table->timestamps();
            $table->softDeletes("deleted_at", 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}

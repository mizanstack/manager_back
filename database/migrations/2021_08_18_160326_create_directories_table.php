<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirectoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        // $file = realpath(__DIR__.'/../catalogs/directories.sql');
        // DB::unprepared( file_get_contents($file) );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('directories');
    }
}

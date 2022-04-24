<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('navbar_id')->nullable();
            $table->integer('ordering')->nullable();
            $table->text('text')->nullable();
            $table->text('html')->nullable();
            $table->boolean('deletable')->default(true);
            $table->string('title');
            $table->string('slug')->index()->unique()->nullable();
        });

        $seeder = new \Database\Seeders\PageSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}

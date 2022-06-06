<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_blocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('done_at')->nullable();
            $table->integer('block_id')->unsigned()->index();
            $table->integer('user_course_id')->unsigned()->index();
            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_links');
    }
}

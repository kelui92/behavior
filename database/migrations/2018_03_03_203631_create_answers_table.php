<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('questions_id')->unsigned()->nullable();
            $table->string('answer', 255);
            $table->timestamps();
            
            $table->index('questions_id');
        });
            
        Schema::table('answers', function (Blueprint $table) {    
            /*
             * foreign key
             * answers_questions_id_foreign
             * 
             * if id in questions table updates then need to update in our answers table.
             * if id in questions table deletes then need to delete in our answers table which will set the answers_id in user_answers table to null.
             * 
             */
            $table->foreign('questions_id')
                    ->references('id')
                    ->on('questions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}

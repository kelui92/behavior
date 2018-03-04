<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->unsigned()->nullable();
            $table->integer('questions_id')->unsigned()->nullable();
            $table->integer('answers_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->index('users_id');
            $table->index('questions_id');
        });
        
        Schema::table('user_answers', function (Blueprint $table) {
            
            /*
             * foreign key
             * user_answers_users_id_foreign
             * 
             * if id in users table updates then need to update in our user_answers table.
             * if id in users table deletes then need to set null to indicate "deleted" user.
             * 
             */
            $table->foreign('users_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            
            /*
             * foreign key
             * user_answers_questions_id_foreign
             * 
             * if id in questions table updates then need to update in our user_answers table.
             * if id in questions table deletes then need to set null to indicate "deleted" question.
             * 
             */
            $table->foreign('questions_id')
                    ->references('id')
                    ->on('questions')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            
            /*
             * foreign key
             * user_answers_answers_id_foreign
             * 
             * if id in answers table updates then need to update in our user_answers table.
             * if id in answers table deletes then need to set null to indicate "deleted" answer.
             * 
             */
            $table->foreign('answers_id')
                    ->references('id')
                    ->on('answers')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_answers');
    }
}

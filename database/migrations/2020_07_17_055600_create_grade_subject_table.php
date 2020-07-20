<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')
                ->constrained('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('subject_id')
                ->constrained('subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['grade_id','subject_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_subject');
    }
}

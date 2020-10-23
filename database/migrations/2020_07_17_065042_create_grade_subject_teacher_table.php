<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeSubjectTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_subject_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_subject_id')
                ->constrained('grade_subject')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->unique(['grade_subject_id','teacher_id']);
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
        Schema::dropIfExists('grade_subject_teacher');
    }
}

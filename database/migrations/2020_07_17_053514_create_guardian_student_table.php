<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardianStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardian_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardian_id')
                ->constrained('guardians')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('relation_to_student')->nullable();
            $table->unique(['guardian_id','student_id']);
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
        Schema::dropIfExists('guardian_student');
    }
}

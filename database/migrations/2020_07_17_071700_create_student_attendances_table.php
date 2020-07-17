<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_calendar_id')
                ->constrained('school_calendars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('grade_subjects_id')
                ->constrained('grade_subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_present')->default(True);
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
        Schema::dropIfExists('student_attendances');
    }
}

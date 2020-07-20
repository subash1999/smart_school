<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')
                ->constrained('exams')
                ->onDelete('cascade')
                ->OnUpdate('cascade');
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade')
                ->OnUpdate('cascade');
//           Null marks_obtained for the absent student
            $table->float('marks_obtained')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('marks');
    }
}

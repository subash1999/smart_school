<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamGroupExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_group_exam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_exam_group_id')
                ->constrained('exam_groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('exam_group_id')
                ->nullable()
                ->constrained('exam_groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('exam_id')
                ->nullable()
                ->constrained('exams')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('alternative_exam_name')->nullable();
            $table->float('conversion_percentage')->default('100');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('exam_group_exam');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_groups', function (Blueprint $table) {
            $table->id();
            $table->string('exam_group_name');
            $table->string('result_publish_timestamp')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('school_session_id')
                ->nullable()
                ->constrained('school_sessions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('exam_groups');
    }
}

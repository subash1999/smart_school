<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender',['Male','Female','Other',null])->default(null);
            $table->integer('roll_no')->nullable();
            $table->string('passport_photo')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Nepal');
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('school_session_id')
                ->unique()
                ->nullable()
                ->constrained('school_sessions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('grade_id')
                ->unique()
                ->nullable()
                ->constrained('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('has_left')->default(False);
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
        Schema::dropIfExists('students');
    }
}

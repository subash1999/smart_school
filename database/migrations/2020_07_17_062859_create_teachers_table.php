<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender',['Male','Female','Other',null])->default(null);
            $table->string('passport_photo')->nullable()->default('https://via.placeholder.com/200.png?text=Teacher');
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->default('Nepal');
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('school_id')
                ->constrained('schools')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('joined_at')->nullable()->default(now());
            $table->boolean('has_left')->default(False);
            $table->text('description')->nullable();
            $table->unique(['user_id','school_id']);
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
        Schema::dropIfExists('teachers');
    }
}

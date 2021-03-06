<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender',['Male','Female','Other',null])->default(null);
            $table->string('passport_photo')->nullable()->default('https://via.placeholder.com/200.png?text=School+Admin');
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->default('Nepal');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('school_id')
                ->nullable()
                ->constrained('schools')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('school_admins');
    }
}

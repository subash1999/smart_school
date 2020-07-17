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
            $table->string('passport_photo')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Nepal');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
                ->unique()
                ->nullable()
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('school_id')
                ->constrained('schools')
                ->unique()
                ->nullable()
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
        Schema::dropIfExists('school_admins');
    }
}

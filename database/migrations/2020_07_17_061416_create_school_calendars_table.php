<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_session_id')
                ->constrained('school_sessions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('date');
            $table->boolean('is_school_day')->default(true);
            $table->text('description')->nullable();
            $table->unique(['school_session_id','date']);
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
        Schema::dropIfExists('school_calendars');
    }
}

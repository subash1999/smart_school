<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_calendar_id')
                ->constrained('school_calendars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('event_name');
            $table->string('event_color')->nullable();
            $table->integer('priority')->nullable();
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
        Schema::dropIfExists('school_events');
    }
}

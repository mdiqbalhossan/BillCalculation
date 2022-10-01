<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->string('introducer_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->string('guardian_contact')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('image')->nullable();
            $table->string('university_name')->nullable();
            $table->string('department')->nullable();
            $table->string('batch')->nullable();
            $table->string('student_id')->nullable();
            $table->string('room_no')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('members');
    }
}

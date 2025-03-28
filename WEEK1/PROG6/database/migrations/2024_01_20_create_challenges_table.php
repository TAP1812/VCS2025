<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->text('hint');
            $table->string('file_path');
            $table->timestamps();
        });

        Schema::create('challenge_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('challenge_id')->constrained('challenges');
            $table->enum('status', ['solved', 'not solved'])->default('not solved');
            $table->timestamp('solved_at')->nullable();
            $table->unique(['student_id', 'challenge_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('challenge_status');
        Schema::dropIfExists('challenges');
    }
};

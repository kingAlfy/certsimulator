<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_number');
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('exam_id');
            $table->text('question_text');
            $table->text('choices')->nullable();
            $table->string('solution')->nullable();
            $table->text('solution_description')->nullable();
            $table->timestamps();

            $table->unique(['question_number', 'topic_id', 'exam_id']);
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};

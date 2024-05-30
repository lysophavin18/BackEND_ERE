<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('report_item_id');
            $table->integer('classroom_id');
            $table->dateTime('month_id');
            $table->string('issued_by');
            $table->string('update_by');
            $table->string('accepted');
            $table->string('teacher_cmt');
            $table->string('parent_cmt');
            $table->string('is_sent');
            $table->string('total_score');
            $table->string('abs');
            $table->string('permission');
            $table->dateTime('issued_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

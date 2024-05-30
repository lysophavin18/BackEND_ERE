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
        Schema::create('subject__items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('max_score');
            $table->integer('passing_score');
            $table->integer('subject_id');
            $table->integer('classroom_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject__items');
    }
};

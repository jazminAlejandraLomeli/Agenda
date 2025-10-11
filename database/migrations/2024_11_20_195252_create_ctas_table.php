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
        Schema::create('ctas', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('num_participants');
            $table->boolean('published')->default(false);
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('ctas', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['semester_id']);
        });

        Schema::dropIfExists('ctas');
    }
};

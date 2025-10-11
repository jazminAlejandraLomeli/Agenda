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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('type_id')->constrained('event_types');
            $table->foreignId('dependency_program_id')->constrained('dependency_programs');
            $table->foreignId('place_id')->constrained('places');
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('date_id')->constrained('dates');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['dependency_program_id']);
            $table->dropForeign(['place_id']);
            $table->dropForeign(['created_by']);
        });

        Schema::dropIfExists('events');
    }
};

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
        Schema::create('event_calendar', function (Blueprint $table) {
            $table->id();
            $table->string('google_event_id')->nullable(); // store Google Event ID for updates/deletes
            $table->string('summary');
            $table->string('hangoutLink')->nullable();
            $table->string('htmlLink')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->json('attendees')->nullable();
            $table->foreignId('master_class_id')->nullable()->constrained('master_classes')->onDelete('cascade');
            $table->foreignId('master_class_session_id')->nullable()->constrained('master_class_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_calendar');
    }
};

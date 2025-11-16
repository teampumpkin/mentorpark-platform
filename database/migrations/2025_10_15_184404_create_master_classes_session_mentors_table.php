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
        Schema::create('master_classes_session_mentors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_class_id')->nullable()->constrained('master_classes')->onDelete('cascade');
            $table->foreignId('session_id')->nullable()->constrained('master_class_sessions')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->boolean('isAccepted')->nullable();
            $table->date('accepted_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_classes_session_mentors');
    }
};

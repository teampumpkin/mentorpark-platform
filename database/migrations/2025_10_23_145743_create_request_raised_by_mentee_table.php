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
        Schema::create('request_raised_by_mentee', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('mentee_id');
            $table->unsignedBigInteger('mentor_id')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('master_class_id')->nullable();

            // Request details
            $table->json('sessions')->nullable();
            $table->string('complete_master_class')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('responded_at')->nullable();

            // Optional: to track who created/updated
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('mentee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_raised_by_mentee');
    }
};

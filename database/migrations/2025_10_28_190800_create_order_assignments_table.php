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
        Schema::create('order_assignments', function (Blueprint $table) {
            $table->id();

            // Core Relations
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            $table->foreignId('organizer_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->comment('Organizer who assigned the task');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->comment('User/mentee assigned for this task');

            $table->foreignId('master_class_id')
                ->nullable()
                ->constrained('master_classes')
                ->onDelete('set null');

            $table->foreignId('session_id')
                ->nullable()
                ->constrained('master_class_sessions')
                ->onDelete('set null');

            // File Exchange System (both organizer & user uploads)
            $table->string('user_file_path')->nullable()->comment('File uploaded by user');
            $table->string('user_file_name')->nullable();
            $table->string('user_file_mime')->nullable();
            $table->unsignedBigInteger('user_file_size')->nullable();

            $table->string('organizer_file_path')->nullable()->comment('File reuploaded by organizer for redo');
            $table->string('organizer_file_name')->nullable();
            $table->string('organizer_file_mime')->nullable();
            $table->unsignedBigInteger('organizer_file_size')->nullable();

            // Assignment Workflow
            $table->enum('status', [
                'assigned',        // when organizer gives assignment
                'uploaded',        // when user uploads assignment
                'under_review',    // organizer reviewing
                'redo',            // organizer requests reupload
                'submitted',       // organizer marks final submission done
            ])->default('assigned')->comment('Assignment workflow status');

            $table->text('remarks')->nullable()->comment('Remarks for redo or review feedback');
            $table->timestamp('user_uploaded_at')->nullable();
            $table->timestamp('organizer_reviewed_at')->nullable();
            $table->timestamp('final_submitted_at')->nullable();

            // Activity tracking
            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->comment('Last user who uploaded file');

            // Audit
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_assignments');
    }
};

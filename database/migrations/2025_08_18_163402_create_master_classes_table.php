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
        Schema::create('master_classes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('timezone')->nullable();
            $table->string('banner_image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->integer('discount_value')->nullable();
            $table->boolean('hide_price')->nullable();
            $table->boolean('whatsapp_notification')->nullable();
            $table->boolean('email_notification')->nullable();
            $table->foreignId('organization_id')->nullable()->constrained('organization')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('isDraft')->nullable();
            $table->boolean('isActive')->nullable();
            $table->timestamps();
        });

        Schema::create('master_class_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_class_id')->nullable()->constrained('master_classes')->onDelete('cascade');
            $table->string('session_type');
            $table->integer('seat_capacity_min')->nullable();
            $table->integer('seat_capacity_max')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->json('skills')->nullable();
            $table->datetime('start_date_time')->nullable();
            $table->datetime('end_date_time')->nullable();
            $table->text('session_description')->nullable();
            $table->decimal('session_price', 12, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->integer('session_price_discount')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('venue_address')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('isActive')->nullable();
            $table->timestamps();
        });


        Schema::create('master_class_session_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_class_id')->nullable()->constrained('master_classes')->onDelete('cascade');
            $table->foreignId('master_class_session_id')->nullable()->constrained('master_class_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('attachment_path');
            $table->string('file_name')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_extension')->nullable();
            $table->timestamps();
        });

        Schema::create('master_class_mentees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_class_id')->nullable()->constrained('master_classes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->timestamps();

            $table->unique(['master_class_id', 'user_id']);
        });

        Schema::create('master_class_session_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_class_id')->nullable()->constrained('master_classes')->onDelete('cascade');
            $table->foreignId('session_id')->nullable()->constrained('master_class_sessions')->onDelete('cascade');
            $table->string('feedback_type');
            $table->string('feedback_question')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_feedbacks');
        Schema::dropIfExists('master_class_mentees');
        Schema::dropIfExists('session_attachments');
        Schema::dropIfExists('master_class_sessions');
        Schema::dropIfExists('master_classes');
    }
};

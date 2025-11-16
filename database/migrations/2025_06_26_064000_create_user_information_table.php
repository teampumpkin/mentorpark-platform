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
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('organization_id')->nullable()->constrained('organization')->onDelete('cascade');
            $table->json('user_type')->nullable();
            $table->text('about')->nullable();
            $table->text('organization_name')->nullable();
            $table->text('additional_description')->nullable();
            $table->string('job_title')->nullable();
            $table->string('total_experience')->nullable();
            $table->json('skills')->nullable();
            $table->text('goal')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('website')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('profile_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_information');
    }
};

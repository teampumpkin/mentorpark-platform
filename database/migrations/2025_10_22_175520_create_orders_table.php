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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderId')->unique();
            $table->string('purchase_orderId')->nullable();
            // Buyer details
            $table->unsignedBigInteger('user_id');

            // What type of purchase: 'master_class' or 'session'
            $table->enum('order_type', ['master_class', 'session']);

            // Reference IDs (nullable depending on type)
            $table->unsignedBigInteger('master_class_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();

            // Snapshot data (to preserve history if masterclass/session changes)
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('original_price', 12, 2)->nullable();
            $table->decimal('discount_value', 12, 2)->nullable();
            $table->decimal('final_price', 12, 2);
            $table->string('discount_type')->nullable(); // percent/fixed
            $table->string('timezone')->nullable();

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();

            // Payment info
            $table->string('payment_status')->default('pending'); // pending, completed, failed, refunded
            $table->string('payment_method')->nullable(); // razorpay, stripe, etc.
            $table->string('transaction_id')->nullable(); // external payment gateway ref
            $table->string('razorpay_order_id')->nullable(); // external payment gateway ref
            $table->string('razorpay_payment_id')->nullable(); // external payment gateway ref
            $table->string('razorpay_signature')->nullable(); // external payment gateway ref
            // Ownership
            $table->unsignedBigInteger('organization_id')->nullable();
            // Metadata
            $table->boolean('isActive')->default(true);

            // Foreign keys (optional, no cascading to preserve history)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('master_class_id')->references('id')->on('master_classes')->nullOnDelete();
            $table->foreign('session_id')->references('id')->on('master_class_sessions')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

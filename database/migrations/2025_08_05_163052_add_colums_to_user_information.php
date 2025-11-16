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
        Schema::table('user_information', function (Blueprint $table) {
            $table->unsignedBigInteger('industry_type_id')->nullable()->after('organization_id');
            $table->foreign('industry_type_id')
                ->references('id')
                ->on('industry_type')
                ->onDelete('set null');

            $table->string('your_level')->nullable()->after('about');
            $table->text('mentor_motivation')->nullable()->after('your_level');
            $table->text('associate_yourself')->nullable()->after('mentor_motivation');
            $table->text('address')->nullable()->after('country');
            $table->string('city')->nullable()->after('address');
            $table->string('postal_code')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_information', function (Blueprint $table) {
            $table->dropForeign(['industry_type_id']);

            $table->dropColumn(['your_level', 'mentor_motivation', 'associate_yourself']);
        });
    }
};

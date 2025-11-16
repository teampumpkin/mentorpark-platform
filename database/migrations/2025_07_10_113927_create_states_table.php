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
        Schema::create('states', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci');
            $table->mediumInteger('country_id')->unsigned();
            $table->char('country_code', 2)->collation('utf8mb4_unicode_ci');
            $table->string('fips_code', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('iso2', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('flag')->default(1);
            $table->string('wikiDataId', 255)->nullable()->collation('utf8mb4_unicode_ci')->comment('Rapid API GeoDB Cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};

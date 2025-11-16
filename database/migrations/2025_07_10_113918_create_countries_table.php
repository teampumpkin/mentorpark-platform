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
        Schema::create('countries', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name', 100)->collation('utf8mb4_unicode_ci');
            $table->char('iso3', 3)->nullable()->collation('utf8mb4_unicode_ci');
            $table->char('iso2', 2)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('phonecode', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('capital', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('currency', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('currency_symbol', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('tld', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('native', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('region', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('subregion', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('timezones')->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('translations')->nullable()->collation('utf8mb4_unicode_ci');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('emoji', 191)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('emojiU', 191)->nullable()->collation('utf8mb4_unicode_ci');
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
        Schema::dropIfExists('countries');
    }
};

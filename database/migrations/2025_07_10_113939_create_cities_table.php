<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci');
            $table->mediumInteger('state_id')->unsigned();
            $table->string('state_code', 255)->collation('utf8mb4_unicode_ci');
            $table->mediumInteger('country_id')->unsigned();
            $table->char('country_code', 2)->collation('utf8mb4_unicode_ci');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamp('created_at')->default(DB::raw("'2014-01-01 01:01:01'"));
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
        Schema::dropIfExists('cities');
    }
};

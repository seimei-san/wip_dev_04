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
        Schema::create('wip_domains', function (Blueprint $table) {
            $table->string('domain_id', 8)->primary();
            $table->string('domain_short_name', 12)->unique();
            $table->string('domain_display_name', 32);
            $table->boolean('domain_active');
            $table->timestamps();
            $table->unique(['domain_short_name', 'domain_display_name'], 'domain_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wip_domains');
    }
};

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
        Schema::create('wip_groups', function (Blueprint $table) {
            $table->string('group_id', 12)->primary();
            $table->string('group_short_name', 12);
            $table->string('group_display_name', 36);
            $table->string('domain_id', 8)->nullable(true);
            $table->boolean('group_active');
            $table->timestamps();
            $table->unique(['group_short_name', 'group_display_name', 'domain_id'], 'group_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wip_groups');
    }
};

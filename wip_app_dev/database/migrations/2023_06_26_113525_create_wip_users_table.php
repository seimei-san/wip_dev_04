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
        Schema::create('wip_users', function (Blueprint $table) {
            $table->string('user_id',20)->primary();
            $table->string('domain_id', 8)->nullable(true);
            $table->boolean('user_active');
            $table->tinyInteger('perm_group_id')->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->unique(['user_id', 'domain_id', 'perm_group_id'], 'user_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wip_users');
    }
};

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
        Schema::create('wip_supervisor_groups', function (Blueprint $table) {
            $table->bigIncrements('supervisor_group_id');
            $table->string('supervisor_user_id', 20)->index();
            $table->string('group_id',12)->index();
            $table->timestamps();
            $table->unique(['supervisor_user_id','group_id'], 'supervisor_group_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wip_supervisor_groups');
    }
};

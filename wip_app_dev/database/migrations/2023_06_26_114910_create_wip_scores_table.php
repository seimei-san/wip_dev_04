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
        Schema::create('wip_scores', function (Blueprint $table) {
            $table->bigIncrements('score_id');
            $table->string('domain_id', 8)->index();
            $table->string('user_id', 20)->index();
            $table->string('chat_sys', 3);
            $table->string('origin', 6);
            $table->string('display_name', 36);
            $table->string('chat_user_id', 20)->index();
            $table->string('doc_id', 32)->index();
            $table->string('conversation_id', 40)->index();
            $table->string('thread_id', 40)->index();
            $table->string('message_id', 40)->index();
            $table->date('date')->index();
            $table->time('time');
            $table->tinyInteger('who_to_do');
            $table->tinyInteger('by_when');
            $table->tinyInteger('from_when');
            $table->tinyInteger('until_when');
            $table->tinyInteger('at_where');
            $table->tinyInteger('in_where');
            $table->tinyInteger('from_where');
            $table->tinyInteger('to_where');
            $table->tinyInteger('how_to_do');
            $table->tinyInteger('how_much');
            $table->tinyInteger('how_many');
            $table->tinyInteger('what_to_do');
            $table->tinyInteger('why');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wip_scores');
    }
};

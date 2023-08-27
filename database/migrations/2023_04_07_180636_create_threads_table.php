<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id')->nullable();
            $table->integer('receiver_id')->nullable();
            $table->string('last_message')->nullable();
            $table->integer('message_type')->nullable()->comment("1->is text; 2->is image; 3->is audio; 4->is video");
            $table->integer('blocked_user1')->default('0');
            $table->integer('blocked_user2')->default('0');
            $table->timestamps();
        });
    }
  
    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
};

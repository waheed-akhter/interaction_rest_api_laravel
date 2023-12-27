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
        Schema::create('interaction_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interaction_id');
            $table->foreign('interaction_id')->references('id')->on('interactions')->onDelete('cascade'); 
            $table->enum('event_type', ['submit', 'click', 'hover'])->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interaction_events');
    }
};

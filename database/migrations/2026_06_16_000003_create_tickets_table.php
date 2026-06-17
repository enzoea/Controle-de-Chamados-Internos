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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('priority', 20);
            $table->string('status', 20);
            $table->foreignId('requester_id')->constrained('users');
            $table->foreignId('responsible_id')->constrained('users');
            $table->timestamp('opened_at');
            $table->timestamps();

            $table->index('priority');
            $table->index('status');
            $table->index(['responsible_id', 'status']);
            $table->index(['requester_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

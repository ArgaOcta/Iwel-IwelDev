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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('ticket_no', 50)->unique();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['Pending', 'Reviewing', 'In Progress', 'Resolved', 'Rejected', 'Closed'])->default('Pending')->index();
            $table->enum('priority', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang');
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('category_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};

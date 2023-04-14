<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('status_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

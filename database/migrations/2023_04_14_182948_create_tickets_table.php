<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id()->index();
            $table->string('title');
            $table->longText('content');
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('status_id')->default(StatusEnum::PENDING->getId())->constrained();
            $table->foreignId('assignee_id')->nullable()->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

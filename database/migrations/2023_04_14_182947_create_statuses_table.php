<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id()->index();
            $table->string('title', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};

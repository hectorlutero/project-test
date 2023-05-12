<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('is_active', ['Y', 'N']);
            $table->string("name");
            $table->text("price");
            $table->integer("duration")->default(0)->comment("Duration in days");
            $table->integer("recurrence")->default(0)->comment("Number of days between each recurrence");
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
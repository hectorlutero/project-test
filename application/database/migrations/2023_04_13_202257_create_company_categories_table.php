<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_category_id')->nullable(); // Recursive child
            $table->enum('is_active', ['Y', 'N']);
            $table->enum('allow_products', ['Y', 'N']);
            $table->enum('allow_services', ['Y', 'N']);
            $table->string('name');
            $table->string('slug');
            $table->string('icon')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();

            $table->foreign('company_category_id')->references('id')->on('company_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_categories');
    }
};

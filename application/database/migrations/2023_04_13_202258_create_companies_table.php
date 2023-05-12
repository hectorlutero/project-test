<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('is_active', ['Y', 'N'])->default('Y');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_category_id');
            $table->unsignedBigInteger('plan_id');
            $table->string('name');
            $table->enum('status', ['active', 'pending_approval', 'banned'])->default('pending_approval');
            $table->string('slug');
            $table->unsignedBigInteger('logo_id')->nullable();
            $table->string('document')->nullable();
            $table->string('description')->nullable();
            $table->string('location')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_category_id')->references('id')->on('company_categories');
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
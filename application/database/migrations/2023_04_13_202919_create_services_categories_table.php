<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('services_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();


            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('category_id')->references('id')->on('service_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_categories');
    }
};

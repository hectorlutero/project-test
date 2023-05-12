<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('tag_id')->references('id')->on('service_tags');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_tags');
    }
};

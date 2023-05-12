<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('is_active', ['Y', 'N']);
            $table->unsignedBigInteger('company_id');
            $table->enum('status', ['DRAFT', 'PUBLISHED'])->comment('DRAFT - Rascunho | PUBLISHED - Publicado');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('description');
            $table->string('execution_time');
            $table->enum('is24_7', [1, 0])->default(0);
            $table->time('working_days_start')->nullable();
            $table->time('working_days_end')->nullable();
            $table->time('saturdays_start')->nullable();
            $table->time('saturdays_end')->nullable();
            $table->time('sundays_n_holidays_start')->nullable();
            $table->time('sundays_n_holidays_end')->nullable();
            $table->float('price');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
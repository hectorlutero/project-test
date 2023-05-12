<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->enum('status', ['DRAFT', 'PUBLISHED'])->comment('DRAFT - Rascunho | PUBLISHED - Publicado');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('model')->nullable();
            $table->string('description');
            $table->integer('stock')->default(0);
            $table->float('price');
            $table->string('sku')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
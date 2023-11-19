<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_name');
            $table->text('description')->nullable();
            $table->date('publish_date')->nullable();
            $table->integer('suggest')->nullable();
            $table->integer('author_id')->nullable()->unsigned();
            $table->integer('company_id')->nullable()->unsigned();
            $table->integer('category_id')->nullable()->unsigned();
            $table->string('publishing_house')->nullable();
            $table->string('translator')->nullable();
            $table->integer('number_of_pages')->nullable();
            $table->integer('quality')->nullable()->default(0);
            $table->bigInteger('price')->nullable();
            $table->bigInteger('cover_price')->nullable();
            $table->string('book_image')->nullable();
            $table->text('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_project_id')->references('id')->on('project_categories')->onDelete('cascade');
            $table->text('project_name');
            $table->smallInteger('start_year')->comment('academic year');
            $table->smallInteger('end_year')->comment('academic year');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('thumbnail', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

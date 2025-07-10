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
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 50);
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->json('members')->comment('nim & nama');
            $table->text('description');
            $table->string('video_trailer_url');
            $table->string('presentation_video_url');
            $table->string('poster_path', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_details');
    }
};

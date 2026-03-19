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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('dosen_pembimbing_id')->nullable()->after('project_category_id')->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'verified_by_dosen', 'rejected_by_dosen', 'approved', 'rejected_by_kaprodi'])->default('pending')->after('thumbnail');
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['dosen_pembimbing_id']);
            $table->dropColumn(['dosen_pembimbing_id', 'status', 'rejection_reason']);
        });
    }
};

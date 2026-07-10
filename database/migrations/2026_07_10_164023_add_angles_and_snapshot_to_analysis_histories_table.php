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
        Schema::table('analysis_histories', function (Blueprint $table) {
            $table->longText('angles')->nullable()->after('feedback');
            $table->string('snapshot_path')->nullable()->after('video_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analysis_histories', function (Blueprint $table) {
            $table->dropColumn(['angles', 'snapshot_path']);
        });
    }
};

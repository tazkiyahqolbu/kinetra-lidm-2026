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
            // The single "deepest frame" snapshot becomes one of three
            // representative photos (start / bottom / end), matching the
            // reference desktop tool's 3-panel report.
            $table->renameColumn('snapshot_path', 'snapshot_bottom_path');
        });

        Schema::table('analysis_histories', function (Blueprint $table) {
            $table->string('snapshot_start_path')->nullable()->after('snapshot_bottom_path');
            $table->string('snapshot_end_path')->nullable()->after('snapshot_bottom_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analysis_histories', function (Blueprint $table) {
            $table->dropColumn(['snapshot_start_path', 'snapshot_end_path']);
        });

        Schema::table('analysis_histories', function (Blueprint $table) {
            $table->renameColumn('snapshot_bottom_path', 'snapshot_path');
        });
    }
};

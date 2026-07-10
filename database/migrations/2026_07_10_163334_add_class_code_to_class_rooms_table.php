<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ClassRoom;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('class_rooms', function (Blueprint $table) {
            $table->string('class_code', 6)->nullable()->unique()->after('class_name');
        });

        // Backfill existing classes with a generated code before the app
        // starts relying on it for the student self-join flow.
        ClassRoom::whereNull('class_code')->get()->each(function (ClassRoom $class) {
            $class->update(['class_code' => ClassRoom::generateUniqueCode()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_rooms', function (Blueprint $table) {
            $table->dropColumn('class_code');
        });
    }
};

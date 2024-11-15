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
        Schema::create('room_repos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('room_id')->constrained();
            $table->string('owner');
            $table->string('repository');
            $table->string('branch');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('branch')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('branch');
        });
        Schema::dropIfExists('room_repos');
    }
};

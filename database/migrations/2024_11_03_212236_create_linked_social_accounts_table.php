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
        Schema::create('linked_social_accounts', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('provider_id');
            $table->string('provider_name');
            $table->unsignedBigInteger('user_id')->index('linked_social_accounts_user_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linked_social_accounts');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("user_bids", function (Blueprint $table) {
            $table->boolean("fund_transferred")->default(0);
        });
    }

    public function down(): void
    {
        Schema::table("user_bids", function (Blueprint $table) {
            $table->dropColumn("fund_transferred");
        });
    }
};

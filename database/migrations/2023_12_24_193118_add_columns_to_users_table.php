<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->unsignedBigInteger("created_by")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("address")->nullable();

            $table->foreign("created_by")
                ->references("id")
                ->on("users")
                ->onDelete("SET NULL");
        });
    }

    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("created_by");
            $table->dropColumn("phone_number");
            $table->dropColumn("address");
        });
    }
};

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
        Schema::create("products", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description", 1000)->nullable();
            $table->string("commission_offer")->nullable();
            $table->string("bid_increment_amount");

            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("user_id");

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");

            $table->foreign("category_id")
                ->references("id")
                ->on("categories")
                ->onDelete("cascade");

            //actually this should be hide identity.
            $table->boolean("show_product_owner")->default(0);

            $table->string("start_price");
            $table->string("end_price")->nullable();
            $table->boolean("price_limit")->default(0);
            $table->string("start_date")->nullable();
            $table->string("end_date");
            $table->boolean("approved")->default(0);
            $table->boolean("start_immediately")->default(0);
            $table->boolean("status")->default(1);
            $table->string("image")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("products");
    }
};

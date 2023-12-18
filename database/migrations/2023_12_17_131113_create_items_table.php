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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(0)->constrained('categories', 'id')->onDelete('cascade');
            $table->string("item_name");
            $table->string("item_slug")->unique();
            $table->unsignedInteger("item_old_price")->nullable()->default(0);
            $table->unsignedInteger("item_price")->nullable()->default(0);
            $table->unsignedInteger("item_qty")->nullable()->default(0);
            $table->longText("item_details");
            $table->unsignedTinyInteger("item_status_id")->nullable()->default(1);
            $table->unsignedBigInteger("created_by")->nullable()->default(0);
            $table->unsignedBigInteger("updated_by")->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

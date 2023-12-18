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
        Schema::create('items_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->default(0)->constrained('items', 'id')->onDelete('cascade');
            $table->string("size");
            $table->unsignedInteger("quantity")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_sizes');
    }
};

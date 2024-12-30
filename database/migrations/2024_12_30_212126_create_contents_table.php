<?php

declare(strict_types=1);

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
        Schema::table('subcategories', function (Blueprint $table) {
            $table->integerIncrements('id')->change();
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('subcategory_id');
            $table->string('title', 100);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subcategory_id')
                ->references('id')
                ->on('subcategories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::dropIfExists('contents');
    }
};

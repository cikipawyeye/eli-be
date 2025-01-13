<?php

declare(strict_types=1);

use App\Domains\User\Enums\JobTypeEnum;
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
        Schema::table('users', function (Blueprint $table) {
            $table->char('job_type', 1)->default(JobTypeEnum::Other->value);
            /** @see \App\Domains\User\Enums\GenderEnum::class */
            $table->char('gender', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('job_type');
            $table->dropColumn('gender');
        });
    }
};

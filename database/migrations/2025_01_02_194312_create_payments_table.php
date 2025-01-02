<?php

use App\Domains\Payment\Enums\PaymentMethodType;
use App\Domains\Payment\States\Payment\Failed;
use App\Domains\Payment\States\Payment\Succeeded;
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
            $table->boolean('is_premium')->default(false);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('user_id');
            $table->string('x_payment_id')->nullable();
            $table->string('x_payment_request_id')->nullable();
            $table->string('x_payment_method_id')->nullable();
            $table->integer('amount');
            $table->enum('payment_method_type', PaymentMethodType::toArray());
            $table->enum('state', [Succeeded::$name, Failed::$name]);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_premium');
        });
    }
};

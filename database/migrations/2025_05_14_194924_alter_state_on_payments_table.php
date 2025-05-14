<?php

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment as State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop the existing CHECK constraint (replace with actual constraint name)
        DB::statement(
            sprintf(
                "ALTER TABLE %s DROP CONSTRAINT payments_state_check",
                (new Payment())->getTable(),
            )
        );

        // 2. Add new CHECK constraint with updated enum values
        DB::statement(
            sprintf(
                "ALTER TABLE %s ADD CONSTRAINT payments_state_check CHECK (state IN ('%s', '%s', '%s', '%s'))",
                (new Payment())->getTable(),
                State\Pending::$name,
                State\Succeeded::$name,
                State\Failed::$name,
                State\Canceled::$name
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(
            sprintf(
                "ALTER TABLE %s DROP CONSTRAINT payments_state_check",
                (new Payment())->getTable(),
            )
        );
        DB::statement(
            sprintf(
                "ALTER TABLE %s ADD CONSTRAINT payments_state_check CHECK (state IN ('%s', '%s', '%s'))",
                (new Payment())->getTable(),
                State\Pending::$name,
                State\Succeeded::$name,
                State\Failed::$name,
            )
        );
    }
};

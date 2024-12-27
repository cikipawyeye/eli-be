<?php

declare(strict_types=1);

use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\User;
use App\Domains\User\PermissionAssignment;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createUser(?array $attributes = null, ?RoleEnum $role = null): User
{
    $attributes ??= [];
    $role ??= RoleEnum::User;
    $roleObject = Role::firstOrCreate(['name' => $role->value]);

    collect(PermissionAssignment::getPermissionsByRole($role->value))
        ->each(function (string $permission) use ($roleObject) {
            $permissionObject = Permission::firstOrCreate(['name' => $permission]);
            $roleObject->givePermissionTo($permissionObject->name);
        });

    return User::factory()->create($attributes)->assignRole($role);
}

function createSuperAdmin(?array $attributes = null): User
{
    return createUser($attributes, RoleEnum::SuperAdmin);
}

function createAdmin(?array $attributes = null): User
{
    return createUser($attributes, RoleEnum::Admin);
}

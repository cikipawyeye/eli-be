<?php

declare(strict_types=1);

use App\Domains\User\Models\User;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => ProvincesSeeder::class]);
    $this->artisan('db:seed', ['--class' => CitiesSeeder::class]);
    $this->artisan('db:seed', ['--class' => DistrictsSeeder::class]);
});

test('profile data is displayed', function () {
    $user = createUser([
        'city_code' => City::select('code')->get()->random()->code,
    ]);

    actingAs($user)
        ->getJson(route('api.profile.show'))
        ->assertOk()
        ->assertJsonStructure(['data'])
        ->assertJsonFragment([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_premium' => $user->is_premium,
            'birth_date' => $user->birth_date,
            'job' => $user->job,
            'city_code' => $user->city_code,
        ])
        ->assertJsonFragment([
            'name' => $user->city->name,
        ]);
});

test('profile information can be updated', function () {
    $user = createUser([
        'city_code' => City::select('code')->get()->random()->code,
    ]);

    $newProfile = User::factory([
        'city_code' => City::select('code')->get()->random()->code,
    ])->make();
    actingAs($user)
        ->post(route('api.profile.update'), $newProfile->toArray())
        ->assertOk()
        ->assertJsonStructure(['data'])
        ->assertJsonFragment([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_premium' => $user->is_premium,
            'birth_date' => $user->birth_date,
            'job' => $user->job,
            'city_code' => $user->city_code,
        ])
        ->assertJsonFragment([
            'name' => $user->city->name,
        ]);

    $user->refresh();

    $this->assertSame($newProfile->name, $user->name);
    $this->assertSame($newProfile->email, $user->email);
    $this->assertSame($newProfile->birth_date, $user->birth_date);
    $this->assertSame($newProfile->job, $user->job);
    $this->assertSame($newProfile->city_code, $user->city_code);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = createUser([
        'city_code' => City::select('code')->get()->random()->code,
        'email_verified_at' => now(),
    ]);

    $newProfile = User::factory([
        'email' => $user->email,
        'city_code' => City::select('code')->get()->random()->code,
    ])->make();
    actingAs($user)
        ->post(route('api.profile.update'), $newProfile->toArray())
        ->assertOk()
        ->assertJsonStructure(['data'])
        ->assertJsonFragment([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_premium' => $user->is_premium,
            'birth_date' => $user->birth_date,
            'job' => $user->job,
            'city_code' => $user->city_code,
        ])
        ->assertJsonFragment([
            'name' => $user->city->name,
        ]);

    $this->assertNotNull($user->refresh()->email_verified_at);
});

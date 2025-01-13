<?php

declare(strict_types=1);

use App\Domains\User\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Notification;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Stressless\stress;

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => ProvincesSeeder::class]);
    $this->artisan('db:seed', ['--class' => CitiesSeeder::class]);
    $this->artisan('db:seed', ['--class' => RoleSeeder::class]);
});

it('can get cities', function () {
    $response = getJson(route('api.register.origin.cities'))
        ->assertOk()
        ->assertJsonStructure(['data'])
        ->assertJsonCount(City::count(), 'data');

    City::select('code', 'name')->get()->each(function ($city) use ($response) {
        $response->assertJsonFragment([
            'code' => $city->code,
            'name' => $city->name,
        ]);
    });
});

it('can get cities with good performance', function () {
    $result = stress(route('api.register.origin.cities'));
    // ->concurrently(requests: 200)
    // ->for(5)
    // ->seconds()
    // ->dump()

    expect($result->requests()->duration()->med())->toBeLessThan(100); // < 100.00ms
});

it('can search cities', function () {
    $cities = City::select('code', 'name')->get();
    $target = $cities->random();

    getJson(route('api.register.origin.cities', [
        'search' => $target->name,
        'limit' => 1,
    ]))
        ->assertOk()
        ->assertJsonStructure(['data'])
        ->assertJsonFragment([
            'code' => $target->code,
            'name' => $target->name,
        ])
        ->assertJsonCount(1, 'data');
});

it('can register new user', function () {
    Notification::fake();

    $newUser = User::factory([
        'city_code' => City::select('code')->get()->random()->code,
    ])->make();
    $password = fake()->password(8);

    $response = postJson(route('api.register'), [
        ...$newUser->toArray(),
        'password' => $password,
        'password_confirmation' => $password,
    ])
        ->assertOk()
        ->assertJsonStructure(['data' => ['user', 'token']]);

    $user = User::first();

    $response
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

    $this->assertNull($user->email_verified_at);

    Notification::assertSentTo($user, Illuminate\Auth\Notifications\VerifyEmail::class);
});

<?php

use App\Domains\Content\Enums\ContentCategoryEnum;
use App\Domains\Content\Models\Content;
use App\Domains\Content\Models\Subcategory;
use Inertia\Testing\AssertableInertia;
use Illuminate\Support\Str;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;

it('can get subcategories', function () {
    $admin = createAdmin();
    $motivation = Subcategory::factory()->motivation()->count(15)->create();
    $reminder = Subcategory::factory()->reminder()->count(15)->create();

    actingAs($admin)
        ->get(route('subcategories.index'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Index')
                ->has('criteria')
        );

    // Default category is motivation
    actingAs($admin)
        ->get(route('subcategories.index', ['only' => 'data']), [
            'x-inertia-partial-component' => 'Content/Subcategory/Index',
            'x-inertia-partial-data' => 'data',
        ])
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Index')
                ->has('data.data', $motivation->count())
        );

    // Get Motivation subcategories
    actingAs($admin)
        ->get(route('subcategories.index', [
            'only' => 'data',
            'category' => ContentCategoryEnum::Motivation->value,
        ]), [
            'x-inertia-partial-component' => 'Content/Subcategory/Index',
            'x-inertia-partial-data' => 'data',
        ])
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Index')
                ->has('data.data', $motivation->count())
        );

    // Get Reminder subcategories
    actingAs($admin)
        ->get(route('subcategories.index', [
            'only' => 'data',
            'category' => ContentCategoryEnum::Reminder->value,
        ]), [
            'x-inertia-partial-component' => 'Content/Subcategory/Index',
            'x-inertia-partial-data' => 'data',
        ])
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Index')
                ->has('data.data', $reminder->count())
        );
});

it('can search subcategories', function () {
    $admin = createAdmin();
    $subcategories = Subcategory::factory()->count(30)->create();
    $target = $subcategories->random();

    actingAs($admin)
        ->get(route('subcategories.index', [
            'only' => 'data',
            'category' => $target->category,
            'search' => Str::lower($target->name),
        ]), [
            'x-inertia-partial-component' => 'Content/Subcategory/Index',
            'x-inertia-partial-data' => 'data',
        ])
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Index')
                ->has(
                    key: 'data.data',
                    callback: fn(AssertableInertia $data) => $data
                        ->where('id', $target->id)
                        ->etc()
                )
        );
});

it('can render create subcategory page', function () {
    $admin = createAdmin();

    actingAs($admin)
        ->get(route('subcategories.create', [
            'category' => ContentCategoryEnum::Motivation->value,
        ]))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Create')
        );

    actingAs($admin)
        ->get(route('subcategories.create', [
            'category' => ContentCategoryEnum::Motivation->value,
        ]))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Create')
                ->where('query.category', sprintf('%s', ContentCategoryEnum::Motivation->value))
        );

    actingAs($admin)
        ->get(route('subcategories.create', [
            'category' => ContentCategoryEnum::Reminder->value,
        ]))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Create')
                ->where('query.category', sprintf('%s', ContentCategoryEnum::Reminder->value))
        );
});

it('can store subcategory', function () {
    $admin = createAdmin();
    $subcategory = Subcategory::factory()->make();

    actingAs($admin)
        ->post(route('subcategories.store'), $subcategory->toArray())
        ->assertRedirect()
        ->assertSessionHas('success', __('app.stored_data', ['data' => __('app.subcategory')]));

    assertDatabaseHas($subcategory->getTable(), [
        'name' => $subcategory->name,
        'category' => $subcategory->category,
    ]);
});

it('can show subcategory page', function () {
    $admin = createAdmin();
    $subcategory = Subcategory::factory()->create();
    $contents = Content::factory(10, ['subcategory_id' => $subcategory->id])->create();

    actingAs($admin)
        ->get(route('subcategories.show', ['subcategory' => $subcategory->id]))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Show')
                ->has('data')
                ->where('data.id', $subcategory->id)
        );

    // Content list
    actingAs($admin)
        ->get(route('subcategories.show', ['subcategory' => $subcategory->id]), [
            'x-inertia-partial-component' => 'Content/Subcategory/Show',
            'x-inertia-partial-data' => 'contents',
        ])
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Show')
                ->has('contents.data', $contents->count())
        );
});

it('can search content within a subcategory', function () {
    $admin = createAdmin();
    $subcategory = Subcategory::factory()->create();
    $contents = Content::factory(30, ['subcategory_id' => $subcategory->id])->create();
    $target = $contents->random();

    actingAs($admin)
        ->get(route('subcategories.show', [
            'subcategory' => $subcategory->id,
            'content' => ['search' => Str::lower($target->title)],
        ]), [
            'x-inertia-partial-component' => 'Content/Subcategory/Show',
            'x-inertia-partial-data' => 'contents',
        ])
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page
                ->component('Content/Subcategory/Show')
                ->has(
                    key: 'contents.data',
                    callback: fn(AssertableInertia $data) => $data
                        ->where('title', $target->title)
                        ->etc()
                )
        );
});

it('can update subcategory', function () {
    $admin = createAdmin();
    $subcategory = Subcategory::factory()->create();
    $newData = Subcategory::factory()->make();

    actingAs($admin)
        ->put(
            route('subcategories.update', ['subcategory' => $subcategory->id]),
            $newData->only('name', 'category', 'is_active', 'premium')
        )
        ->assertRedirect()
        ->assertSessionHas('success', __('app.updated_data', ['data' => __('app.subcategory')]));

    assertDatabaseCount($subcategory->getTable(), 1);

    assertDatabaseHas(
        $subcategory->getTable(),
        $newData->only('name', 'category', 'is_active')
    );
});

it('can delete subcategory', function () {
    $admin = createAdmin();
    $subcategory = Subcategory::factory()->create();
    $contents = Content::factory(5, ['subcategory_id' => $subcategory->id])->create();

    actingAs($admin)
        ->delete(route('subcategories.destroy', ['subcategory' => $subcategory->id]))
        ->assertRedirect()
        ->assertSessionHas('success', __('app.deleted_data', ['data' => __('app.subcategory')]));

    assertSoftDeleted($subcategory->getTable(), ['id' => $subcategory->id]);

    foreach ($contents as $content) {
        assertSoftDeleted($content->getTable(), ['id' => $content->id]);
    }
});

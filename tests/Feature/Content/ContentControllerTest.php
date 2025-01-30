<?php

use App\Domains\Content\Models\Content;
use App\Domains\Content\Models\Subcategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;

it('cat manage a content', function () {
    Storage::fake('local');

    $admin = createAdmin();
    $subcategory = Subcategory::factory()->create();
    $content = Content::factory()->make(['subcategory_id' => $subcategory->id]);
    $file = UploadedFile::fake()->image('test-image.jpg');

    actingAs($admin)
        ->post(route('contents.store'), [
            ...$content->only('title', 'subcategory_id'),
            'image' => $file,
        ])
        ->assertRedirect()
        ->assertSessionHas('success', __('app.stored_data', ['data' => __('app.subcategory')]));

    assertDatabaseCount($content->getTable(), 1);

    assertDatabaseHas($content->getTable(), [
        'title' => $content->title,
        'subcategory_id' => $content->subcategory_id,
    ]);

    $content = Content::first();
    $media = $content->getFirstMedia('content');

    expect($media)->not->toBeNull();

    /** @disregard P1013 */
    Storage::disk('local')
        ->assertExists($media->id . '/test-image.jpg');
    /** @disregard P1013 */
    Storage::disk('local')
        ->assertExists($media->id . '/conversions/test-image-optimized.jpg');

    // Update content without changing image
    $newTitle = fake()->sentence();

    actingAs($admin)
        ->put(route('contents.update', $content), [
            'title' => $newTitle,
        ])
        ->assertRedirect()
        ->assertSessionHas('success', __('app.updated_data', ['data' => __('app.subcategory')]));

    assertDatabaseCount($content->getTable(), 1);
    assertDatabaseHas($content->getTable(), [
        'id' => $content->id,
        'title' => $newTitle,
    ]);

    $content->refresh();
    $media = $content->getFirstMedia('content');

    /** @disregard P1013 */
    Storage::disk('local')
        ->assertExists($media->id . '/test-image.jpg');
    /** @disregard P1013 */
    Storage::disk('local')
        ->assertExists($media->id . '/conversions/test-image-optimized.jpg');

    // Change content image
    $newImage = UploadedFile::fake()->image('new-test-image.jpg');

    actingAs($admin)
        ->put(route('contents.update', $content), [
            'title' => $content->title,
            'image' => $newImage,
        ])
        ->assertRedirect()
        ->assertSessionHas('success', __('app.updated_data', ['data' => __('app.subcategory')]));

    assertDatabaseCount($content->getTable(), 1);
    assertDatabaseHas($content->getTable(), [
        'id' => $content->id,
        'title' => $content->title,
    ]);

    $content->refresh();
    $media = $content->getFirstMedia('content');
    /** @disregard P1013 */
    Storage::disk('local')
        ->assertExists($media->id . '/new-test-image.jpg');
    /** @disregard P1013 */
    Storage::disk('local')
        ->assertExists($media->id . '/conversions/new-test-image-optimized.jpg');
});

it('can delete a content', function () {
    $admin = createAdmin();
    $content = Content::factory()->create();

    actingAs($admin)
        ->delete(route('contents.destroy', $content))
        ->assertRedirect()
        ->assertSessionHas('success', __('app.deleted_data', ['data' => __('app.subcategory')]));

    assertSoftDeleted($content->getTable(), ['id' => $content->id]);
});

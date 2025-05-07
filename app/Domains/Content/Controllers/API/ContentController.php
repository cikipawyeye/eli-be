<?php

declare(strict_types=1);

namespace App\Domains\Content\Controllers\API;

use App\Domains\Content\DataTransferObject\ContentData;
use App\Domains\Content\Models\Content;
use App\Domains\Content\Repositories\ContentCriteria;
use App\Domains\Content\Repositories\ContentRepository;
use App\Domains\Content\Requests\API\BrowseContentRequest;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Domains\User\Enums\RoleEnum;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Storage;

class ContentController extends ApiController
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_CONTENTS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_CONTENT))->only('show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BrowseContentRequest $request): JsonResponse
    {
        $criteria = ContentCriteria::from([
            ...$request->all(),
            'subcategory' => $request->subcategory_id,
        ]);
        $repository = new ContentRepository($criteria);

        /** @disregard P1013 */
        /** @var \App\Domains\User\Models\User */
        $user = auth()->user();

        if ($user->hasRole(RoleEnum::User->value) && (!$user->is_premium)) {
            $repository->limit(3);
            $data = $repository->get();
        } else {
            $data = !$request->boolean('paginate', true)
                ? $repository->get()
                : $repository->cursorPaginate($request->all());
        }

        return $this->resource(
            ContentData::class,
            $data,
            'image_urls',
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $content): JsonResponse
    {
        $content = Content::whereHas('subcategory')
            ->with('subcategory')
            ->where('id', $content)
            ->firstOrFail();

        return $this->sendJsonResponse(
            ContentData::fromModel($content)
                ->include('image_urls', 'subcategory', 'subcategory.category_name')
        );
    }

    public function getImage(Request $request, int $content)
    {
        if (! $request->hasValidSignatureWhileIgnoring(['type'])) {
            throw new InvalidSignatureException;
        }

        /** @var Content */
        $content = Content::with('media')->select('id')->findOrFail($content);
        $media = $content->getFirstMedia('content');
        $type = $request->get('type');

        if (! $type) {
            return $media;
        }

        if ('optimized' === $type) {
            $path = $media->getPath('optimized');

            return file_exists($path) ? response()->file($path) : $media;
        }

        if (str_starts_with($type, 'responsive/')) {
            $filename = str_replace('responsive/', '', $type);
            $path = Storage::disk('local')
                ->path(sprintf('%s/responsive-images/%s', $media->id, $filename));

            return response()->file($path);
        }

        return abort(404);
    }
}

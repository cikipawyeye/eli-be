<?php

declare(strict_types=1);

namespace App\Domains\Content\Controllers\API;

use App\Domains\Content\DataTransferObject\ContentData;
use App\Domains\Content\Enums\ContentTypeEnum;
use App\Domains\Content\Models\Content;
use App\Domains\Content\Repositories\ContentCriteria;
use App\Domains\Content\Repositories\ContentRepository;
use App\Domains\Content\Requests\API\BrowseContentRequest;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

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
            'type' => $request->user()->is_premium ? null : ContentTypeEnum::NonPremium->value,
        ]);
        $repository = new ContentRepository($criteria);
        $data = 'false' == $request->boolean('paginate')
            ? $repository->get()
            : $repository->cursorPaginate($request->all());

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
        return $this->sendJsonResponse(
            ContentData::fromModel(
                Content::whereHas('subcategory')
                    ->with('subcategory')
                    ->where('id', $content)
                    ->firstOrFail()
            )->include('image_urls', 'subcategory', 'subcategory.category_name')
        );
    }
}

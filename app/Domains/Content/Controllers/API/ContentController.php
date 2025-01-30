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
            $data = 'false' == $request->boolean('paginate')
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
}

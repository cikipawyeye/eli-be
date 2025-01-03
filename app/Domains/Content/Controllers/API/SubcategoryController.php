<?php

declare(strict_types=1);

namespace App\Domains\Content\Controllers\API;

use App\Domains\Content\DataTransferObject\SubcategoryData;
use App\Domains\Content\Enums\ContentCategoryEnum;
use App\Domains\Content\Exceptions\SubcategoryException;
use App\Domains\Content\Models\Subcategory;
use App\Domains\Content\Repositories\SubcategoryCriteria;
use App\Domains\Content\Repositories\SubcategoryRepository;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubcategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_SUBCATEGORIES))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_SUBCATEGORY))->only('show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $category, Request $request): JsonResponse
    {
        if (
            !in_array($category, ContentCategoryEnum::toArray())
        ) {
            throw SubcategoryException::invalidCategory();
        }

        $criteria = SubcategoryCriteria::from([
            ...$request->all(),
            'category' => $category,
            'type' => 'active',
        ]);
        $repository = new SubcategoryRepository($criteria);
        $data = 'false' == $request->boolean('paginate')
            ? $repository->get()
            : $repository->paginate($request->all());

        return $this->resource(
            SubcategoryData::class,
            $data
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $category, int $subcategory): JsonResponse
    {
        return $this->sendJsonResponse(
            SubcategoryData::fromModel(
                Subcategory::where('category', $category)
                    ->where('id', $subcategory)
                    ->where('is_active', true)
                    ->firstOrFail()
            )->include('category_name')
        );
    }
}

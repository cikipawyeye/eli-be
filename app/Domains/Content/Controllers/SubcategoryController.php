<?php

declare(strict_types=1);

namespace App\Domains\Content\Controllers;

use App\Domains\Content\Actions\SaveSubcategoryAction;
use App\Domains\Content\DataTransferObject\SubcategoryData;
use App\Domains\Content\Enums\ContentCategoryEnum;
use App\Domains\Content\Models\Subcategory;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Domains\Content\Repositories\SubcategoryCriteria;
use App\Domains\Content\Repositories\SubcategoryRepository;
use App\Domains\Content\Requests\SaveSubcategoryRequest;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_SUBCATEGORIES))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_SUBCATEGORY))->only('show');
        $this->middleware(sprintf('permission:%s', Permission::ADD_SUBCATEGORY))->only('store');
        $this->middleware(sprintf('permission:%s', Permission::EDIT_SUBCATEGORY))->only('update');
        $this->middleware(sprintf('permission:%s', Permission::DELETE_SUBCATEGORY))->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $criteria = SubcategoryCriteria::from([
            ...$request->all(),
            'category' => $request->get('category') ?? ContentCategoryEnum::Motivation->value
        ]);
        $repository = new SubcategoryRepository($criteria);

        $paginate = $request->boolean('paginate') == 'false';

        return Inertia::render('Content/Subcategory/Index', [
            'data' => Inertia::defer(fn() => $this->resource(SubcategoryData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
            'criteria' => $criteria,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveSubcategoryRequest $request)
    {
        // $result = dispatch_sync(new SaveSubcategoryAction(new Subcategory(), SubcategoryData::from($request->validated())));

        // return $this->sendJsonResponse(
        //     message: __('app.stored_data', ['data' => __('app.subcategory')]),
        //     data: $result
        // );
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $agent)
    {
        // return $this->sendJsonResponse(
        //     SubcategoryData::fromModel($agent)
        // );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveSubcategoryRequest $request, Subcategory $agent)
    {
        // dispatch_sync(new SaveSubcategoryAction($agent, SubcategoryData::from($request->validated())));

        // return $this->sendJsonResponse(
        //     message: __('app.updated_data', ['data' => __('app.subcategory')])
        // );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $category = $subcategory->category;

        DB::transaction(function () use ($subcategory) {
            $subcategory->delete();
        });

        return redirect()->route('subcategories.index', compact('category'));
    }
}

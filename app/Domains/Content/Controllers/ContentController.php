<?php

declare(strict_types=1);

namespace App\Domains\Content\Controllers;

use App\Domains\Content\Actions\StoreContentAction;
use App\Domains\Content\Actions\UpdateContentAction;
use App\Domains\Content\DataTransferObject\ContentData;
use App\Domains\Content\Models\Content;
use App\Domains\Content\Requests\StoreContentRequest;
use App\Domains\Content\Requests\UpdateContentRequest;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\Controller;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::ADD_CONTENT))->only('store');
        $this->middleware(sprintf('permission:%s', Permission::EDIT_CONTENT))->only('update');
        $this->middleware(sprintf('permission:%s', Permission::DELETE_CONTENT))->only('destroy');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentRequest $request)
    {
        $result = dispatch_sync(new StoreContentAction(new Content, ContentData::from($request->validated()), $request->file('image')));

        return redirect()
            ->route('subcategories.show', ['subcategory' => $result->subcategory_id])
            ->with('success', __('app.stored_data', ['data' => __('app.subcategory')]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentRequest $request, Content $content)
    {
        $result = dispatch_sync(new UpdateContentAction($content, ContentData::from($request->validated()), $request->file('image')));

        return redirect()
            ->route('subcategories.show', ['subcategory' => $result->subcategory_id])
            ->with('success', __('app.updated_data', ['data' => __('app.subcategory')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $content)
    {
        $model = Content::select('id', 'subcategory_id')->findOrFail($content);
        $model->delete();

        return redirect()
            ->route('subcategories.show', ['subcategory' => $model->subcategory_id])
            ->with('success', __('app.deleted_data', ['data' => __('app.subcategory')]));
    }
}

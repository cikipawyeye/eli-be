<?php

declare(strict_types=1);

namespace App\Domains\Content\Controllers;

use App\Domains\Content\Actions\StoreContentAction;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        $content->delete();

        return redirect()
            ->route('subcategories.show', ['subcategory' => $content->subcategory_id])
            ->with('success', __('app.deleted_data', ['data' => __('app.subcategory')]));
    }
}

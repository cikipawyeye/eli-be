<?php

namespace App\Domains\Theme\Controllers;

use App\Domains\Theme\Actions\StoreWallpaperAction;
use App\Domains\Theme\DataTransferObjects\WallpaperData;
use App\Domains\Theme\Models\Wallpaper;
use App\Domains\Theme\Repositories\WallpaperCriteria;
use App\Domains\Theme\Repositories\WallpaperRepository;
use App\Domains\Theme\Requests\StoreWallpaperRequest;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WallpaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        $criteria = WallpaperCriteria::from($request->all());
        $repository = new WallpaperRepository($criteria);
        $paginate = 'false' == $request->boolean('paginate');

        return Inertia::render('Theme/Wallpaper/Index', [
            'criteria' => Inertia::always($criteria),
            'data' => Inertia::defer(fn () => $this->resource(WallpaperData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWallpaperRequest $request)
    {
        dispatch_sync(new StoreWallpaperAction(
            $request->get('name'),
            $request->file('file')
        ));

        return redirect()
            ->route('wallpapers.index')
            ->with('success', __('app.stored_data', ['data' => __('app.wallpaper')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallpaper $wallpaper)
    {
        $wallpaper->delete();
        
        return redirect()
            ->route('wallpapers.index')
            ->with('success', __('app.deleted_data', ['data' => __('app.wallpaper')]));
    }
}

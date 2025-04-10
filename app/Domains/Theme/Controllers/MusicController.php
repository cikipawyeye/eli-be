<?php

namespace App\Domains\Theme\Controllers;

use App\Domains\Theme\Actions\StoreMusicAction;
use App\Domains\Theme\DataTransferObjects\MusicData;
use App\Domains\Theme\Models\Music;
use App\Domains\Theme\Repositories\MusicCriteria;
use App\Domains\Theme\Repositories\MusicRepository;
use App\Domains\Theme\Requests\StoreMusicRequest;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        $criteria = MusicCriteria::from($request->all());
        $repository = new MusicRepository($criteria);
        $paginate = 'false' == $request->boolean('paginate');

        return Inertia::render('Theme/Music/Index', [
            'criteria' => Inertia::always($criteria),
            'data' => Inertia::defer(fn () => $this->resource(MusicData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMusicRequest $request)
    {
        dispatch_sync(new StoreMusicAction(
            $request->get('title'),
            $request->file('file')
        ));

        return redirect()
            ->route('musics.index')
            ->with('success', __('app.stored_data', ['data' => __('app.music')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Music $music)
    {
        $music->delete();
        
        return redirect()
            ->route('musics.index')
            ->with('success', __('app.deleted_data', ['data' => __('app.music')]));
    }
}

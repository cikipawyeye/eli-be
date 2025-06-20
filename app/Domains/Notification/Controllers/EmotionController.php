<?php

namespace App\Domains\Notification\Controllers;

use App\Domains\Notification\Actions\SaveEmotionAction;
use App\Domains\Notification\DataTransferObjects\EmotionData;
use App\Domains\Notification\Models\Emotion;
use App\Domains\Notification\Repositories\EmotionCriteria;
use App\Domains\Notification\Repositories\EmotionRepository;
use App\Domains\Notification\Requests\SaveEmotionRequest;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmotionController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_EMOTIONS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::ADD_EMOTION))->only('store');
        $this->middleware(sprintf('permission:%s', Permission::READ_EMOTION))->only('show');
        $this->middleware(sprintf('permission:%s', Permission::EDIT_EMOTION))->only('update');
        $this->middleware(sprintf('permission:%s', Permission::DELETE_EMOTION))->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criteria = EmotionCriteria::from($request->all());
        $repository = new EmotionRepository($criteria);
        $paginate = 'false' == $request->boolean('paginate');

        return Inertia::render('Notification/Emotion/Index', [
            'data' => Inertia::defer(fn() => $this->resource(EmotionData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveEmotionRequest $request)
    {
        $emotion = new Emotion();
        
        dispatch_sync(
            new SaveEmotionAction(
                $emotion,
                EmotionData::from($request->validated())
            )
        );

        $emotion->refresh();

        return redirect()
            ->route('emotions.show', $emotion)
            ->with('success', __('app.stored_data', ['data' => __('app.emotion')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Emotion $emotion)
    {
        return Inertia::render('Notification/Emotion/Show', [
            'data' => EmotionData::fromModel($emotion),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveEmotionRequest $request, Emotion $emotion)
    {
        dispatch_sync(
            new SaveEmotionAction(
                $emotion,
                EmotionData::from($request->validated())
            )
        );

        return back()
            ->with('success', __('app.updated_data', ['data' => __('app.emotion')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emotion $emotion)
    {
        $emotion->delete();

        return redirect()
            ->route('emotions.index')
            ->with('success', __('app.deleted_data', ['data' => __('app.emotion')]));
    }
}

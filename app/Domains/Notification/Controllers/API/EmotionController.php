<?php

namespace App\Domains\Notification\Controllers\API;

use App\Domains\Notification\DataTransferObjects\EmotionData;
use App\Domains\Notification\Repositories\EmotionCriteria;
use App\Domains\Notification\Repositories\EmotionRepository;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;

class EmotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criteria = EmotionCriteria::from($request->all());
        $repository = new EmotionRepository($criteria);
        $data = $request->has('paginate') && !$request->boolean('paginate')
            ? $repository->get()
            : $repository->paginate($request->all());

        return $this->resource(
            EmotionData::class,
            $data,
        );
    }
}

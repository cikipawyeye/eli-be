<?php

namespace App\Domains\Notification\Controllers\API;

use App\Domains\Notification\DataTransferObjects\MessageData;
use App\Domains\Notification\Repositories\MessageCriteria;
use App\Domains\Notification\Repositories\MessageRepository;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criteria = MessageCriteria::from($request->all());
        $repository = new MessageRepository($criteria);
        $data = $request->has('paginate') && !$request->boolean('paginate')
            ? $repository->get()
            : $repository->paginate($request->all());

        return $this->resource(
            MessageData::class,
            $data,
        );
    }
}

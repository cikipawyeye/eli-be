<?php

declare(strict_types=1);

namespace App\Domains\Theme\Controllers\API;

use App\Domains\Theme\DataTransferObjects\MusicData;
use App\Domains\Theme\Models\Music;
use App\Domains\Theme\Repositories\MusicCriteria;
use App\Domains\Theme\Repositories\MusicRepository;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class MusicController extends ApiController
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_MUSICS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_MUSIC))->only([
            'show',
            'getFile',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $criteria = MusicCriteria::from([
            ...$request->all(),
        ]);
        $repository = new MusicRepository($criteria);
        $data = $request->has('paginate') && !$request->boolean('paginate')
            ? $repository->get()
            : $repository->paginate($request->all());

        return $this->resource(
            MusicData::class,
            $data,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Music $music): JsonResponse
    {
        return $this->sendJsonResponse(
            MusicData::fromModel($music)
        );
    }

    public function getFile(Request $request, int $music)
    {
        if (! $request->hasValidSignature()) {
            throw new InvalidSignatureException;
        }

        /** @var Music */
        $music = Music::with('media')->select('id')->findOrFail($music);
        $mediaItem = $music->getFirstMedia('content');
        
        return response()->file($mediaItem->getPath(), [
            'Content-Type' => $mediaItem->mime_type,
            'Content-Disposition' => 'inline; filename="' . $mediaItem->file_name . '"',
        ]);
    }
}

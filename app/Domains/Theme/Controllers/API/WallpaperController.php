<?php

declare(strict_types=1);

namespace App\Domains\Theme\Controllers\API;

use App\Domains\Theme\DataTransferObjects\WallpaperData;
use App\Domains\Theme\Models\Wallpaper;
use App\Domains\Theme\Repositories\WallpaperCriteria;
use App\Domains\Theme\Repositories\WallpaperRepository;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class WallpaperController extends ApiController
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_WALLPAPERS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_WALLPAPER))->only([
            'show',
            'getThumbnail',
            'getFile',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $criteria = WallpaperCriteria::from([
            ...$request->all(),
        ]);
        $repository = new WallpaperRepository($criteria);
        $data = 'false' == $request->get('paginate')
            ? $repository->get()
            : $repository->paginate($request->all());

        return $this->resource(
            WallpaperData::class,
            $data,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $wallpaper): JsonResponse
    {
        $content = Wallpaper::where('id', $wallpaper)
            ->firstOrFail();

        return $this->sendJsonResponse(
            WallpaperData::fromModel($content)
        );
    }

    public function getThumbnail(Request $request, int $wallpaper)
    {
        if (! $request->hasValidSignature()) {
            throw new InvalidSignatureException;
        }

        /** @var Wallpaper */
        $wallpaper = Wallpaper::with('media')->select('id')->findOrFail($wallpaper);
        $media = $wallpaper->getFirstMedia('content');
        $path = $media->getPath('thumb');

        return file_exists($path) ? response()->file($path) : $media;
    }

    public function getFile(Request $request, int $wallpaper)
    {
        if (! $request->hasValidSignature()) {
            throw new InvalidSignatureException;
        }

        /** @var Wallpaper */
        $wallpaper = Wallpaper::with('media')->select('id')->findOrFail($wallpaper);
        $mediaItem = $wallpaper->getFirstMedia('content');

        return response()->stream(function () use ($mediaItem) {
            readfile($mediaItem->getPath());
        }, 200, [
            'Content-Type' => $mediaItem->mime_type,
            'Content-Disposition' => 'attachment; filename="' . $mediaItem->file_name . '"',
        ]);
    }
}

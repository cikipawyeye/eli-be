<?php

declare(strict_types=1);

namespace App\Support\Controllers;

use App\Support\Resource\ResourceTransformer;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Routing\Controller;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

abstract class ApiController extends Controller
{
    /**
     * Send json response
     *
     * @param int $options
     */
    protected function sendJsonResponse(
        mixed $data = null,
        int $status = 200,
        ?string $message = null,
        array $headers = [],
        $options = 0
    ): \Illuminate\Http\JsonResponse {
        if (
            $data instanceof AbstractPaginator ||
            $data instanceof AbstractCursorPaginator ||
            $data instanceof PaginatedDataCollection ||
            $data instanceof CursorPaginatedDataCollection
        ) {
            return response()->json($data, $status, $headers, $options);
        }

        $response = [];
        $response['data'] = $data;

        if (null !== $message) {
            $response['message'] = $message;
        }

        return response()->json($response, $status, $headers, $options);
    }

    /**
     * Send resource
     *
     * @param class-string                                                                                                      $dataClass
     * @param \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Pagination\CursorPaginator $items
     */
    protected function resource(string $dataClass, $items, $includes = []): \Illuminate\Http\JsonResponse
    {
        return $this->sendJsonResponse(
            ResourceTransformer::transform(
                $dataClass,
                $items
            )->include(...$includes)
        );
    }
}

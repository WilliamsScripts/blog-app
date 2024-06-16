<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public static function sendResponse(string $message = 'success', mixed $result = null) : JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if(!empty($result)){
            $response['data'] = $result;
        }

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public static function sendError(string $error = '', int $code = 500, string | array $data = null) : JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($data)){
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    public static function createPaginatedData($records, $collection, $extras = null): array | AnonymousResourceCollection
    {
        $responseData = [];

        if ($records instanceof LengthAwarePaginator) {
            $responseData["record"] = $collection;
            $responseData["pagination"] = self::extractPaginationDetails($records);
            if ($extras) {
                $responseData = array_merge($responseData, $extras);
            }
        } else {
            if ($extras) {
                $responseData["record"] = $collection;
                $responseData = array_merge($responseData, $extras);
            } else {
                $responseData = $collection;
            }
        }

        return $responseData;
    }

    private static function extractPaginationDetails(LengthAwarePaginator $paginator): array
    {
        return [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'next_page_url' => $paginator->nextPageUrl(),
            'prev_page_url' => $paginator->previousPageUrl(),
        ];
    }
}

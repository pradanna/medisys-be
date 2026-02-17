<?php

namespace App\Utils\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class APIResponse
{
    /**
     * Response sukses standar
     */
    public static function success($data = null, string $message = "Success", int $code = 200): JsonResponse
    {
        $response = [
            'meta' => [
                "code" => $code,
                "message" => $message,
            ],
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, $code);
    }

    /**
     * Response error standar
     */
    public static function error(string $message = "Error", int $code = 400, array $errors = []): JsonResponse
    {
        $response = [
            'meta' => [
                "code" => $code,
                "message" => $message,
            ],
        ];


        if (!empty($errors)) {
            $response['meta']['errors'] = $errors;
        }

        return Response::json($response, $code);
    }



    public static function withPagination(
        $resourceData,
        \App\Utils\Pagination\PaginateResponse $paginated,
        string $message = 'success'
    ): JsonResponse {
        $response = [
            'meta' => [
                "code" => 200,
                "message" => $message,
                'pagination' => [
                    'total'        => $paginated->total,
                    'per_page'     => $paginated->perPage,
                    'current_page' => $paginated->currentPage,
                    'last_page'    => $paginated->lastPage,
                ]
            ],
            'data' => $resourceData,
        ];
        return Response::json($response, 200);
    }
}

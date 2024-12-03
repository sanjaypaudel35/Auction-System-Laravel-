<?php

namespace app\Core\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Api response format
     *
     * @param string $message
     * @param mixed $payload = null
     * @param int $responseCode
     *
     * @return JsonResponse
     */
    protected function response(
        ?string $message = null,
        mixed $payload = [],
        int $responseCode = Response::HTTP_OK,
        bool $forApi = false
    ): JsonResponse|array {
        $response = [
            "message" => json_decode($message) ?? $message,
        ];
        $data = is_object($payload)
            ? $payload->response()->getData(true)
            : ["data" => $payload];

        $response = array_merge($response, $data);
        if (
            $payload === null
            || (is_array($payload) && $payload === [])
        ) {
            unset($response["data"]);
        }

        if ($response["message"] == null) {
            unset($response["message"]);
        }

        if ($forApi) {
            return response()->json($response, $responseCode);
        } else {
            return $response;
        }
    }

    public function successResponse(
        ?string $message = null,
        mixed $payload = [],
        int $responseCode = Response::HTTP_OK
    ): JsonResponse {
        return $this->response(
            message: $message,
            payload: $payload,
            responseCode: $responseCode
        );
    }

    public function successRedirect(
        string $redirectRoute,
        ?string $message = null,
        mixed $routeParam = null,
        bool $errorMessage = false
    ) {
        if ($routeParam) {
            $redirect = redirect()->route($redirectRoute, [$routeParam]);
        } else {
            $redirect = redirect()->route($redirectRoute);
        }

        $key = ($errorMessage) ? "error" : "success";
        return ($message)
            ? $redirect->with($key, $message)
            : $redirect;
    }

    public function errorResponse(
        ?string $message = null,
        int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse|array {
        return $this->response(
            message: $message,
            responseCode: $responseCode
        );
    }
}

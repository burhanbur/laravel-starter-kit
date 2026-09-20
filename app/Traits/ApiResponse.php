<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Log;

trait ApiResponse
{
    /**
     * Return a standardized success JSON response.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data, ?string $message = null, int $code = 200): JsonResponse
    {
        $underlying = $data instanceof ResourceCollection ? $data->resource : $data;
        $pagination = $this->resolvePagination($underlying);
        $count = $this->resolveItemCount($data, $underlying);

        $response = [
            'success' => true,
            'message' => $message,
            'timestamp' => now()->toDateTimeString(),
            'total_data' => $count,
            'data' => $data,
        ];

        if ($pagination !== null) {
            $response['pagination'] = $pagination;
        }

        if (!isProduction()) {
            $response['debug'] = [
                'url' => request()->url(),
                'method' => request()->method(),
            ];
        }

        return response()->json($response, $code);
    }

    /**
     * Return a standardized error JSON response.
     *
     * @param mixed $message
     * @param int $code
     * @param mixed|null $errors
     * @return JsonResponse
     */
    protected function errorResponse($message, int $code = 400, $errors = null): JsonResponse
    {
        $originalMessage = $message;
        $formattedErrors = $this->resolveErrorsPayload($message, $code, $errors);
        $normalizedMessage = $this->normalizeErrorMessage($message);

        if (isProduction()) {
            $this->logProductionError($normalizedMessage, $code);
            $normalizedMessage = $this->getProductionErrorMessage($code, $normalizedMessage);
        }

        $response = [
            'success' => false,
            'message' => $normalizedMessage,
            'timestamp' => now()->toDateTimeString(),
        ];

        if ($formattedErrors !== null) {
            $response['errors'] = $formattedErrors;
        }

        if (!isProduction()) {
            $response['debug'] = [
                'url' => request()->url(),
                'method' => request()->method(),
                'original_message' => $originalMessage,
            ];
        }

        return response()->json($response, $code);
    }

    private function resolvePagination($underlying): ?array
    {
        $pagination = null;

        if ($underlying instanceof LengthAwarePaginator) {
            $pagination = [
                'total' => $underlying->total(),
                'per_page' => $underlying->perPage(),
                'current_page' => $underlying->currentPage(),
                'last_page' => $underlying->lastPage(),
                'from' => $underlying->firstItem(),
                'to' => $underlying->lastItem(),
            ];
        } elseif ($underlying instanceof Paginator) {
            $pagination = [
                'per_page' => $underlying->perPage(),
                'current_page' => $underlying->currentPage(),
                'has_more_pages' => $underlying->hasMorePages(),
                'next_page_url' => method_exists($underlying, 'nextPageUrl') ? $underlying->nextPageUrl() : null,
                'prev_page_url' => method_exists($underlying, 'previousPageUrl') ? $underlying->previousPageUrl() : null,
            ];
        } elseif ($underlying instanceof CursorPaginator) {
            $pagination = [
                'per_page' => $underlying->perPage(),
                'has_more_pages' => $underlying->hasMorePages(),
                'next_cursor' => optional($underlying->nextCursor())->encode(),
                'prev_cursor' => optional($underlying->previousCursor())->encode(),
            ];
        }

        return $pagination;
    }

    private function resolveItemCount($data, $underlying): int
    {
        if ($underlying instanceof LengthAwarePaginator || $underlying instanceof Paginator || $underlying instanceof CursorPaginator) {
            return $underlying->count();
        }

        if ($data instanceof ResourceCollection) {
            return $data->collection instanceof Collection ? $data->collection->count() : $data->count();
        }

        return $this->resolveFallbackCount($data);
    }

    private function resolveFallbackCount($data): int
    {
        $count = is_null($data) ? 0 : 1;

        if ($data instanceof Collection) {
            $count = $data->count();
        } elseif (is_array($data)) {
            $count = $this->countArrayData($data);
        }

        return $count;
    }

    private function countArrayData(array $data): int
    {
        if (array_key_exists('data', $data) && is_countable($data['data'])) {
            return count($data['data']);
        }

        return count($data);
    }

    private function resolveErrorsPayload($message, int $code, $errors)
    {
        if ($errors !== null) {
            return $errors;
        }

        if ($code === 422) {
            return $this->extractErrorsFromValidationMessage($message);
        }

        return null;
    }

    private function extractErrorsFromValidationMessage($message)
    {
        if (is_array($message)) {
            return $message;
        }

        if (is_string($message)) {
            $decoded = json_decode($message, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return null;
    }

    private function normalizeErrorMessage($message): string
    {
        if (is_array($message) || is_object($message)) {
            return collect($message)->flatten()->implode(', ');
        }

        if (is_string($message)) {
            $decoded = json_decode($message, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return collect($decoded)->flatten()->implode(', ');
            }
        }

        return (string) $message;
    }

    private function logProductionError(string $message, int $code): void
    {
        Log::error('API Error Response', [
            'message' => $message,
            'code' => $code,
            'url' => request()->url(),
            'method' => request()->method(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    private function getProductionErrorMessage(int $code, string $defaultMessage): string
    {
        return match ($code) {
            400 => $defaultMessage ?: 'Bad request. Please check your request and try again.',
            401 => 'Unauthorized access. Please login to continue.',
            403 => 'Forbidden access. You do not have permission to perform this action.',
            404 => 'The requested resource was not found.',
            422 => $defaultMessage ?: 'Validation error. Please check your input.',
            429 => 'Too many requests. Please slow down your requests.',
            500, 503 => 'Service temporarily unavailable. Please try again later.',
            default => 'An error occurred while processing your request. Please try again later.',
        };
    }
}

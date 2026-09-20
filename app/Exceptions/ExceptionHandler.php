<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AccessDeniedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\GatewayTimeoutHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\InvalidClaimException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\PayloadException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     */
    public function render(Throwable $e, Request $request): mixed
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            return $this->renderApiResponse($e, $request);
        }

        return $this->renderWebResponse($e, $request);
    }

    /**
     * Render JSON response for API or AJAX requests.
     */
    protected function renderApiResponse(Throwable $e, Request $request): JsonResponse
    {
        $statusCode = $this->getStatusCode($e);

        if (isProduction()) {
            $message = $this->getProductionMessage($statusCode);
            $this->logProductionApiError($e, $request, $message);
        } else {
            $message = $e->getMessage() ?: 'Internal Server Error';
        }

        $response = [
            'success'   => false,
            'message'   => $message,
            'timestamp' => now()->toDateTimeString(),
        ];

        if (!isProduction()) {
            $response = array_merge($response, $this->getDebugContext($e, $request));
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Build debug information for non-production environments.
     */
    protected function getDebugContext(Throwable $e, Request $request): array
    {
        $debug = [
            'url'       => $request->url(),
            'method'    => $request->method(),
            'exception' => get_class($e),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
        ];

        if ($e->getTrace()) {
            $debug['trace'] = collect($e->getTrace())->take(5)->toArray();
        }

        return $debug;
    }

    /**
     * Log API errors in production.
     */
    protected function logProductionApiError(Throwable $e, Request $request, string $message): void
    {
        Log::error($message, [
            'exception' => get_class($e),
            'message'   => $e->getMessage(),
            'url'       => $request->url(),
            'method'    => $request->method(),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Map exception to appropriate HTTP status code.
     */
    protected function getStatusCode(Throwable $e): int
    {
        return match (true) {
            // Validation Exceptions
            $e instanceof ValidationException => 422,

            // Authentication Exceptions
            $e instanceof AuthenticationException,
            $e instanceof UnauthorizedHttpException => 401,

            // Authorization Exceptions
            $e instanceof AuthorizationException,
            $e instanceof AccessDeniedException => 403,

            // Not Found Exceptions
            $e instanceof ModelNotFoundException,
            $e instanceof NotFoundHttpException => 404,

            // HTTP Exceptions
            $e instanceof BadRequestHttpException => 400,
            $e instanceof MethodNotAllowedHttpException => 405,
            $e instanceof ConflictHttpException => 409,
            $e instanceof TooManyRequestsHttpException => 429,
            $e instanceof ServiceUnavailableHttpException => 503,
            $e instanceof GatewayTimeoutHttpException => 504,

            // JWT Exceptions
            $e instanceof TokenInvalidException,
            $e instanceof TokenExpiredException,
            $e instanceof TokenBlacklistedException,
            $e instanceof InvalidClaimException,
            $e instanceof JWTException,
            $e instanceof PayloadException,
            $e instanceof UserNotDefinedException => 401,

            // Database Exceptions
            $e instanceof QueryException,
            $e instanceof PDOException => 500,

            // Default
            default => 500,
        };
    }

    /**
     * Map HTTP status code to generic production message.
     */
    protected function getProductionMessage(int $statusCode): string
    {
        return match ($statusCode) {
            400     => 'Bad request. Please check your request and try again.',
            401     => 'Unauthorized access. Please login to continue.',
            402     => 'Payment required. Please ensure you have the necessary funds to proceed.',
            403     => 'Forbidden access. You do not have permission to perform this action.',
            404     => 'The requested resource was not found.',
            405     => 'Method not allowed. Please check the HTTP method used.',
            409     => 'Conflict error. The request could not be completed due to a conflict with the current state of the resource.',
            422     => 'Validation error. Please check your input.',
            429     => 'Too many requests. You have exceeded the rate limit. Please slow down your requests.',
            500     => 'Internal server error. Please try again later.',
            503     => 'Service unavailable. The server is currently unable to handle the request. Please try again later.',
            504     => 'Gateway timeout. The server took too long to respond. Please try again later.',
            default => 'An error occurred while processing your request. Please try again later.',
        };
    }

    /**
     * Handle web requests with custom error views.
     */
    protected function renderWebResponse(Throwable $e, Request $request): ?Response
    {
        if (!method_exists($e, 'getStatusCode')) {
            return null;
        }

        $statusCode = $e->getStatusCode();

        // Validate status code (must be valid HTTP status code)
        if ($statusCode < 100 || $statusCode > 599) {
            $statusCode = 500;
        }

        $this->logWebError($e, $request, $statusCode);

        return $this->resolveWebView($e, $statusCode);
    }

    /**
     * Log HTTP error for web requests if configured.
     */
    protected function logWebError(Throwable $e, Request $request, int $statusCode): void
    {
        if (!config('errors.log_http_errors', true) || $statusCode < 400) {
            return;
        }

        $level = $statusCode >= 500 ? 'error' : 'warning';

        Log::channel(config('logging.default'))->log(
            $level,
            "HTTP {$statusCode} Error on web request",
            [
                'url'        => $request->fullUrl(),
                'method'     => $request->method(),
                'ip'         => $request->ip(),
                'user_id'    => auth()->id(),
                'user_agent' => $request->userAgent(),
                'exception'  => get_class($e),
                'message'    => $e->getMessage(),
            ]
        );
    }

    /**
     * Resolve custom error view or fallback error view.
     */
    protected function resolveWebView(Throwable $e, int $statusCode): ?Response
    {
        $view = null;

        if (view()->exists("errors.{$statusCode}")) {
            $view = "errors.{$statusCode}";
        } else {
            $fallbackCode = match (true) {
                $statusCode >= 500 => 500,
                $statusCode >= 400 => 404,
                default            => 500,
            };

            if (view()->exists("errors.{$fallbackCode}")) {
                $view = "errors.{$fallbackCode}";
            }
        }

        if ($view !== null) {
            return response()->view($view, [
                'exception' => config('app.debug') ? $e : null,
            ], $statusCode);
        }

        return null;
    }
}

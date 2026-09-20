<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     operationId="apiAuthLogin",
     *     tags={"Auth"},
     *     summary="Autentikasi Pengguna via JWT",
     *     description="Menerima email atau username beserta password untuk menghasilkan Bearer JWT token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"identity","password"},
     *             @OA\Property(property="identity", type="string", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login berhasil"),
     *     @OA\Response(response=401, description="Kredensial tidak valid"),
     *     @OA\Response(response=403, description="Akun nonaktif"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $identity = $request->input('identity');
        $field = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field     => $identity,
            'password' => $request->input('password'),
        ];

        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return $this->errorResponse('Email/Username atau password salah.', 401);
        }

        $user = auth('api')->user();
        if (!$user->is_active) {
            auth('api')->logout();
            return $this->errorResponse('Akun Anda dinonaktifkan. Silakan hubungi administrator.', 403);
        }

        return $this->respondWithToken($token, 'Login berhasil.');
    }

    /**
     * @OA\Get(
     *     path="/auth/me",
     *     operationId="apiAuthMe",
     *     tags={"Auth"},
     *     summary="Ambil data profil pengguna yang sedang login",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(response=200, description="Profil berhasil diambil"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function me(): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user) {
            return $this->errorResponse('Pengguna tidak ditemukan.', 404);
        }

        $user->load('roles');

        return $this->successResponse(new UserResource($user), 'Profil pengguna berhasil diambil.');
    }

    /**
     * @OA\Post(
     *     path="/auth/refresh",
     *     operationId="apiAuthRefresh",
     *     tags={"Auth"},
     *     summary="Perbarui JWT Access Token",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(response=200, description="Token berhasil diperbarui"),
     *     @OA\Response(response=401, description="Unauthorized / Token expired")
     * )
     */
    public function refresh(): JsonResponse
    {
        try {
            $newToken = auth('api')->refresh();
            return $this->respondWithToken($newToken, 'Token berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memperbarui token autentikasi.', 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     operationId="apiAuthLogout",
     *     tags={"Auth"},
     *     summary="Logout pengguna dan invalidasi JWT token",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(response=200, description="Logout berhasil"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout(): JsonResponse
    {
        try {
            auth('api')->logout();
            return $this->successResponse(null, 'Logout berhasil.');
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal melakukan logout.', 500);
        }
    }

    /**
     * Format JWT token response payload.
     */
    private function respondWithToken(string $token, string $message): JsonResponse
    {
        $user = auth('api')->user();
        if ($user) {
            $user->load('roles');
        }

        $ttl = (int) config('jwt.ttl', 60);

        return $this->successResponse([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $ttl * 60,
            'user'         => $user ? new UserResource($user) : null,
        ], $message);
    }
}

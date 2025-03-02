<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ApiAuthMiddleware
{
    /**
     * Обработка входящего запроса.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->setJsonAcceptHeader($request);

        if (!$this->hasValidApiToken()) {
            return $this->unauthorizedResponse('Unauthorized');
        }

        $token = Auth::guard('api')->user()?->currentAccessToken();

        if ($token && $this->isTokenExpired($token)) {
            $this->invalidateToken($token);
            return $this->unauthorizedResponse('Token has expired');
        }

        return $next($request);
    }

    /**
     * Установка заголовка Accept в application/json.
     *
     * @param Request $request
     * @return void
     */
    private function setJsonAcceptHeader(Request $request): void
    {
        $request->headers->set('Accept', 'application/json');
    }

    /**
     * Проверка наличия действительного API токена.
     *
     * @return bool
     */
    private function hasValidApiToken(): bool
    {
        return Auth::guard('api')->check();
    }

    /**
     * Недействительность токена путем удаления его.
     *
     * @param PersonalAccessToken $token
     * @return void
     */
    private function invalidateToken(PersonalAccessToken $token): void
    {
        $token->delete();
    }

    /**
     * Возвращение ответа с кодом 401 и сообщением об ошибке.
     *
     * @param string $message
     * @return JsonResponse
     */
    private function unauthorizedResponse(string $message): JsonResponse
    {
        return response()->json([
            'error' => $message,
            'ok' => false
        ], 401);
    }

    /**
     * Проверка, истек ли токен.
     *
     * @param PersonalAccessToken $token
     * @return bool
     */
    private function isTokenExpired(PersonalAccessToken $token): bool
    {
        $expiration = config('sanctum.expiration');

        if (!$expiration) {
            return false;
        }

        return Carbon::parse($token->created_at)
            ->addMinutes($expiration)
            ->isPast();
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class WrapInTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (SymfonyResponse) $next
     * @return SymfonyResponse
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        DB::beginTransaction();

        try {
            $response = $next($request);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        if ($response instanceof SymfonyResponse && $response->getStatusCode() > 399) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $response;
    }
}

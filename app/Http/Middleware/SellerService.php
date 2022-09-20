<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->isAdmin() || !$request->user()->isSellerService()) {
            return response()->json([
                'status' => 'error',
                'message' => "You don't have permission."
            ]);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class EnsureProductOwner
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
        if ($request->user()->id != $request->route('product')->seller_id) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401));
        }

        return $next($request);
    }
}

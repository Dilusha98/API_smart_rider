<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!isPermissions($request->route()->getName())){
            if ($request->ajax()) {
                return response()->json(['error' => 'You Have No Permission To Access'], 403);
            } else {
                return redirect()->route('dashboard')->with('error', 'You Have No Permission To Access');
            }
        }
        return $next($request);
    }
}

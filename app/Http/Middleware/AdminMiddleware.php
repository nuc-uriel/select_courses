<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = $request->session()->get('u_role');
        if ($role === null) {
            return redirect('/');
        } else if ($role === 0) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}

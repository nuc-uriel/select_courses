<?php

namespace App\Http\Middleware;

use Closure;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = $request->session()->get('u_role');
        if ($role === null) {
            return redirect('/');
        } else if ($role === 1) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}

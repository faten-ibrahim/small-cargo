<?php

namespace App\Http\Middleware;

use Closure;

class CheckActived
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
        // if ($request->status == 'active') {
        if (auth()->check() && auth()->user()->status == 'inactive') {
            auth()->logout();
            $message = 'Sorry, this account is no longer active.
            Please contact your dashboard administrator.';
            // return redirect('/locked');
            return redirect()->route('login')->withMessage($message);
        }
        return $next($request);
    }
}

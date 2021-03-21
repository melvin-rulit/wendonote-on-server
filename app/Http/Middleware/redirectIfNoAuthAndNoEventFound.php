<?php

namespace App\Http\Middleware;

use App\Event;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class redirectIfNoAuthAndNoEventFound
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
        if(Auth::check())
        {
            if(Event::where('user_id', Auth::user()->id)->count() != 0)
                return redirect()->route('mynote');
        }else {
            if(Session::has('event'))
                return redirect()->route('register');
        }

        return $next($request);
    }
}

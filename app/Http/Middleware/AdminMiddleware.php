<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\RedirectResponse;
class AdminMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		/*if(Auth::check())
		{
			if (Auth::user()->role == 'customer') {
				return new RedirectResponse(url('/'));
			}
		}
		return $next($request);*/
		 if (Auth::user()->role == 'admin')
        {
            return $next($request);
        }

        return redirect()->guest('/');
	}

}

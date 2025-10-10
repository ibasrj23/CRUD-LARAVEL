<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
		$user = Auth::user();
		if (
			$user &&
			$user->role == 1
		) {
			return $next($request);
		} else {
			// abort(403, 'Anda tidak memiliki akses !');
			// return redirect('login')

			Auth::logout();
			return redirect('login')
				->with('error', "Anda tidak memiliki akses !");
		}
	}
}

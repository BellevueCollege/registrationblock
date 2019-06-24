<?php

namespace App\Http\Middleware;

use Closure;

class SimpleSAMLphp
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

        /**
         * Load SimpleSAMLphp library
         */
        require_once(config('simplesamlphp.path'));
        $auth = new \SimpleSAML\Auth\Simple(config('simplesamlphp.sp'));

        /**
         * Store Username and Auth Object in Session
         */
        $attributes = $auth->getAttributes();
        session(['username' => $attributes[config('simplesamlphp.username')][0]]);
        session(['logout_url' => $auth->getLogoutURL('https://www.bellevuecollege.edu')]);

        return $next($request);
    }
}
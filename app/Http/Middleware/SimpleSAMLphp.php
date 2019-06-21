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
        $as = new \SimpleSAML\Auth\Simple(config('simplesamlphp.sp'));
        $as->requireAuth();

        /**
         * Store Username in Session
         */
        $attributes = $as->getAttributes();
        session(['username' => $attributes[config('simplesamlphp.username')][0]]);

        return $next($request);
    }
}
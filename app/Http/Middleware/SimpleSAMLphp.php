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
        if ( 'local' !== config('app.env') && 'testing' !== config('app.env') )
        {
            require_once(config('simplesamlphp.path'));
            $auth = new \SimpleSAML\Auth\Simple(config('simplesamlphp.sp'));
            $auth->requireAuth();

            /**
             * Store Username and Auth Object in Session
             */
            $attributes = $auth->getAttributes();
            $request->attributes->add(['username' => $attributes[config('simplesamlphp.username')][0]]);
            $request->attributes->add(['logoutUrl' => $auth->getLogoutURL('https://www.bellevuecollege.edu')]);

        }
        else // Disable auth on test and local environments
        {
            $request->attributes->add(['username' => 't.test']); // Modify this username if needed
            $request->attributes->add(['logoutUrl' => 'https://www.bellevuecollege.edu']);
        }

        return $next($request);
    }
}

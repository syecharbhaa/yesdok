<?php

namespace App\Http\Middleware;

use Closure;

class StaffMiddleware
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
        if($request->user()->role->name !== 'Staff'){
            $res['status'] = 'fail';
            $res['data'] = ['role' => 'User access denied'];

            return response($res, 403);
        }
        
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // if (!Auth::guard('superadmin')->check()) {
        //     return redirect()->route('superadmin.login');
        // }

        // return $next($request);

        if (Auth::guard('superadmin')->check()) {

            $org_detais = Auth::guard('superadmin')->user()->organisation_status;
            if($org_detais == 'Active'){

                return $next($request);

            }

            return redirect()->route('account_suspended')->with('error','Your Super Admin Account Has Been Suspended, Please Contact To SilTech');

        }
        
        return redirect()->route('superadmin.login');

        
    }
}

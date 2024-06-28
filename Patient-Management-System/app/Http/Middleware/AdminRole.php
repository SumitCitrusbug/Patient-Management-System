<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = Role::where("roles", 'admin')->first(); // check for eloquent in role table
        if (Auth::user()->role_id == $role->id) {
            return $next($request);
        } else {
            return response()->json(['status' => false, 'message' => 'Only admin can access this page',], 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Docter;
use Illuminate\Support\Facades\Auth;


class DocterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function docterList()
    {
        //



        // $user = User::with('roles')->get();
        // dd($user);
        // $role = Role::with('users')->get();




        return $parts;
        // return response()->json(['status' => true, 'message' => 'all docter list', 'data' => $docter]);
    }
}

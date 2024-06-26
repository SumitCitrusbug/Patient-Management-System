<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Docter;
use App\Models\Payment;

class DocterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function docterList()
    {
        try {

            //list the doctor with time slote
            $docters = Docter::with('timeSlots')->get();
            return response()->json(['status' => true, 'message' => ' All docterlist ', 'data' => $docters], 200);
        } catch (Exception $e) {
            return response()->json(['status' => true, 'message' => 'Error found ', 'data' => $e->getMessage()], 400);
        }
    }
}

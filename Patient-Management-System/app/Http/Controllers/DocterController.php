<?php

namespace App\Http\Controllers;

use App\Models\Docter;
use Exception;

class DocterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function docterList()
    {
        try {

            $docters = Docter::with('timeSlots')->get();


            // $docters = Docter::select('name', 'specialties', 'amount')->with('timeSlots')->get();

            return response()->json(['status' => true, 'message' => ' All docterlist ', 'data' => $docters]);
        } catch (Exception $e) {
            return response()->json(['status' => true, 'message' => 'docterlist ', 'data' => $e->getMessage()]);
        }
    }
}

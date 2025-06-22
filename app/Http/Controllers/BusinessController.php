<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('business')) {
            return response()->json([
            'status' => true,
            'message' => 'This is the investor data.',           
            ]);
        } else {
            abort(403);
        }
    }

}

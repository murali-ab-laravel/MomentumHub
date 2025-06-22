<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('investor')) {
            return response()->json([
            'status' => true,
            'message' => 'This is the business data.',           
            ]);
        } else {
            abort(403);
        }
    }
}

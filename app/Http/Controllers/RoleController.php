<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    
    public function assignRole(Request $request)
    {
        
         $request->validate([
         'role' => 'required|string|exists:roles,name',
         ]);

         $user = Auth::guard('api')->user(); 
         $user->assignRole($request->role);

         return response()->json([
         'message' => 'Role assigned successfully',
         'roles' => $user->getRoleNames()
         ]);
    }

}

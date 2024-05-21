<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function saveToken(Request $request)
    {
        User::whereId(1)->update(['device_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Default view.
     */
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    /**
     * Search handler.
     */
    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $search = $validatedData['search'];


        $response['companies'] = [];
        if(Auth::user()->isAdmin()){
            $companies = Company::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('website', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->limit(5)
                ->get();
            $response['companies'] = $companies;
        }

        $users = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->limit(5)
            ->get();
        $response['users'] = $users;

        return response()->json($response);
    }



}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    /**
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->wantsJson()){
            $users = Company::orderBy('created_at', 'DESC')->with('author')->paginate(10);
            return response()->json($users);
        }else{
            $current_user = Auth::user();
            return view('partials.companies.list', compact('current_user'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_user = Auth::user();
        return view('partials.companies.create', compact('current_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'website' => 'required|',
            'location' => 'required',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $data = [
            'name' => $validatedData['name'],
            'website' => $validatedData['website'],
            'location' => $validatedData['location'],
            'user_id' => $validatedData['user_id'],
        ];

        return Company::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $current_user = Auth::user();
        $company = Company::findOrFail($id);
        return view('partials.companies.edit', compact('company', 'current_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'website' => 'required|',
            'location' => 'required',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        return Company::where('id', $id)->update($validatedData);
    }

    /**
     *
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(null, 204);
    }
}

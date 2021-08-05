<?php

namespace Googlemarketer\Contact\Http\Controllers\Associate;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Requests\CompaniesRequest;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $companies = Company::all();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompaniesRequest $request)
    {
        // request()->validate([
        //     'compLogo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     ]);
        $imageName = time().'.'.request()->compLogo->getClientOriginalExtension();
        request()->compLogo->move(public_path('images'), $imageName);
        // $validatedData = $request->validate([
        //     'compName' => 'required|unique:posts|max:255',
        //     'compCity' => 'required',
        // ]);
         $input = $request->all();
         $input['compLogo'] =  $imageName;

        Company::create($input);

        //return redirect('companies')->with('success', 'you have added a new manufactuer to your list');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //$company = Company::findOrFail($id);

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($compid)
    {

        $company = Company::findOrFail($compid);

         $compINFO = [
           'Name' => ['text' => 'compName'],
           'Address' => ['textarea' => 'compAddress'],
           'City' => ['text' => 'compCity'],
           'Web' => ['text' => 'compUrl'],
           'Phone' => ['text' => 'compPhone'],
           'Customercare' => ['text' => 'compCustcareNo'],
           'Customercare Email' => ['email' => 'compCustcareEmail'],
           'Uplaod Logo' => ['file' => 'compLogo']
        ];

        return view('companies.edit', compact('compINFO','company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $compid)
    {
       // dd ($request);
    //     request()->validate([
    //         'compLogo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         ]);
    //     $imageName = time().'.'.request()->compLogo->getClientOriginalExtension();
    //     request()->compLogo->move(public_path('images'), $imageName);
    //     $input = $request->all();
    //    $input['compLogo'] =  $imageName;
        $company = Company::findOrFail($compid);

       $company->update( $request->all());

       return redirect('companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

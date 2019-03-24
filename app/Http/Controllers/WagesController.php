<?php

namespace App\Http\Controllers;

use App\Wages;
use App\User;
// use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    $wages = Wages::select(
        'id',
        'employee_id',
        'client_id',
        'hourly_rate')->get();

    $employee = 'employee';
    $employee = User::select(
                            'users.id',
                            'users.name',
                            'users.email',
                            'users.user_type')
                    ->where('users.user_type','=',$employee)->get();

    $client = 'client';
    $client = User::select(
                            'users.id',
                            'users.name',
                            'users.email',
                            'users.user_type')
                    ->where('users.user_type','=',$client)->get();

    return view('backend.pages.wages',compact('wages', 'employee', 'client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Wages::create([
            'employee_id'   => $request['employee_id'],
            'client_id'     => $request['client_id'],
            'hourly_rate'   => $request['hourly_rate']
        ]);
        return redirect()->back()->with('message', 'Added Successfully');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wages = Wages::find($id); 
        $wages->delete(); //delete the id
        return redirect()->back()->with('message','Wages Deleted Successfully');
    }
}

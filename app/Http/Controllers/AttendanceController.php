<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Client;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Attendance;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_type = 'employee';
        $employees = User::all()->where('user_type','=',$user_type);

        return view('backend.pages.check_in_out',compact('employees'));
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
        //
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
        //
    }

    public function list()
    {
        // $attendance_lists = Attendance::select('attendances.id','clients.name','attendances.check_in','attendances.check_out','attendances.created_at')->join('clients','attendances.client_id','=','clients.id')->get();
        $user_lists = User::all();
        $attendance_lists = Attendance::all();
        return view('backend.pages.attendance_list',compact('attendance_lists', 'user_lists'));
    }

    public function checkin(Request $request)
    {
        $employee_id = $request->client;
        $client_id = Auth::id();
        // print_r($userId);
        //Check if already Logged In
        $attendance_check = Attendance::where('employee_id',$employee_id)->whereDate('created_at',\Carbon\Carbon::today());
        if(!$attendance_check->exists()){
            $carbon = now();
            $current_date_time = $carbon->toDateTimeString();
            $check_in = new Attendance;
            $check_in->client_id = $client_id;
            $check_in->employee_id = $employee_id;
            $check_in->check_in = $current_date_time;
            $check_in->save();
        }
        else{
            return  redirect()->back()->withErrors('Client Already Logged In for Today');
        }
        return redirect()->back()->with('message', 'Client Logged in Successfully');
    }
    public function checkout(Request $request)
    {
        // $client_id = $request->client;
        $client_id = Auth::id();
        $carbon = now();
        $current_date_time = $carbon->toDateTimeString();
        $check_in = Attendance::where('client_id',$client_id)->whereDate('created_at',\Carbon\Carbon::today())->update(['check_out'=>$current_date_time]);
        
        return redirect()->back();
    }

}

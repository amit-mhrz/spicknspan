<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Roster;
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
        $user_type = 'client';
        $clients = User::all()->where('user_type','=',$user_type);

        return view('backend.pages.check_in_out',compact('clients'));
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
          //get user location
          $user_ip = getenv('REMOTE_ADDR');
          $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
          // $current_city = $geo["geoplugin_timezone"];
          $latitude = $geo["geoplugin_latitude"];
          $longitude = $geo["geoplugin_longitude"];
          $location = $latitude.', '. $longitude;

        $client_id = $request->client;
        $employee_id = Auth::id();
        //Check if already Logged In
        $attendance_check = Attendance::where('employee_id',$employee_id)->whereDate('created_at',\Carbon\Carbon::today());
        if(!$attendance_check->exists()){
            $carbon = now();
            $current_date_time = $carbon->toDateTimeString();
            $check_in = new Attendance;
            $check_in->client_id = $client_id;
            $check_in->employee_id = $employee_id;
            $check_in->check_in = $current_date_time;
            $check_in->check_in_location = $location;
            $check_in->save();
        }
        else{
            return  redirect()->back()->withErrors('Client Already Logged In for Today');
        }
        return redirect()->back()->with('message', 'Client Logged In Successfully');
    }
    
    public function checkout(Request $request)
    {
         //get user location
          $user_ip = getenv('REMOTE_ADDR');
          $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
          // $current_city = $geo["geoplugin_timezone"];
          $latitude = $geo["geoplugin_latitude"];
          $longitude = $geo["geoplugin_longitude"];
          $location = $latitude.', '. $longitude;

        $client_id = $request->client;
        $employee_id = Auth::id();
        $carbon = now();
        $current_date_time = $carbon->toDateTimeString();
        $check_in = Attendance::where('client_id',$client_id)->where('employee_id',$employee_id)->whereDate('created_at',\Carbon\Carbon::today())->update(['full_date'=>$current_date_time, 'check_out'=>$current_date_time, 'check_out_location'=>$location]);

        //check total hours difference in the roster table
        $current_date_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $current_date_time)->format('Y-m-d');
        $roster_lists     = DB::table('rosters')->where('client_id', '=', $client_id)->where('employee_id', '=', $employee_id)->where('full_date', '=', $current_date_time)->get();
        $roster_lists = json_decode($roster_lists, true);
        $diff_hour1 = $roster_lists[0]['total_hours'];

        //check total hours difference in the attendance table
        $attendance_lists = DB::table('attendances')->where('attendances.client_id', '=', $client_id)->where('attendances.employee_id', '=', $employee_id)->where('attendances.full_date', '=', $current_date_time)->get();
        $attendance_lists = json_decode($attendance_lists, true);
        $check_in  = $attendance_lists[0]['check_in'];
        $check_out = $attendance_lists[0]['check_out'];
        $diff_hour2 = round(abs(strtotime($check_in) - strtotime($check_out)) / 3600);

        if($diff_hour1 == $diff_hour2){
            $status = 1;
        }else{
            $status = 2;
        }

        $check_in = Attendance::where('client_id',$client_id)->where('employee_id',$employee_id)->whereDate('created_at',\Carbon\Carbon::today())->update(['status'=>$status]);

        return redirect()->back()->with('message', 'Client Logged Out Successfully');
    }

}

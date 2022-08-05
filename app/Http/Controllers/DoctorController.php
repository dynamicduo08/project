<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\DoctorDetail;
use App\DoctorSchedule;
use RealRashid\SweetAlert\Facades\Alert;
use App\ActivityLog;
use App\Employee;


use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(){
        $user = User::where('id', Auth::user()->id)->with('usertype','usertype.permissions')->get();
        $permissions = [];
        foreach($user[0]->usertype->permissions as $permission)
        {
            array_push($permissions, $permission->name);
        }

        $doctors = $this->getDoctors();

        $data = array(
            'permissions' => $permissions,
            'doctors' => $doctors
        );

        
        // dd($data);
        return view('doctors-management.list')->with('data',$data);

    }

    public function getDoctors(){
        if(Auth::user()->type == 2){
            return DoctorDetail::where('user_id',Auth::user()->id)->where('status',null)->get();
        }else{
            return DoctorDetail::where('status',null)->get();
        }
    }

    public function edit(Request $request){
        $doctorsDetail = DoctorDetail::find($request->id);
        $doctorsAccount = User::find($doctorsDetail->user_id);

        $user = User::where('id', Auth::user()->id)->with('usertype','usertype.permissions')->get();
        $permissions = [];
        foreach($user[0]->usertype->permissions as $permission)
        {
            array_push($permissions, $permission->name);
        }
        $data = array(
            'permissions' => $permissions,
            'doctorsDetail' => $doctorsDetail,
            'doctorsAccount' => $doctorsAccount
        );

        return view('doctors-management.edit')->with('data',$data);
    }

    public function update(Request $request){
        $doctorsDetail = DoctorDetail::find($request->id);
        $doctorsAccount = User::find($request->user_id);

        $doctorsAccount->name = $request->fullname;
        $doctorsAccount->save();

        $doctorsDetail->fullname = $request->fullname;
        $doctorsDetail->gender = $request->gender;
        $doctorsDetail->specialization = $request->specialization;
        $doctorsDetail->address = $request->address;
        $doctorsDetail->save();

        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Updated a doctor details'
        ]);

        Alert::success('', 'Doctor Details Updated!');

        return back();

    }

    public function delete(Request $request){
        $doctorsDetail = DoctorDetail::find($request->id);
        $doctorsAccount = User::find($doctorsDetail->user_id);

        $user = User::where('id', Auth::user()->id)->with('usertype','usertype.permissions')->get();
        $permissions = [];
        foreach($user[0]->usertype->permissions as $permission)
        {
            array_push($permissions, $permission->name);
        }
        $data = array(
            'permissions' => $permissions,
            'doctorsDetail' => $doctorsDetail,
            'doctorsAccount' => $doctorsAccount
        );

        return view('doctors-management.delete_confirm')->with('data',$data);
    }

    public function deleteDoctor(Request $request)
    {

        $user = User::find($request->user_id);
        $user->status = "Deactivated";
        $user->save();

        $doctorsDetail = DoctorDetail::find($request->id);
        $doctorsDetail->status = "Deactivated";
        $doctorsDetail->save();

        $employee = Employee::where('user_id',$request->user_id)->first();
        if($employee != null)
        {
            $employee->status = "Deactivated";
            $employee->save();
        }

        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Archived a doctor account'
        ]);

        Alert::success('', 'Doctor has been archived!');

        return redirect('/doctors-list');
    }
    public function doctors_schedule()
    {
        $user = User::where('id', Auth::user()->id)->with('usertype','usertype.permissions')->get();
        $permissions = [];
        foreach($user[0]->usertype->permissions as $permission)
        {
            array_push($permissions, $permission->name);
        }

        $doctors = $this->getDoctors();

        $data = array(
            'permissions' => $permissions,
            'doctors' => $doctors
        );

        $schedules = DoctorSchedule::where('doctor_id',auth()->user()->id)->orderBy('schedule_date','desc')->get();
        return view('doctors-management.doctors_schedule', array(
            'data' => $data,
            'schedules' => $schedules,
        
        ));
    }
    public function create_schedule ()
    {
        $user = User::where('id', Auth::user()->id)->with('usertype','usertype.permissions')->get();
        $permissions = [];
        foreach($user[0]->usertype->permissions as $permission)
        {
            array_push($permissions, $permission->name);
        }

        $doctors = User::where('type','=',2)->with('doctorDetails')->get();
        $patients = User::where('type', '=' , 3)->with('patientDetails')->get();
        $schedules = DoctorSchedule::with('doctor_infor')->where('doctor_id',auth()->user()->id)->orderBy('schedule_date','desc')->get();
        $data = array(
            'permissions' => $permissions,
            'doctors'     => $doctors,
            'patients'    => $patients
        );

        return view('doctors-management.create',
        array(
            'data'=>$data,
            'schedules'=>$schedules,
        ));
    }

    public function check_schedule_doctor_data(Request $request)
    {
        $schedule = DoctorSchedule::where('schedule_date',$request->date)->where('doctor_id',auth()->user()->id)->get();
     
        return $schedule;
        
    }
    public function save_schedule(Request $request)
    {
        // dd($request->all());
        $doctor_schedule = new DoctorSchedule;
        $doctor_schedule->doctor_id = auth()->user()->id;
        $doctor_schedule->schedule_date = $request->date;
        $doctor_schedule->date_from = $request->from_time;
        $doctor_schedule->date_to = $request->to_time;
        $doctor_schedule->created_by = auth()->user()->id;
        $doctor_schedule->save();
        Alert::success('', 'Schedule saved');
        return redirect()->route('doctors-schedule');
    }
    public function delete_schedule(Request $request,$id)
    {
        // dd($id);
        $schedule = DoctorSchedule::find($id)->delete();
        Alert::success('', 'Schedule deleted');
        return redirect()->route('doctors-schedule');
    }
}

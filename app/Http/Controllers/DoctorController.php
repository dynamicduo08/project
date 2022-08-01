<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\DoctorDetail;
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
}

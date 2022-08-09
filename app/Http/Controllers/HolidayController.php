<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Holiday;
use RealRashid\SweetAlert\Facades\Alert;
class HolidayController extends Controller
{
    //

    public function holiday()
    {
        $user = User::where('id', Auth::user()->id)->with('usertype','usertype.permissions')->get();
        $permissions = [];
        $holidays = Holiday::where('status','Permanent')
        ->orderBy('holiday_date','asc')->get();
        $holidays_a = Holiday::where('status',null)->whereYear('holiday_date', '=', date('Y'))->get();
        foreach($user[0]->usertype->permissions as $permission)
        {
            array_push($permissions, $permission->name);
        }

        $data = array(
            'permissions' => $permissions,
        );

        return view('employees.holidays',array(
            'data'=>$data,
            'holidays'=>$holidays,
            'holidays_a'=>$holidays_a,
        
        ));
    }

    public function new_holiday(Request $request)
    {
        
        $new_holiday = new Holiday;
        $new_holiday->holiday_name = $request->holiday_name;
        $new_holiday->holiday_type = $request->holiday_type;
        $new_holiday->holiday_date = $request->holiday_date;
        $new_holiday->save();

        Alert::success('', 'New Holiday Store');
        return back();
        
    }

    public function edit_holiday(Request $request,$id)
    {
        $holiday = Holiday::findOrfail($id);
        $holiday->holiday_name = $request->holiday_name;
        $holiday->holiday_type = $request->holiday_type;
        $holiday->holiday_date = $request->holiday_date;
        $holiday->save();
        Alert::success('', 'Successfully Updated');
        return back();
    }
    public function delete_holiday(Request $request,$id)
    {
       $holiday = Holiday::findOrfail($id);
       $holiday->delete();
       Alert::success('', 'Succesfully Deleted');
       return back();
    }
}

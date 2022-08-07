<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Deduction;
use RealRashid\SweetAlert\Facades\Alert;

class DeductionController extends Controller
{
    //

    public function deductions()
    {
        $user = User::where('id', Auth::user()->id)->with('usertype','usertype.permissions')->get();
        $permissions = [];
        foreach($user[0]->usertype->permissions as $permission)
        {
            array_push($permissions, $permission->name);
        }
        $deductions = Deduction::get();
        $data = array(
            'permissions' => $permissions,
        );

        return view('employees.deduction_list',array(
            'data' => $data,
            'deductions' => $deductions,

        
        ));
    }
    public function edit_deductions(Request $request,$id)
    {

        $deduction = Deduction::findOrfail($id);
        $deduction->amount = $request->amount;
        $deduction->percent = $request->percent;
        $deduction->save();
        Alert::success('', 'Successfully Updated');
        return back();
    }
}

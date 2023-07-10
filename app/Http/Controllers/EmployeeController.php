<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Module;
use App\Model\Territory;
use App\Model\UserModule;
use App\Model\SubTerritory;
use App\Model\UserTerritory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;

class EmployeeController extends GlobalController
{
    public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    //Employee List
    public function employeeList(){

        $getEmployee = User::where('is_delete',0)
                            ->with([
                                'get_territory' => function($q){ 
                                    $q->with([
                                        'territory_name', 
                                        'sub_territory'
                                    ]); 
                                }])
                            ->get();

        return view('employee.employee_list',compact('getEmployee'));
    }

    //Add Employee
    public function addEmployee(){

        $getModule = Module::all();

        $get_territories = Territory::where('is_active',1)->where('is_delete',0)->get();

        return view('employee.add_employee',compact('getModule','get_territories'));
    }

    //Save Employee
    public function saveEmployee(Request $request){
        
        
        $save_user = new User;
        $save_user->name = $request->full_name;
        if($request->dob != ''){
            $save_user->dob = $this->convertDate($request->dob);
        }

        if($request->joining_date != ''){
            $save_user->joining_date = $this->convertDate($request->joining_date);
        }

        $save_user->address = $request->address;
        $save_user->mobile = $request->mobile_number;
        $save_user->email = $request->email_id;
        $save_user->password = bcrypt($request->password);
        
        if(isset($request->profile)){
            $profile_image = $this->uploadImage($request->profile,'employee');
            $save_user->profile_image = $profile_image;    
        }
        $save_user->remarks = $request->remarks;
        $save_user->save();

        if(!is_null($request->module)){
            foreach($request->module as $mk => $mv){
                $module = new UserModule;
                $module->employee_id = $save_user->id;
                $module->module_id = $mv;
                $module->save();
            }
        }

        $territories_details = array();
        if(!is_null($request->territories)){
            foreach($request->territories as $tk => $tv){
                $territories_details[$tk]['territories'] = $tv;
            }
        }

        if(!is_null($request->sub_territories)){
            foreach($request->sub_territories as $sk => $sv){
                $territories_details[$sk]['sub_territories'] = $sv;
            }
        }

        if(!is_null($territories_details)){
            foreach($territories_details as $dk => $dv){
               
                $save_territories = new UserTerritory;
                $save_territories->employee_id = $save_user->id;
                if(isset($dv['territories'])){
                    $save_territories->territories_id = $dv['territories'];    
                } else {
                    if(isset($dv['sub_territories'])){
                        $main_territory = SubTerritory::where('id',$dv['sub_territories'])->where('is_delete',0)->first();
                        $save_territories->territories_id = $main_territory->territory_id;    
                    }
                }
                if(isset($dv['sub_territories'])){
                    $save_territories->sub_territories = $dv['sub_territories'];
                }
                $save_territories->save();
            }
        }

        
        if($request->btn_submit == 'save_and_update'){

            return redirect(route('admin.addEmployee'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Employee',
                    'message' => 'Employee Successfully Added',
                ],
            ]); 

        } else {

            return redirect(route('admin.employeeList'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Employee',
                    'message' => 'Employee Successfully Added',
                ],
            ]); 
        }
    }

    //Edit Employee
    public function editEmployee($id){

        $getModule = Module::all();

        $findEmployee = User::where('id',$id)->first();

        $getModuleId = UserModule::where('employee_id',$id)->pluck('module_id')->toArray();

        $terretory_id = UserTerritory::where('employee_id',$id)->pluck('territories_id')->toArray();

        $sub_terretory_id = UserTerritory::where('employee_id',$id)->pluck('sub_territories')->toArray();

        $get_all_territory = Territory::where('is_active',1)->where('is_delete',0)->get();

        $get_sub_territory = SubTerritory::whereIn('territory_id',$terretory_id)->where('is_active',1)->where('is_delete',0)->get();
        
        return view('employee.edit_employee',compact('findEmployee','getModule','getModuleId','terretory_id','sub_terretory_id','get_all_territory','get_sub_territory'));
    }

    //Save Edited Employee Module
    public function saveEditedEmployee(Request $request){

        $save_user = User::findOrFail($request->id);
        $save_user->name = $request->full_name;
        if($request->dob != ''){
            $save_user->dob = $this->convertDate($request->dob);
        }

        if($request->joining_date != ''){
            $save_user->joining_date = $this->convertDate($request->joining_date);
        }

        $save_user->address = $request->address;
        $save_user->mobile = $request->mobile_number;
        $save_user->email = $request->email_id;
        if(isset($request->passwrod) && ($request->password != '')){
            $save_user->password = bcrypt($request->password);
        }
        if(isset($request->profile)){
            $profile_image = $this->uploadImage($request->profile,'employee');
            $save_user->profile_image = $profile_image;    
        }
        $save_user->remarks = $request->remarks;
        $save_user->save();

        $removeModule = UserModule::where('employee_id',$request->id)->delete();

        if(!is_null($request->module)){
            foreach($request->module as $mk => $mv){
                $module = new UserModule;
                $module->employee_id = $request->id;
                $module->module_id = $mv;
                $module->save();
            }
        }

        $territories_details = array();
        if(!is_null($request->territories)){
            foreach($request->territories as $tk => $tv){
                $territories_details[$tk]['territories'] = $tv;
            }
        }

        if(!is_null($request->sub_territories)){
            foreach($request->sub_territories as $sk => $sv){
                $territories_details[$sk]['sub_territories'] = $sv;
            }
        }

        if(!is_null($territories_details)){
            $removeTerritories = UserTerritory::where('employee_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
              
                $save_territories = new UserTerritory;
                $save_territories->employee_id = $save_user->id;
                if(isset($dv['territories'])){
                    $save_territories->territories_id = $dv['territories'];    
                } else {
                    if(isset($dv['sub_territories'])){
                        $main_territory = SubTerritory::where('id',$dv['sub_territories'])->where('is_delete',0)->first();
                        $save_territories->territories_id = $main_territory->territory_id;    
                    }
                }
                if(isset($dv['sub_territories'])){
                    $save_territories->sub_territories = $dv['sub_territories'];
                }
                $save_territories->save();
            }
        }

        return redirect(route('admin.employeeList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Employee',
                'message' => 'Employee Successfully Added',
            ],
        ]); 
    }

    //Delete Employee
    public function deleteEmployee($id){

        $deleteEmployee = User::where('id',$id)->update(['is_delete' => 1]);

        return redirect(route('admin.employeeList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Employee',
                'message' => 'Employee Successfully Deleted',
            ],
        ]); 

    }
    
    //Check Email Exists or not
    public function checkEmailExists(Request $request){

        $query = User::query();
        $query->where('email',$request->email_id);
        $query->where('is_delete',0);
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $admin = $query->first();
        
        return (!is_null($admin) ? 'false' : 'true');       
        
    }

    //change employee status
    public function employeeChangeStatus(Request $request){

        $updateStatus = User::where('id',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';

    }
}

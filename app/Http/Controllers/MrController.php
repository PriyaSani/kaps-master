<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\MrDetail;
use App\Model\Territory;
use App\Model\MrTerritory;
use App\Model\SubTerritory;
use App\Model\Stockiest;
use App\Model\MedicalStore;
use App\Model\SalesHistory;
use Illuminate\Http\Request;
use App\Model\MrWiseStockiestData;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Model\StockiestWiseMedicalStoreData;

class MrController extends GlobalController
{
    public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    // MR List
    public function mrList(){

        if(Auth::guard()->user()->id != 1){
            $get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
            $get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));
         
            $get_mr = MrDetail::where('is_delete',0)
                                ->with([
                                    'get_territory' => function($q){ 
                                        $q->with([
                                            'territory_name',
                                            'sub_territory'
                                        ]);
                                    }
                                ])
                                ->whereHas('territory_detail', function ($query) use ($get_user_territory) { 
                                    $query->whereIn('territories_id', $get_user_territory); 
                                })
                                ->WhereHas('territory_detail', function ($query) use ($get_user_sub_territory) { 
                                    $query->whereIn('sub_territories',$get_user_sub_territory); 
                                })
                                ->get();

        } else {
            $get_mr = MrDetail::where('is_delete',0)
                              ->with([
                                'get_territory' => function($q){ 
                                    $q->with([
                                        'territory_name', 
                                        'sub_territory'
                                    ]); 
                                }
                              ])
                              ->get();
        }

        return view('mr.mr_list',compact('get_mr'));
    }

    // Add MR
    public function addMr(){

        $get_territories = Territory::where('is_active',1)->where('is_delete',0)->orderBy('id','ASC')->get();

        return view('mr.add_mr',compact('get_territories'));
    }

    // Save MR
    public function saveMr(Request $request){

        $save_mr = new MrDetail;
        $save_mr->full_name = $request->full_name;
        if($request->dob != ''){
            $save_mr->dob = $this->convertDate($request->dob);
        }

        if($request->joining_date != ''){
            $save_mr->joining_date = $this->convertDate($request->joining_date);
        }

        $save_mr->address = $request->address;
        $save_mr->mobile_number = $request->mobile_number;
        $save_mr->email = $request->email_id;
        $save_mr->password = bcrypt($request->password);
        
        if(isset($request->profile)){
            $profile_image = $this->uploadImage($request->profile,'mr');
            $save_mr->profile_image = $profile_image;    
        }
        $save_mr->remarks = $request->remarks;
        $save_mr->save();

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

        // MR territories and sub territories
        $territories = array();
        $sub_territories = array();
        if(!is_null($territories_details)){
            foreach($territories_details as $dk => $dv){
               
                $save_territories = new MrTerritory;
                $save_territories->mr_id = $save_mr->id;
                if(isset($dv['territories'])){
                    $save_territories->territories_id = $dv['territories'];    
                    $territories[] = $dv['territories'];
                } else {
                    if(isset($dv['sub_territories'])){
                        $get_territory = SubTerritory::where('id',$dv['sub_territories'])->first();
                        $save_territories->territories_id = $get_territory->territory_id;
                        $territories[] = $get_territory->territory_id;
                    }
                }
                if(isset($dv['sub_territories'])){
                    $save_territories->sub_territories = $dv['sub_territories'];
                    $sub_territories[] = $dv['sub_territories'];
                }
                $save_territories->save();

            }
        }
                
        /*//get current month
        $current_month = date("m");

        //get current date
        $current_date = date("Y-m-d");

        //current month sales data
        $get_current_sales_data = SalesHistory::where('mr_id',$save_mr->id)->whereMonth('sales_month',$current_month)->get();

        //save sales data
        if($get_current_sales_data->isEmpty()){
                
            $save_sales_data = new SalesHistory;
            $save_sales_data->mr_id = $save_mr->id;
            $save_sales_data->sales_month = $current_date;
            $save_sales_data->save();
            
        }
        
        //stockist
        $get_stockiest = Stockiest::with(['stockiest_territories'])->where('is_delete',0)->get();

        //get stockiest depend on mr territories & sub territories
        $stockies_id = array();
        if(!empty($get_stockiest)){
            foreach ($get_stockiest as $sk => $sv) {
                foreach ($sv['stockiest_territories'] as $tk => $tv) {
                    if(in_array($tv['territories_id'],$territories) && in_array($tv['sub_territories'],$sub_territories)){
                        $stockies_id[] = $sv->id;
                    }
                }
            }
        }

        if(isset($save_sales_data->id)){
            $territorist_stockiest = Stockiest::whereIn('id',$stockies_id)->with(['stockiest_user','stockiest_territories'])->where('is_delete',0)->get();
        }else{
            $territorist_stockiest = array();
        }
        
        if(isset($save_sales_data->id)){

            $check_data = MrWiseStockiestData::where('sales_id',$save_sales_data->id)->where('sales_month',$current_month)->first();    

        }else{

            $check_data = array();

        }
        

        //get mr territories
        if(isset($save_sales_data->id)){

            $get_mr_territories = SalesHistory::with(['mr_detail' => function($q){ $q->with(['get_territory']); } ,'user_detail'])->where('id',$save_sales_data->id)->first();    

        }else{

            $get_mr_territories = array();

        }
        

        //save stockiest data
        if(empty($check_data)){
            if(!empty($territorist_stockiest)){

                foreach ($territorist_stockiest as $sk => $sv) {
                    $save_stockiest = new MrWiseStockiestData;
                    $save_stockiest->stockiest_id = $sv->id;
                    $save_stockiest->sales_id = $save_sales_data->id;
                    $save_stockiest->mr_id = $save_mr->id;
                    $save_stockiest->sales_month = $current_date;
                    $save_stockiest->priority = 0;
                    $save_stockiest->save();
                }
                
            }
        }*/

        if($request->btn_submit == 'save_and_update'){

            return redirect(route('admin.addMr'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Mr',
                    'message' => 'Mr Successfully Added',
                ],
            ]); 

        } else {

            return redirect(route('admin.mrList'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Mr',
                    'message' => 'Mr Successfully Added',
                ],
            ]); 
        }
    }

    // Edit MR
    public function editMr($id){

        $get_mr = MrDetail::where('id',$id)->first();

        $terretory_id = MrTerritory::where('mr_id',$id)->pluck('territories_id')->toArray();

        $sub_terretory_id = MrTerritory::where('mr_id',$id)->pluck('sub_territories')->toArray();

        $get_all_territory = Territory::where('is_active',1)->where('is_delete',0)->orderBy('id','ASC')->get();

        $get_sub_territory = SubTerritory::whereIn('territory_id',$terretory_id)->where('is_active',1)->where('is_delete',0)->orderBy('territory_id','ASC')->get();

        return view('mr.edit_mr',compact('get_mr','terretory_id','sub_terretory_id','get_all_territory','get_sub_territory'));
    }

    // Save Edited MR Module
    public function saveEditedMr(Request $request){

        $save_mr = MrDetail::findOrFail($request->id);
        $save_mr->full_name = $request->full_name;
        if($request->dob != ''){
            $save_mr->dob = $this->convertDate($request->dob);
        }

        if($request->joining_date != ''){
            $save_mr->joining_date = $this->convertDate($request->joining_date);
        }

        $save_mr->address = $request->address;
        $save_mr->mobile_number = $request->mobile_number;
        $save_mr->email = $request->email_id;
        $save_mr->password = bcrypt($request->password);
        
        if(isset($request->profile)){
            $profile_image = $this->uploadImage($request->profile,'mr');
            $save_mr->profile_image = $profile_image;    
        }
        
        $save_mr->remarks = $request->remarks;
        $save_mr->save();

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

        // MR territories and sub territories
        $territories = array();
        $sub_territories = array();
        if(!is_null($territories_details)){
            $removeTerritories = MrTerritory::where('mr_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
               
                $save_territories = new MrTerritory;
                $save_territories->mr_id = $request->id;
                if(isset($dv['territories'])){
                    $save_territories->territories_id = $dv['territories'];  
                    $territories[] = $dv['territories'];
                } else {
                    if(isset($dv['sub_territories'])){
                        $get_territory = SubTerritory::where('id',$dv['sub_territories'])->first();
                        $save_territories->territories_id = $get_territory->territory_id;
                        $territories[] = $get_territory->territory_id;
                    }
                }
                if(isset($dv['sub_territories'])){
                    $save_territories->sub_territories = $dv['sub_territories'];
                    $sub_territories[] = $dv['sub_territories'];
                }
                $save_territories->save();
            }
        }

        return redirect(route('admin.mrList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Mr',
                'message' => 'Mr Successfully Added',
            ],
        ]); 
    }

    // Delete MR
    public function deleteMr($id){

        $deleteEmployee = MrDetail::where('id',$id)->update(['is_delete' => 1]);

        return redirect(route('admin.mrList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Mr',
                'message' => 'Mr Successfully Deleted',
            ],
        ]); 

    }
    
    // Check Email Exists or not
    public function checkMrEmailExists(Request $request){

        $query = MrDetail::query();
        $query->where('email',$request->email_id);
        $query->where('is_delete',0);
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $admin = $query->first();

        if(!is_null($admin)){
            return 'false';
        } else {
            return 'true';
        }
    }

    // Change MR status
    public function mrChangeStatus(Request $request){

        $updateStatus = MrDetail::where('id',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
        
    }
}

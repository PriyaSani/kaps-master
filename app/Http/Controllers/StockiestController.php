<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\Stockiest;
use App\Model\Territory;
use App\Model\SubTerritory;
use Illuminate\Http\Request;
use App\Model\AssociatedUser;
use App\Model\StockiestUser;
use App\Model\StockiestTerritory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;

class StockiestController extends GlobalController
{
    public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    // Stockiest List
    public function stockiestList(){

        if(Auth::guard()->user()->id != 1){
            $get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
            $get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));

            $get_stockiest = Stockiest::where('is_delete',0)
                                      ->with([
                                        'stockiest_user',
                                        'stockiest_territories' =>  function($q){ 
                                            $q->with([
                                                'territory_name',
                                                'sub_territory'
                                            ]); 
                                        }
                                      ])
                                      ->whereHas('stockiest_territories', function ($query) use ($get_user_territory) { 
                                            $query->whereIn('territories_id', $get_user_territory); 
                                        }
                                      )
                                      ->WhereHas('stockiest_territories', function ($query) use ($get_user_sub_territory)
                                        { 
                                            $query->whereIn('sub_territories',$get_user_sub_territory); 
                                        }
                                      )->get();
        } else {
            $get_stockiest = Stockiest::where('is_delete',0)
                                      ->with([
                                        'stockiest_user',
                                        'stockiest_territories' =>  function($q){ 
                                            $q->with([
                                                'territory_name',
                                                'sub_territory'
                                            ]); 
                                        }
                                      ])
                                      ->get();
        }

        return view('stockiest.stockiest_list',compact('get_stockiest'));
    }

    // Add stockiest
    public function addStockiest(){

        $get_territories = Territory::where('is_active',1)->where('is_delete',0)->get();

        return view('stockiest.add_stockiest',compact('get_territories'));
    }

    // Save stockiest
    public function saveStockiest(Request $request){

        $save_stockiest = new Stockiest;
        $save_stockiest->stockiest_name = $request->stockiest_name;
        if($request->stockiest_address != ''){
            $save_stockiest->stockiest_address = $request->stockiest_address;
        }

        if($request->stockiest_phone_number != ''){
            $save_stockiest->stockiest_phone_number = $request->stockiest_phone_number;
        }

        if($request->stockiest_email_id != ''){
            $save_stockiest->stockiest_email_id = $request->stockiest_email_id;
        }

        if($request->gst_number != ''){
            $save_stockiest->gst_number = strtoupper($request->gst_number);
        }

        $save_stockiest->save();

        $territories_details = array();

        if(!is_null($request->territories)){
            foreach($request->territories as $tk => $tv){
                $territories_details[$tk]['territories'] = $tv;
                
                //temp fix
                $getsub = SubTerritory::where('territory_id',$tv)
                                      ->whereIn('id',$request->sub_territories)
                                      ->where('is_active',1)->where('is_delete',0)->pluck('id');

                if(!is_null($getsub)){
                    foreach($getsub as $sk => $sv){
                        if(in_array($sv,$request->sub_territories)){
                            $territories_details[$tk]['sub_territories'][] = $sv;
                        }
                    }
                }                                      
            }
        }

        if(!is_null($territories_details)){
            $removeTerritories = StockiestTerritory::where('stockiest_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
                if(isset($dv['sub_territories'])){
                    foreach($dv['sub_territories']  as $sk => $sv) {
                        $save_territories = new StockiestTerritory;    
                        $save_territories->stockiest_id = $save_stockiest->id;
                        $save_territories->territories_id = $dv['territories'];
                        $save_territories->sub_territories = $sv; 
                        $save_territories->save();
                    }
                }
            }
        }

        /*if(!is_null($request->territories)){
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
               
                $save_territories = new StockiestTerritory;
                $save_territories->stockiest_id = $save_stockiest->id;
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
        }*/

        if(isset($request->data) && !is_null($request->data)){
        	$deleteAssociatedUser = StockiestUser::where('stockiest_id',$save_stockiest->id)->delete();
            foreach($request->data as $ck => $cv){
                $updatedata = AssociatedUser::where('id',$cv['id'])->update(['stockiest_associate' => 1]);
                $medical_store_user = new StockiestUser;
                $medical_store_user->stockiest_id  = $save_stockiest->id;
                $medical_store_user->associated_user_id  = $cv['id'];
               	$medical_store_user->engagement_type  = $cv['engagement_type'];
               	$medical_store_user->role  = $cv['role'];
                $medical_store_user->save();

            }
        } else {
            $deleteAssociatedUser = StockiestUser::where('stockiest_id',$save_stockiest->id)->delete();
        }

        if($request->btn_submit == 'save_and_update'){

            return redirect(route('admin.addStockiest'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Stockiest',
                    'message' => 'Stockiest Successfully Added',
                ],
            ]); 

        } else {

            return redirect(route('admin.stockiestList'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Stockiest',
                    'message' => 'Stockiest Successfully Added',
                ],
            ]); 
        }
    }

    // Edit stockiest
    public function editStockiest($id){

        $get_stockiest_detail = Stockiest::with(['stockiest_user' => function($q){ $q->with(['stockiest_user_detail']); }])->where('id',$id)->first();

        $terretory_id = StockiestTerritory::where('stockiest_id',$id)->pluck('territories_id')->toArray();

        $sub_terretory_id = StockiestTerritory::where('stockiest_id',$id)->pluck('sub_territories')->toArray();

        $get_all_territory = Territory::where('is_active',1)->where('is_delete',0)->get();

        $get_sub_territory = SubTerritory::whereIn('territory_id',$terretory_id)->where('is_active',1)->where('is_delete',0)->get();
       	
       	$user_id = array();

        if(!is_null($user_id)){
            foreach($get_stockiest_detail['stockiest_user'] as $cuk => $cuv){
                $user_id[] = $cuv->id;
            }
        }
        
        return view('stockiest.edit_stockiest',compact('get_stockiest_detail','terretory_id','sub_terretory_id','get_all_territory','get_sub_territory','user_id'));
    }

    // Update stockiest
    public function saveEditedStockiest(Request $request){
    	
        $save_stockiest = Stockiest::findOrFail($request->id);
        $save_stockiest->stockiest_name = $request->stockiest_name;
        if($request->stockiest_address != ''){
            $save_stockiest->stockiest_address = $request->stockiest_address;
        }

        if($request->stockiest_phone_number != ''){
            $save_stockiest->stockiest_phone_number = $request->stockiest_phone_number;
        }

        if($request->stockiest_email_id != ''){
            $save_stockiest->stockiest_email_id = $request->stockiest_email_id;
        }

        if($request->gst_number != ''){
            $save_stockiest->gst_number = strtoupper($request->gst_number);
        }

        $save_stockiest->save();

        $territories_details = array();

        if(!is_null($request->territories)){
            foreach($request->territories as $tk => $tv){
                $territories_details[$tk]['territories'] = $tv;
                
                //temp fix
                $getsub = SubTerritory::where('territory_id',$tv)
                                      ->whereIn('id',$request->sub_territories)
                                      ->where('is_active',1)->where('is_delete',0)->pluck('id');

                if(!is_null($getsub)){
                    foreach($getsub as $sk => $sv){
                        if(in_array($sv,$request->sub_territories)){
                            $territories_details[$tk]['sub_territories'][] = $sv;
                        }
                    }
                }                                      
            }
        }
        
        // if(!is_null($request->sub_territories)){
        //     foreach($request->sub_territories as $sk => $sv){

        //     }
        // }

        // if(!is_null($request->sub_territories)){
        //     foreach($request->sub_territories as $sk => $sv){
        //         $territories_details[$sk]['sub_territories'] = $sv;
        //     }
        // }

        if(!is_null($territories_details)){
            $removeTerritories = StockiestTerritory::where('stockiest_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
                if(isset($dv['sub_territories'])){
                    foreach($dv['sub_territories']  as $sk => $sv) {
                        $save_territories = new StockiestTerritory;    
                        $save_territories->stockiest_id = $request->id;
                        $save_territories->territories_id = $dv['territories'];
                        $save_territories->sub_territories = $sv; 
                        $save_territories->save();
                    }
                }
            }
        }

         if(isset($request->data) && !is_null($request->data)){
        	$deleteAssociatedUser = StockiestUser::where('stockiest_id',$save_stockiest->id)->delete();
            foreach($request->data as $ck => $cv){
                $updatedata = AssociatedUser::where('id',$cv['id'])->update(['stockiest_associate' => 1]);

                $medical_store_user = new StockiestUser;
                $medical_store_user->stockiest_id  = $save_stockiest->id;
                $medical_store_user->associated_user_id  = $cv['id'];
               	$medical_store_user->engagement_type  = $cv['engagement_type'];
               	$medical_store_user->role  = $cv['role'];
                $medical_store_user->save();

            }
        } else {
            $deleteAssociatedUser = StockiestUser::where('stockiest_id',$save_stockiest->id)->delete();
        }

        return redirect(route('admin.stockiestList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Stockiest',
                'message' => 'Stockiest Successfully Updated',
            ],
        ]); 
    }

    // Delete stockiest
    public function deleteStockiest($id){

        $deleteMedicalStore = Stockiest::where('id',$id)->update(['is_delete' => 1]);

        //Territories
        $deleteMedicalTerretories = StockiestTerritory::where('stockiest_id',$id)->update(['is_delete' => 1]);

        //Associated users
        $getAssociatedUsers = StockiestUser::where('stockiest_id',$id)->pluck('associated_user_id');

        $deleteMedicalTerretories = StockiestUser::where('stockiest_id',$id)->update(['is_delete' => 1]);

        $ChangeStatusStockiestUsers = AssociatedUser::whereIn('id',$getAssociatedUsers)->update(['stockiest_associate' => 0]);

        return redirect(route('admin.stockiestList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Stockiest',
                'message' => 'Stockiest Successfully Deleted',
            ],
        ]); 

    }
    
    // Check stockiest GST number Exists or not
    public function stockiestGstNumber(Request $request){

        $query = Stockiest::query();
        $query->where('gst_number',$request->gst_number);
        $query->where('is_delete',0);
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $gst_number = $query->first();
        
        return $gst_number ? 'false' : 'true';

    }

    // Stockiest users
    public function stockiestUsers(Request $request){

        //Associated users
        $deleteStockiestUsers = AssociatedUser::where('id',$request->id)->update(['stockiest_associate' => 0]);

        $get_stockiest_detail = Stockiest::with(['stockiest_user' => function($q){ $q->with(['stockiest_user_detail']); }])->where('id',$request->id)->first();
        
        return view('stockiest.store_users',compact('get_stockiest_detail'));
    }

    // Remove stockiest users
    public function removeStockiestUsers(Request $request){

        // Associated users
        $deleteMedicalUsers = StockiestUser::where('stockiest_id',$request->stockiest_id)->where('associated_user_id',$request->id)->delete();

        return $deleteMedicalUsers ? 'true' : 'false';

    }
}

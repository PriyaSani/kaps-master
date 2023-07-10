<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\Territory;
use App\Model\SubTerritory;
use App\Model\MedicalStore;
use Illuminate\Http\Request;
use App\Model\AssociatedUser;
use App\Model\StockiestUser;
use App\Model\MedicalStoreUser;
use App\Model\MedicalStoreTerritory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;

class MedicalStoreController extends GlobalController
{
    public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    //Store List
    public function storeList(){

        if(Auth::guard()->user()->id != 1){
            $get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
            $get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));

            $get_store = MedicalStore::where('is_delete',0)
                                     ->with([
                                        'medical_store_user',
                                        'mendical_store_territories' => function($q){ 
                                            $q->with([
                                                'territory_name',
                                                'sub_territory'
                                            ]); 
                                        }
                                     ])
                                     ->whereHas('mendical_store_territories', function ($query) use ($get_user_territory)
                                        { 
                                            $query->whereIn('territories_id', $get_user_territory); 
                                        }
                                     )
                                     ->WhereHas('mendical_store_territories', function ($query) use ($get_user_sub_territory) { 
                                            $query->whereIn('sub_territories',$get_user_sub_territory); 
                                        }
                                     )
                                     ->get();

        } else {
            $get_store = MedicalStore::where('is_delete',0)
                                     ->with([
                                            'medical_store_user',
                                            'mendical_store_territories' => function($q){ 
                                                $q->with([
                                                    'territory_name',
                                                    'sub_territory'
                                                ]); 
                                            }
                                        ])
                                     ->get();
        }
        
        return view('medical_store.store_list',compact('get_store'));
    }

    //Add Store
    public function addStore(){

        $get_territories = Territory::where('is_active',1)->where('is_delete',0)->orderBy('id','ASC')->get();

        return view('medical_store.add_store',compact('get_territories'));
    }

    //Save Store
    public function saveStore(Request $request){

        $save_store = new MedicalStore;
        $save_store->store_name = $request->store_name;
        if($request->store_address != ''){
            $save_store->store_address = $request->store_address;
        }

        if($request->store_phone_number != ''){
            $save_store->store_phone_number = $request->store_phone_number;
        }

        if($request->store_email_id != ''){
            $save_store->store_email_id = $request->store_email_id;
        }

        if($request->gst_number != ''){
            $save_store->gst_number = strtoupper($request->gst_number);
        }

        $save_store->save();

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
            $removeTerritories = MedicalStoreTerritory::where('medical_store_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
                if(isset($dv['sub_territories'])){
                    foreach($dv['sub_territories']  as $sk => $sv) {
                        $save_territories = new MedicalStoreTerritory; 
                        $save_territories->medical_store_id = $save_store->id;
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
               
                $save_territories = new MedicalStoreTerritory;
                $save_territories->medical_store_id = $save_store->id;
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
        	$deleteAssociatedUser = MedicalStoreUser::where('medical_store_id',$save_store->id)->delete();
            foreach($request->data as $ck => $cv){
                $updatedata = AssociatedUser::where('id',$cv['id'])->update(['medical_associate' => 1]);
                $medical_store_user = new MedicalStoreUser;
                $medical_store_user->medical_store_id  = $save_store->id;
                $medical_store_user->associated_user_id  = $cv['id'];
               	$medical_store_user->engagement_type  = $cv['engagement_type'];
               	$medical_store_user->role  = $cv['role'];
                $medical_store_user->save();

            }
        } else {
            $deleteAssociatedUser = MedicalStoreUser::where('medical_store_id',$save_store->id)->delete();
        }

        if($request->btn_submit == 'save_and_update'){

            return redirect(route('admin.addStore'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Medical Store',
                    'message' => 'Medical Store Successfully Added',
                ],
            ]); 

        } else {

            return redirect(route('admin.storeList'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Medical Store',
                    'message' => 'Medical Store Successfully Added',
                ],
            ]); 
        }
    }

    //Edit store
    public function editStore($id){

        $get_store_detail = MedicalStore::with(['medical_store_user' => function($q){ $q->with(['user_detail']); }])->where('id',$id)->first();

        $terretory_id = MedicalStoreTerritory::where('medical_store_id',$id)->pluck('territories_id')->toArray();

        $sub_terretory_id = MedicalStoreTerritory::where('medical_store_id',$id)->pluck('sub_territories')->toArray();

        $get_all_territory = Territory::where('is_active',1)->where('is_delete',0)->get();

        $get_sub_territory = SubTerritory::whereIn('territory_id',$terretory_id)->where('is_active',1)->where('is_delete',0)->get();

        $user_id = array();

        if(!is_null($user_id)){
            foreach($get_store_detail['medical_store_user'] as $cuk => $cuv){
                $user_id[] = $cuv->id;
            }
        }

        return view('medical_store.edit_store',compact('get_store_detail','terretory_id','sub_terretory_id','get_all_territory','get_sub_territory','user_id'));
    }

    //Save Edited store details
    public function saveEditedStore(Request $request){

        $save_store = MedicalStore::findOrFail($request->id);
        $save_store->store_name = $request->store_name;
        if($request->store_address != ''){
            $save_store->store_address = $request->store_address;
        }

        if($request->store_phone_number != ''){
            $save_store->store_phone_number = $request->store_phone_number;
        }

        if($request->store_email_id != ''){
            $save_store->store_email_id = $request->store_email_id;
        }

        if($request->gst_number != ''){
            $save_store->gst_number = strtoupper($request->gst_number);
        }

        $save_store->save();

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
            $removeTerritories = MedicalStoreTerritory::where('medical_store_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
                if(isset($dv['sub_territories'])){
                    foreach($dv['sub_territories']  as $sk => $sv) {
                        $save_territories = new MedicalStoreTerritory; 
                        $save_territories->medical_store_id = $request->id;
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
        }*/

        /*if(!is_null($territories_details)){
            $removeTerritories = MedicalStoreTerritory::where('medical_store_id',$request->id)->delete();
            foreach($territories_details as $dk => $dv){
               
                $save_territories = new MedicalStoreTerritory;
                $save_territories->medical_store_id = $request->id;
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
        	$deleteAssociatedUser = MedicalStoreUser::where('medical_store_id',$save_store->id)->delete();
            foreach($request->data as $ck => $cv){
                $updatedata = AssociatedUser::where('id',$cv['id'])->update(['medical_associate' => 1]);
                $medical_store_user = new MedicalStoreUser;
                $medical_store_user->medical_store_id  = $save_store->id;
                $medical_store_user->associated_user_id  = $cv['id'];
               	$medical_store_user->engagement_type  = $cv['engagement_type'];
               	$medical_store_user->role  = $cv['role'];
                $medical_store_user->save();

            }
        } else {
            $deleteAssociatedUser = MedicalStoreUser::where('medical_store_id',$save_store->id)->delete();
        }

        return redirect(route('admin.storeList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Medical Store',
                'message' => 'Medical Store Successfully Updated',
            ],
        ]); 
    }

    //Delete Store
    public function deleteStore($id){

        $deleteMedicalStore = MedicalStore::where('id',$id)->update(['is_delete' => 1]);

        //Territories
        $deleteMedicalTerretories = MedicalStoreTerritory::where('medical_store_id',$id)->update(['is_delete' => 1]);

        //Associated users
        $getAssociatedUsers = MedicalStoreUser::where('medical_store_id',$id)->pluck('associated_user_id');

        $deleteMedicalUsers = MedicalStoreUser::where('medical_store_id',$id)->update(['is_delete' => 1]);

        $ChangeStatusMedicalUsers = AssociatedUser::whereIn('id',$getAssociatedUsers)->update(['medical_associate' => 0]);

        return redirect(route('admin.storeList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Medical Store',
                'message' => 'Medical Store Successfully Deleted',
            ],
        ]); 

    }
    
    //Check GST number Exists or not
    public function storeGstNumber(Request $request){

        $query = MedicalStore::query();
        $query->where('gst_number',$request->gst_number);
        $query->where('is_delete',0);
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $gst_number = $query->first();
        
        return (!is_null($gst_number) ? 'false' : 'true');
    }

    //Fetch store users
    public function storeUsers(Request $request){

        $get_store_detail = MedicalStore::with(['medical_store_user' => function($q){ $q->with(['user_detail']); }])->where('id',$request->id)->first();

        return view('medical_store.store_users',compact('get_store_detail'));
    }

    // Remove store user
    public function removeStoreUsers(Request $request){

        //associated users
        $deleteMedicalUsers = AssociatedUser::where('id',$request->id)->update(['medical_associate' => 0]);

        $deleteMedicalUsers = MedicalStoreUser::where('medical_store_id',$request->store_id)->where('associated_user_id',$request->id)->delete();

        return $deleteMedicalUsers ? 'true' : 'false';
    }

    //Get associated user list
    public function associatedUserList(Request $request){

        $filter = 0;
        $agency_link_type = '';

        $query = AssociatedUser::query();

        if(isset($request->agency_link_type) && $request->agency_link_type == 1){
            $filter = 1;
            $agency_link_type = $request->agency_link_type;
            $query->where('medical_associate',1);
        }

        if(isset($request->agency_link_type) && $request->agency_link_type == 2){

            $filter = 1;
            $agency_link_type = $request->agency_link_type;
            $query->where('stockiest_associate',1);

        }

        if(isset($request->agency_link_type) && $request->agency_link_type == 3){
            
            $filter = 1;
            $agency_link_type = $request->agency_link_type;
            $query->where('stockiest_associate',1);
            $query->where('medical_associate',1);
        }

        $query->with(['medical_store_user','stockiest_user']);
        $get_associated_users = $query->where('is_delete',0)->get();
        
        if(Auth::guard()->user()->id != 1){
         
            $get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
            $get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));
            if(isset($filter) && $filter == 1){
                $get_users = $query->pluck('id')->toArray();
            }
            
            $get_associated_users = $query->where('is_delete',0)->whereHas('medical_store_user', function ($q) use ($get_user_territory) { $q->whereHas('medical_store_territory', function($q) use ($get_user_territory) {$q->whereIn('territories_id', $get_user_territory);});})->whereHas('medical_store_user', function ($q) use ($get_user_sub_territory) { $q->whereHas('medical_store_territory', function($q) use ($get_user_sub_territory) {$q->whereIn('sub_territories', $get_user_sub_territory);});})->orWhereHas('stockiest_user', function ($q) use ($get_user_territory) { $q->whereHas('stockiest_territory', function($q) use ($get_user_territory) {$q->whereIn('territories_id', $get_user_territory);});})->whereHas('stockiest_user', function ($q) use ($get_user_sub_territory) { $q->whereHas('stockiest_territory', function($q) use ($get_user_sub_territory) {$q->whereIn('sub_territories', $get_user_sub_territory);});})->get();
            if(isset($filter) && $filter == 1){
                $get_associated_users = $get_associated_users->whereIn('id',$get_users);
            }
            
        }
        return view('associated_user.associated_user_list',compact('get_associated_users','filter','agency_link_type'));
    }

    //Edit associated users
    public function editAssociatedUser(Request $request){
        
        $get_user_detail = AssociatedUser::where('id',$request->id)->first();
        
        return view('associated_user.edit_associated_user',compact('get_user_detail'));
    }

    //Update associated user
    public function saveEditedAssociatedUser(Request $request){

        $save_user = AssociatedUser::findOrFail($request->id);
        $save_user->name = $request->name;
        $save_user->email = $request->email;
        $save_user->mobile = $request->mobile;
        $save_user->save();

        return $save_user ? 'true' : 'false';
    }

    // Associated user agencies
    public function associatedUserAgencies(Request $request){

        $get_associated_users = AssociatedUser::where('id',$request->id)->with(['medical_store_user' => function($q){ $q->with(['store_detail']); },'stockiest_user' => function($q){ $q->with(['stockiest_detail']); }])->where('is_delete',0)->first();

        return view('associated_user.user_agencies',compact('get_associated_users'));
    }

    // Remove associated user
    public function removeAssociatedUser(Request $request){

        if($request->type == 1){
           
            $deleteMedicalStore = AssociatedUser::where('id',$request->id)->update(['is_delete' => 1]);
           
            //Medical user
            $deleteMedicalStoreUser = MedicalStoreUser::where('medical_store_id',$request->value)->where('associated_user_id',$request->id)->update(['is_delete' => 1]);

        } elseif ($request->type == 2) {
           
            $deleteMedicalStore = AssociatedUser::where('id',$request->id)->first();

            //Medical user
            $deleteMedicalStoreUser = StockiestUser::where('stockiest_id',$request->value)->where('associated_user_id',$request->id)->update(['is_delete' => 1]);    
            
        }
        
        return $deleteMedicalStoreUser ? 'true' : 'false';
    }

    // Delete associated user
    public function deleteAssociatedUser($id){

        $deleteMedicalStore = AssociatedUser::where('id',$id)->update(['is_delete' => 1,'medical_associate' => 0,'stockiest_associate' => 0]);

        //Medical user
        $deleteMedicalStoreUser = MedicalStoreUser::where('associated_user_id',$id)->update(['is_delete' => 1]);

        //Stockiest users
        $deleteStockiestUser = StockiestUser::where('associated_user_id',$id)->update(['is_delete' => 1]);


        return redirect(route('admin.associatedUserList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'User',
                'message' => 'User Successfully Deleted',
            ],
        ]); 

    }
}

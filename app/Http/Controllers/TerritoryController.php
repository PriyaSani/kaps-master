<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\City;
use App\Model\User;
use App\Model\State;
use App\Model\Country;
use App\Model\MrDetail;
use App\Model\Stockiest;
use App\Model\Territory;
use App\Model\MrTerritory;
use App\Model\DoctorDetail;
use App\Model\MedicalStore;
use App\Model\SubTerritory;
use App\Model\UserTerritory;
use App\Model\DoctorTerritory;

class TerritoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('checkpermission');
    }

    // Territory list
    public function territoryList(){

        $get_territory = Territory::with(['get_state'])->where('is_delete',0)->orderBy('id','desc')->get();

        return view('terrirory.territory_list',compact('get_territory'));       
    }

    // Add territory
    public function addTerritory(){

        $get_state = State::get();

        return view('terrirory.add_territory',compact('get_state'));
    }

    // Save territory
    public function saveTerritory(Request $request){

        $terrirory_save = new Territory;
        $terrirory_save->territory_id = strtoupper($request->territory_id);
        $terrirory_save->state_id = $request->state_id;
        $terrirory_save->country_id = 100;
        $terrirory_save->save();

        if($request->btn_submit == 'save_and_update'){

            return redirect(route('admin.addTerritory'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Territory',
                    'message' => 'Territory Successfully Added',
                ],
            ]); 

        } else {

            return redirect(route('admin.territoryList'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Territory',
                    'message' => 'Territory Successfully Added',
                ],
            ]); 
        }
    }

    // Edit territory
    public function editTerritory($id){
        
        $get_territory_detail = Territory::where('id',$id)->first();

        $get_state = State::get();

        return view('terrirory.edit_territory',compact('get_territory_detail','get_state'));
    }

    // Update territory
    public function updateTerritory(Request $request){

        $terrirory_save = Territory::findOrFail($request->id);
        $terrirory_save->territory_id = strtoupper($request->territory_id);
        $terrirory_save->state_id = $request->state_id;
        $terrirory_save->country_id = 100;
        $terrirory_save->save();

        return redirect(route('admin.territoryList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Territory',
                'message' => 'Territory Successfully Updated',
            ],
        ]); 
    }

    // Delete territory
    public function deleteTerritory($id){

        $delete_territory = Territory::where('id',$id)->update(['is_delete' => 1]);

        return redirect(route('admin.territoryList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Territory',
                'message' => 'Territory Successfully Deleted',
            ],
        ]); 
    }

    // Change territory status
    public function changeTerritoryStatus(Request $request){

        $updateStatus = Territory::where('id',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';

    }

    // Link personal details 
    public function linkedPersonDetail(Request $request){

        $title = 'Linked Memebers';

        $sub_territory = SubTerritory::where('territory_id',$request->id)->pluck('id')->toArray();

        $id = $request->id;
        $get_mr = MrDetail::whereHas('get_territory', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('get_territory', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->get();

        $get_doctor = DoctorDetail::whereHas('get_territory', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('get_territory', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->get();

        $get_employee = User::whereHas('get_territory', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('get_territory', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->get();
        
        $get_stockiest = Stockiest::whereHas('stockiest_territories', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('stockiest_territories', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->get();
        
        $get_medical_store = MedicalStore::whereHas('mendical_store_territories', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('mendical_store_territories', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->get();

        return view('terrirory.linked_member',compact('title','get_mr','get_doctor','get_employee','get_stockiest','get_medical_store'));
    }

    // Check territory priority
    public function checkTerritoryPriority(Request $request){
        
        $query = Territory::query();
        if (isset($request->territory_id)) {
            $query->where('territory_id',$request->territory_id);
        }
        if (isset($request->state)) {
            $query->where('state_id',$request->state);
        }
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $query->where('is_delete',0);
        $get_territory = $query->first();
        
        return (!is_null($get_territory) ? 'false' : 'true');

    }

    //sub territory list
    public function subTerritoryList($id){

        $get_territory = Territory::where('id',$id)->first();

        $get_sub_territory = SubTerritory::where('territory_id',$id)->where('is_delete',0)->get();

        return view('terrirory.sub_territory.sub_territory_list',compact('get_sub_territory','get_territory','id'));
    }

    // Add sub territory
    public function addSubTerritory($id){

        return view('terrirory.sub_territory.add_sub_territory',compact('id'));
    }

    // Save sub territory
    public function saveSubTerritory(Request $request){

        $sub_terrirory_save = new SubTerritory;
        $sub_terrirory_save->sub_territory = strtoupper($request->sub_territory);
        $sub_terrirory_save->territory_id = $request->id;
        $sub_terrirory_save->save();

        if($request->btn_submit == 'save_and_add'){

            return redirect(route('admin.addSubTerritory',$request->id))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Sub Territory',
                    'message' => 'Sub Territory Successfully Added',
                ],
            ]); 

        } else {

            return redirect(route('admin.subTerritoryList',$request->id))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Sub Territory',
                    'message' => 'Sub Territory Successfully Added',
                ],
            ]); 
        }
    }

    // Edit sub territory
    public function editSubTerritory($id,$territory_id){
        
        $get_sub_territory = SubTerritory::where('id',$id)->first();

        return view('terrirory.sub_territory.edit_sub_territory',compact('get_sub_territory','territory_id'));
    }

    // Update sub territory
    public function updateSubTerritory(Request $request){

        $sub_terrirory_update = SubTerritory::findOrFail($request->id);
        $sub_terrirory_update->territory_id = strtoupper($request->territory_id);
        $sub_terrirory_update->sub_territory = $request->sub_territory;
        $sub_terrirory_update->save();

        return redirect(route('admin.subTerritoryList',$request->territory_id))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Sub Territory',
                'message' => 'Sub Territory Successfully Updated',
            ],
        ]); 
    }

    // Delete sub territory
    public function deleteSubTerritory($id,$territory_id){

        $delete_territory = SubTerritory::where('id',$id)->where('territory_id',$territory_id)->update(['is_delete' => 1]);

        return redirect(route('admin.subTerritoryList',$territory_id))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Sub Territory',
                'message' => 'Sub Territory Successfully Deleted',
            ],
        ]); 
    }

    // Change sub territory status
    public function changeSubTerritoryStatus(Request $request){

        $updateStatus = SubTerritory::where('id',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }

    // Check sub territory priority
    public function checkSubTerritoryPriority(Request $request){

        $query = SubTerritory::query();
        if (isset($request->territory_id)) {
            $query->where('territory_id',$request->territory_id);
        }
        if (isset($request->sub_territory)) {
            $query->where('sub_territory',$request->sub_territory);
        }
        if (isset($request->id)) {
            $query->where('id','!=',$request->id);
        }
        $query->where('is_delete',0);
        $get_sub_territory = $query->first();
        
        return (!is_null($get_sub_territory) ? 'false' : 'true');
    }
}

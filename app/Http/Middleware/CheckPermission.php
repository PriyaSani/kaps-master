<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Stockiest;
use App\Model\AllRequest;
use App\Model\UserModule;
use App\Model\DoctorDetail;
use App\Model\SalesHistory;
use App\Model\MedicalStore;
use App\Model\UserTerritory;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $checkPermission = UserModule::where('employee_id',Auth::guard()->user()->id)->with(['module'])->get();

        if(Auth::guard('web')->check() && Auth::guard()->user()->id == 1){

            $module = array(); 
            if(!is_null($checkPermission)){
                foreach($checkPermission as $pk => $pv){
                    $module[] = $pv->module->slug;
                }
            }
            
            $segment = request()->segment(1);
            if(in_array(request()->segment(1),$module) || ($segment == 'associated-user' && ((in_array('medical-store',$module) || (in_array('stockiest',$module)))))){
                
                return $next($request);

            } else {

                abort('403');

            }

        }else{
           
            //for medical store , doctor, stockiest, associated users, all request and sales history list
            $get_user_territory = UserTerritory::where('employee_id',Auth::guard()->user()->id)->where('territories_id','!=','')->pluck('territories_id')->toArray();

            $get_user_sub_territory = UserTerritory::where('employee_id',Auth::guard()->user()->id)->where('sub_territories','!=','')->pluck('sub_territories')->toArray();

            //medical store
            $get_store = MedicalStore::with(['mendical_store_territories' => function($q){ $q->with(['territory_name']); }])->where('is_delete',0)->whereHas('mendical_store_territories', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('mendical_store_territories', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->pluck('id')->toArray();

            //doctor
            $get_doctor = DoctorDetail::with(['get_territory' => function($q){ $q->with(['territory_name']); }])->where('is_delete',0)->whereHas('territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->pluck('id')->toArray();

            //stockiest
            $get_stockiest = Stockiest::with(['stockiest_user','stockiest_territories' =>  function($q){ $q->with(['territory_name']); }])->where('is_delete',0)->whereHas('stockiest_territories', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('stockiest_territories', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->pluck('id')->toArray();

            //sales
            $get_sales_data = SalesHistory::whereHas('get_mr_territory', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('get_mr_territory', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->pluck('id')->toArray();
            
            //all request
            $get_all_request = AllRequest::whereHas('main_territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territory_id', $get_user_territory); })->WhereHas('sub_territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territory_id',$get_user_sub_territory); })->pluck('id')->toArray();

            $module = array(); 
            $store = array(); 
            $stockiest = array(); 
            $get_sales_data = array(); 
            $get_all_request = array(); 
            if(!is_null($checkPermission)){
                foreach($checkPermission as $pk => $pv){
                    $module[] = $pv->module->slug;
                }
            }
            
            $segments = request()->segment(1);
            if(in_array(request()->segment(1),$module) || ($segments == 'associated-user' && ((in_array('medical-store',$module) || (in_array('stockiest',$module)))))){

                $segment = request()->segment(2);

                //medical store    
                if($segment == 'edit-store'){
                    if(in_array(request()->segment(3),$get_store)){
                        return $next($request);
                    }else{
                        abort('403');
                    }
                }

                //doctor
                if($segment == 'edit-doctor'){
                    if(in_array(request()->segment(3),$get_doctor)){
                        return $next($request);
                    }else{
                        abort('403');
                    }
                }
                
                //stockiest
                if($segment == 'edit-stockiest'){
                    if(in_array(request()->segment(3),$get_stockiest)){
                        return $next($request);
                    }else{
                        abort('403');
                    }
                }
                
                //sales
                if($segment == 'mr-history-report'){
                    if(in_array(request()->segment(3),$get_sales_data)){
                        return $next($request);
                    }else{
                        abort('403');
                    }
                }

                //all request
                if($segment == 'view-doctor-request'){
                    if(in_array(request()->segment(3),$get_all_request)){
                        return $next($request);
                    }else{
                        abort('403');
                    }
                }

                return $next($request);
            } else {
                
                abort('403');
            }
            

        }

    }
}

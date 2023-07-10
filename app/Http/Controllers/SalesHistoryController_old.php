<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Model\MrDetail;
use App\Model\Stockiest;
use App\Model\SalesHistory;
use App\Model\MedicalStore;
use App\Model\DoctorDetail;
use Illuminate\Http\Request;
use App\Model\DoctorProfile;
use App\Model\DoctorOffset;
use App\Model\AllRequest;
use App\Model\DoctorCommission;
use App\Model\StockiestStatement;
use App\Model\MrWiseStockiestData;
use App\Model\MedicalStoreDoctorData;
use App\Http\Controllers\GlobalController;
use App\Model\StockiestWiseMedicalStoreData;

class SalesHistoryController extends GlobalController
{
   	public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    //MR List
    public function salesHistoryList(Request $request){

        $mr_data = MrDetail::with(['get_territory' => function($q){ $q->with(['territory_name']); }])->where('is_delete',0)->get();
        
        //at 20th date
        $entry_date = date("Y-m");
        $entry_date = $entry_date.'-20';

        //get current date
        $current_date = date("Y-m-d");

        //current month sales data
        $get_current_sales_data = SalesHistory::where('sales_month',$current_date)->get();
       	
       	if($get_current_sales_data->isEmpty()){
       		
       		if($entry_date == $current_date){

	        	//entry of all mr at 20th
	        	if(!empty($mr_data)){
	        		foreach ($mr_data as $mk => $mv) {
	        			$save_sales_data = new SalesHistory;
	        			$save_sales_data->mr_id = $mv->id;
	        			$save_sales_data->sales_month = $current_date;
	        			$save_sales_data->save();
	        		}
	        	}
	        }	
       	}
        
       	//month array
       	$months = array("January","February","March","April","May","June","July","August","September","Octomber","November","December");

       	$get_year = SalesHistory::orderBy('id','DESC')->first();
       	
       	//first year
       	if(!empty($get_year)){
       		$first_year = date('Y',strtotime($get_year->sales_month));	
       		$last_year = $first_year + 5;
       		
       	}else{

       		$first_year = '';
       		$last_year = '';
       	}
       	
       	//get all mr
       	$mr_name = MrDetail::where('is_active',1)->where('is_delete',0)->get();

       	//sales data
       	// echo "<pre>";
       	// print_r($request->all());
       	// exit;

       	$filter = 0;
        $month = '';
        $year = '';
        $mr = '';
        $mr_id = '';
        $status = '';

        $query = SalesHistory::query();

        if(isset($request->month) && $request->month != ''){
        	
            $filter = 1;
            $month = $request->month;
            $query->whereMonth('sales_month', '=', $request->month);

        }

        if(isset($request->year) && $request->year != ''){

            $filter = 1;
            $year = $request->year;
            $query->whereYear('sales_month', '=', $request->year);

        }

        if(isset($request->mr) && $request->mr != ''){
            
            $filter = 1;
            $mr = $request->mr;
            $mr_id = $request->mr_id;
            $query->where('mr_id',$request->mr_id);

        }

        if(isset($request->status) && $request->status != ''){
            
            $filter = 1;
            $status = $request->status;
            $query->where('confirm_status',$request->status);

        }

        $query->with(['mr_detail','user_detail']);
        $get_sales_data = $query->get();

        return view('sales_history.mr_sales_history_list',compact('get_sales_data','months','first_year','last_year','mr_name','month','year','mr','mr_id','status','filter'));
    }

    public function salesStatusChange(Request $request){
    	
    	$updateStatus = SalesHistory::where('id',$request->id)->update(['confirm_status' => $request->staus,'confirm_by_id' => $request->confirm_id]);

        $time = strtotime($request->sales_month);
        $month = date("m",$time);
        $check_year = date('Y');
        $current_date = date("Y-m-d");

        //app side conformation
        $stockist_confirm = MrWiseStockiestData::where('mr_id',$request->mr_id)->whereMonth('sales_month',$month)->where('is_confirm_data',1)->first();

        if(($request->staus == 1) && (!empty($stockist_confirm))){

            $get_mr_territories = MrDetail::with(['get_territory'])->where('id',$request->mr_id)->first();

            //mr territories and sub territories
            $territories = array();
            $sub_territories = array();
            if(!empty($get_mr_territories['get_territory'])){
                
                foreach ($get_mr_territories['get_territory'] as $tk => $tv) {

                    $territories[] = $tv['territories_id'];
                    $sub_territories[] = $tv['sub_territories'];
                }
            }

            $all_doctor = DoctorDetail::with(['get_territory'])->where('is_delete',0)->get();

            //get stockiest depend on mr territories & sub territories
            $doctor_id = array();
            
            if(!empty($all_doctor)){
                foreach ($all_doctor as $dk => $dv) {
                    foreach ($dv['get_territory'] as $dk => $dv) {
                        if(in_array($dv['territories_id'],$territories) && in_array($dv['sub_territories'],$sub_territories)){
                            $doctor_id[] = $dv->doctor_id;

                        }
                    }
                }
            }

            $doctor_profile = DoctorProfile::whereIn('doctor_id',$doctor_id)->where('is_delete',0)->pluck('id');

            $get_doctor_offset = DoctorOffset::whereIn('profile_id',$doctor_profile)->whereIn('doctor_id',$doctor_id)->whereMonth('carry_forward_date',$month)->orderBy('id','DESC')->with(['commission'])->get();
            
            if((!$get_doctor_offset->isEmpty())){
                
                foreach ($get_doctor_offset as $gk => $gv) {

                    $get_sales = MedicalStoreDoctorData::where('doctor_id',$gv->doctor_id)->where('doctor_profile',$gv->profile_id)->whereMonth('sales_month',$month)->sum('sales_amount');

                    //net sales 
                    $net_sales = $gv->carry_forward + $get_sales;

                    //eligibility        
                    $eligibility = $net_sales * $gv['commission']['commission']/100;

                    $get_request_amount = AllRequest::where('profile_id',$gv->profile_id)->where('doctor_id',$gv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->sum('request_amount');

                    //next target
                    $target = $get_request_amount * $gv['commission']['commission'];

                    $update_amount = AllRequest::where('profile_id',$gv->profile_id)->where('doctor_id',$gv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->update(['is_considered_by_sales' => 1]);

                    //new eligibility
                    $new_eligibility = $eligibility - $get_request_amount;

                    $carry_forward = $new_eligibility * $gv['commission']['commission'];


                    $save_offset = DoctorOffset::findOrFail($gv->id);
                    $save_offset->last_month_sales = $gv->last_month_sales;

                    //set carry forward and eligibility date
                    $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

                    $save_offset->last_month_date = $previous_month_date;
                    $save_offset->previous_second_month_sales = $gv->previous_second_month_sales;

                    //set previous and second month date
                    $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
                    $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

                    $save_offset->previous_second_month_date = $previous_second_month_date;
                    $save_offset->previous_third_month_sales = $gv->previous_third_month_sales;
                    $save_offset->previous_third_month_date = $previous_third_month_date;
                    $save_offset->target_previous_month = $target;
                    $save_offset->target_previous_month_date = $current_date;
                    $save_offset->carry_forward = $carry_forward;
                    $save_offset->carry_forward_date = $current_date;
                    $save_offset->eligible_amount = $new_eligibility;
                    $save_offset->eligible_amount_date = $current_date;
                    $save_offset->profile_id = $gv->profile_id;
                    $save_offset->doctor_id = $gv->doctor_id;
                    $save_offset->save();

                }

            }

            //which is not in doctor offset
            $other_profile_id = DoctorOffset::whereMonth('carry_forward_date',$month)->orderBy('id','DESC')->pluck('profile_id');

            $doctor_profile = DoctorProfile::with(['doctor_commission'])->whereNotIn('id',$other_profile_id)->whereIn('doctor_id',$doctor_id)->where('is_delete',0)->get();

            if(!empty($doctor_profile)){

                foreach ($doctor_profile as $pk => $pv) {

                    if(!empty($pv['doctor_commission'])){
                        $get_sales = MedicalStoreDoctorData::where('doctor_id',$pv->doctor_id)->where('doctor_profile',$pv->id)->whereMonth('sales_month',$month)->sum('sales_amount');

                        //net sales 
                        $net_sales = $get_sales;
                        
                        //eligibility        
                        $eligibility = $net_sales * $pv['doctor_commission']['commission']/100;

                        $get_request_amount = AllRequest::where('profile_id',$pv->id)->where('doctor_id',$pv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->sum('request_amount');

                         //next target
                        $target = $get_request_amount * $pv['doctor_commission']['commission'];

                        $update_amount = AllRequest::where('profile_id',$pv->id)->where('doctor_id',$pv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->update(['is_considered_by_sales' => 1]);

                        //new eligibility
                        $new_eligibility = $eligibility - $get_request_amount;

                        $carry_forward = $new_eligibility * $pv['doctor_commission']['commission'];

                        $save_offset = new DoctorOffset;
                        $save_offset->last_month_sales = 0;

                        //set carry forward and eligibility date
                        $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

                        $save_offset->last_month_date = $previous_month_date;
                        $save_offset->previous_second_month_sales = 0;

                        //set previous and second month date
                        $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
                        $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

                        $save_offset->previous_second_month_date = $previous_second_month_date;
                        $save_offset->previous_third_month_sales = 0;
                        $save_offset->previous_third_month_date = $previous_third_month_date;
                        $save_offset->target_previous_month = $target;
                        $save_offset->target_previous_month_date = $current_date;
                        $save_offset->carry_forward = $carry_forward;
                        $save_offset->carry_forward_date = $current_date;
                        $save_offset->eligible_amount = $new_eligibility;
                        $save_offset->eligible_amount_date = $current_date;
                        $save_offset->profile_id = $pv->id;
                        $save_offset->doctor_id = $pv->doctor_id;
                        $save_offset->save();

                    }

                }

            }
        }
        

        return $updateStatus ? 'true' : 'false';
    }

    public function mrHistoryReportList($id){

    	//get mr territories
    	$get_mr_territories = SalesHistory::with(['mr_detail' => function($q){ $q->with(['get_territory']); } ,'user_detail'])->where('id',$id)->first();


    	//mr territories and sub territories
    	$territories = array();
    	$sub_territories = array();
    	if(!empty($get_mr_territories['mr_detail']['get_territory'])){
    		
    		foreach ($get_mr_territories['mr_detail']['get_territory'] as $tk => $tv) {

    			$territories[] = $tv['territories_id'];
    			$sub_territories[] = $tv['sub_territories'];
    		}
    	}
    	
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

    	$territorist_stockiest = Stockiest::whereIn('id',$stockies_id)->with(['stockiest_user','stockiest_territories'])->where('is_delete',0)->get();
     
    	$check_data = MrWiseStockiestData::where('mr_id',$id)->where('sales_month',$get_mr_territories->sales_month)->first();

    	//save stockiest data
    	if(empty($check_data)){
	    	if(!empty($territorist_stockiest)){

	    		foreach ($territorist_stockiest as $sk => $sv) {
	    			$save_stockiest = new MrWiseStockiestData;
	    			$save_stockiest->stockiest_id = $sv->id;
	    			$save_stockiest->mr_id = $id;
	    			$save_stockiest->sales_month = $get_mr_territories->sales_month;
	    			$save_stockiest->priority = 0;
	    			$save_stockiest->save();
	    		}
	    	}
    	}

    	$get_stockiest_data = MrWiseStockiestData::where('mr_id',$id)->with(['stockiest_detail','mr_detail'])->where('is_delete',0)->orderBy('priority','DESC')->get();

    	return view('sales_history.stockiest_sales.monthly_sales_history',compact('get_mr_territories','get_stockiest_data'));	
    }


    public function saveStockiestAmount(Request $request){

    	//update amount of stockiest
    	if($request->amount == ''){
    		$priority = 0;
    	}else{
    		$priority = 1;
    	}
    	$updateAmount = MrWiseStockiestData::where('id',$request->id)->update(['amount' => $request->amount,'priority' => $priority]);

        return $updateAmount ? 'true' : 'false';

    }

    //clear data of stockiest
    public function deleteStockiestData($id,$mr_id){
		
		$updateAmount = MrWiseStockiestData::where('id',$id)->update(['amount' => NULL,'submitted_on' => NULL,'priority' => 0]);

        //remove attachment
		$updateAttachment = StockiestStatement::where('data_id',$id)->delete();

        //remove store data
        $updateAttachment = StockiestWiseMedicalStoreData::where('stockiest_id',$id)->delete();

        //remove doctor data
        $updateAttachment = MedicalStoreDoctorData::where('stockiest_id',$id)->delete();

        
		return redirect(route('admin.mrHistoryReportList',$mr_id))->with('messages', [
              [
                  'type' => 'success',
                  'title' => 'Entry',
                  'message' => 'Entry Successfully Cleared',
              ],
        ]);     	
    }

    //statement of stockiest
    public function stockiestStatement(Request $request){

    	$get_statement = MrWiseStockiestData::with(['stockiest_detail'])->where('id',$request->id)->where('is_delete',0)->first();

    	$get_attachment = StockiestStatement::where('data_id',$request->id)->where('is_delete',0)->get();
    	
    	return view('sales_history.stockiest_sales.stockiest_statement',compact('get_statement','get_attachment'));
    }

    //stockiest attchment
    public function stockiestAttachment(Request $request){

    	if(isset($request->statement)){
    		
    		foreach ($request->statement as $sk => $sv) {
    			
    			$save_statement = new StockiestStatement;
	    		$save_statement->data_id = $request->id;
	    		$statement = $this->uploadImage($sv,'statement');
            	$save_statement->statement = $statement;  
	    		$save_statement->save();

    		}
    	}

    	return redirect(route('admin.mrHistoryReportList',$request->mr_id))->with('messages', [
              [
                  'type' => 'success',
                  'title' => 'Attachment',
                  'message' => 'Attachment Successfully Added',
              ],
        ]); 
    }

    //remove statement
    public function removeAttachment(Request $request){

    	$removeStatement = StockiestStatement::where('id',$request->id)->update(['is_delete' => 1]);

        return $removeStatement ? 'true' : 'false';
    }

    //download all statements
    public function downloadStatementZip($id){

    	$getfiles = StockiestStatement::where('data_id',$id)->where('is_delete',0)->get();
		
		$get_stockiest_data = MrWiseStockiestData::with(['stockiest_detail','mr_detail'])->where('id',$id)->first();    	
        
        $file_name = date('F_Y',strtotime($get_stockiest_data->sales_month)).'_'.$get_stockiest_data['mr_detail']['full_name'];

        if(!empty($getfiles)){


	        $zip = new ZipArchive;
	   
	        $public_dir = public_path().'/uploads/zip';

	        $zipFileName = $file_name.'.zip';

	        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE){
	        	
	            foreach($getfiles as $gk => $gv){
	            	
	                $statementFile = public_path()."/uploads/statement/".$gv->statement;

	                $zip->addFile($statementFile, $gv->statement);
	            }

	           $zip->close();
	        }

	        $filetopath = $public_dir.'/'.$zipFileName;
	        
	        return response()->download($filetopath);
	   	}
    }

    public function medicalstoreHistoryReportList($id,$mr_id){

    	//get mr territories
    	$get_mr_territories = SalesHistory::with(['mr_detail' => function($q){ $q->with(['get_territory']); } ,'user_detail'])->where('id',$mr_id)->first();

        
    	//mr territories and sub territories
    	$territories = array();
    	$sub_territories = array();
    	if(!empty($get_mr_territories['mr_detail']['get_territory'])){
    		
    		foreach ($get_mr_territories['mr_detail']['get_territory'] as $tk => $tv) {

    			$territories[] = $tv['territories_id'];
    			$sub_territories[] = $tv['sub_territories'];

    		}
    	}
		
		$get_medical_store = MedicalStore::with(['mendical_store_territories'])->where('is_delete',0)->get();
    	
    	//get stockiest depend on mr territories
    	$store_id = array();
    	if(!empty($get_medical_store)){
    		foreach ($get_medical_store as $sk => $sv) {
    			foreach ($sv['mendical_store_territories'] as $tk => $tv) {
    				if(in_array($tv['territories_id'],$territories) && in_array($tv['sub_territories'],$sub_territories)){
    					$store_id[] = $sv->id;
    				}
    			}
    		}
    	}

    	$territorist_medical_store = MedicalStore::whereIn('id',$store_id)->with(['medical_store_user','mendical_store_territories'])->where('is_delete',0)->get();

    	$check_data = StockiestWiseMedicalStoreData::where('stockiest_id',$id)->where('sales_month',$get_mr_territories->sales_month)->first();

    	//save stockiest data
    	if(empty($check_data)){
	    	if(!empty($territorist_medical_store)){

	    		foreach($territorist_medical_store as $sk => $sv) {
	    			$save_stockiest = new StockiestWiseMedicalStoreData;
	    			$save_stockiest->medical_store_id = $sv->id;
	    			$save_stockiest->stockiest_id = $id;
	    			$save_stockiest->mr_id = $mr_id;
	    			$save_stockiest->sales_month = $get_mr_territories->sales_month;
	    			$save_stockiest->priority = 0;
	    			$save_stockiest->save();
	    		}
	    	}
    	}

    	$get_medical_store_data = StockiestWiseMedicalStoreData::with(['stockiest_detail','mr_detail','store_detail'])->where('is_delete',0)->where('stockiest_id',$id)->orderBy('priority','DESC')->get();

        $get_stockiest_detail = MrWiseStockiestData::with(['stockiest_detail','mr_detail' => function($q){ $q->with(['mr_detail']); } ])->where('id',$id)->first();

    	return view('sales_history.stockiest_sales.medical_store.medical_store_report',compact('get_medical_store_data','get_stockiest_detail'));
    }

    //update all amount
    public function saveMedicalStoreAmount(Request $request){

        $get_stockist_data = MrWiseStockiestData::where('id',$request->store_id)->first();


        $query = StockiestWiseMedicalStoreData::where('stockiest_id',$request->store_id);

        //store sales amount
        $store_sales_amount = $query->sum( 'sales_amount' );

        //extra business
        $extra_business = $query->sum( 'extra_business' );

        //scheme business
        $scheme_business = $query->sum( 'scheme_business' );

        //ethical business
        $ethical_business = $query->sum( 'ethical_business' );

        //check same value
        $check_same_value = $query->where('id',$request->id)->first();  
        if(isset($request->type) && ($request->type == 1)){
            $amount = $check_same_value->sales_amount;
        }

        if(isset($request->type) && ($request->type == 2)){
            $amount = $check_same_value->extra_business;
        }

        if(isset($request->type)  && ($request->type == 3)){            
            $amount = $check_same_value->scheme_business;      
        }

        //ethical business
        if(isset($request->type) && ($request->type == 4)){
            $amount = $check_same_value->ethical_business;      
        }

        //store total amount
        $store_total_amount = $store_sales_amount + $extra_business + $scheme_business + $ethical_business;

        if(empty($check_same_value)){
            $add_new_amount = $store_total_amount + $request->amount;

        }else{
            $add_new_amount = $store_total_amount - $amount + $request->amount;
        }
        
        if($add_new_amount > $get_stockist_data->amount){
            
            return 'false';

        }else{

            //sales amount
            if(isset($request->type) && ($request->type == 1)){

                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['sales_amount' => $request->amount]);

            }

            //extra business
            if(isset($request->type) && ($request->type == 2)){

                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['extra_business' => $request->amount]);

            }

            //scheme business
            if(isset($request->type)  && ($request->type == 3)){
                
                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['scheme_business' => $request->amount]);

            }

            //ethical business
            if(isset($request->type) && ($request->type == 4)){
                
                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['ethical_business' => $request->amount]);

            }

            //check priority
            $updatePriority = StockiestWiseMedicalStoreData::where('id',$request->id)->whereNull('sales_amount')->whereNull('extra_business')->whereNull('scheme_business')->whereNull('ethical_business')->first();

            //update priority
            if(!empty($updatePriority)){
                $updatePriority = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['priority' => 0]);            
            }else{
                $updatePriority = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['priority' => 1]);            
            }
        }
        

        return $updateAmount ? 'true' : 'false';
    }

    public function deleteMedicalStoreData($id,$stockiest_id,$mr_id){

        $updateEntry = StockiestWiseMedicalStoreData::where('id',$id)->update(['sales_amount' => NULL,'extra_business' => NULL,'scheme_business' => NULL,'ethical_business' => NULL,'submitted_on' => NULL,'priority' => 0]);

        //remove doctor data
        $updateAttachment = MedicalStoreDoctorData::where('medical_store_id',$id)->delete();

        return redirect(route('admin.medicalstoreHistoryReportList',[$stockiest_id,$mr_id]))->with('messages', [
              [
                  'type' => 'success',
                  'title' => 'Entry',
                  'message' => 'Entry Successfully Cleared',
              ],
        ]);            
    }

    public function medicalstoreDoctorSalesReport($id,$stockiest_id,$mr_id){

        //get mr territories
        $get_mr_territories = SalesHistory::with(['mr_detail' => function($q){ $q->with(['get_territory']); } ,'user_detail'])->where('id',$mr_id)->first();

        //mr territories and sub territories
        $territories = array();
        $sub_territories = array();
        if(!empty($get_mr_territories['mr_detail']['get_territory'])){
            
            foreach ($get_mr_territories['mr_detail']['get_territory'] as $tk => $tv) {

                $territories[] = $tv['territories_id'];
                $sub_territories[] = $tv['sub_territories'];

            }
        }

        $get_doctor = DoctorDetail::with(['get_territory'])->where('is_delete',0)->get();
        
        //get doctor depend on mr territories
        $doctor_id = array();
        if(!empty($get_doctor)){
            foreach ($get_doctor as $sk => $sv) {
                foreach ($sv['get_territory'] as $tk => $tv) {
                    if(in_array($tv['territories_id'],$territories) && in_array($tv['sub_territories'],$sub_territories)){
                        $doctor_id[] = $sv->id;
                    }
                }
            }
        }

        $territorist_doctor_detail = DoctorProfile::whereIn('doctor_id',$doctor_id)->where('is_delete',0)->get();

        $check_data = MedicalStoreDoctorData::where('medical_store_id',$id)->where('sales_month',$get_mr_territories->sales_month)->first();

        //save stockiest data
        if(empty($check_data)){
            if(!empty($territorist_doctor_detail)){

                foreach($territorist_doctor_detail as $sk => $sv) {
                    $save_doctor_detail = new MedicalStoreDoctorData;
                    $save_doctor_detail->doctor_profile = $sv->id;
                    $save_doctor_detail->doctor_id = $sv->doctor_id;
                    $save_doctor_detail->medical_store_id = $id;
                    $save_doctor_detail->stockiest_id = $stockiest_id;
                    $save_doctor_detail->mr_id = $mr_id;
                    $save_doctor_detail->sales_month = $get_mr_territories->sales_month;
                    $save_doctor_detail->priority = 0;
                    $save_doctor_detail->save();
                }
            }
        }

        $get_medical_store_data = MedicalStoreDoctorData::where('medical_store_id',$id)->with(['doctor_detail','stockiest_detail','mr_detail','store_detail','profile_detail'])->where('is_delete',0)->orderBy('priority','DESC')->get();

        $get_stockiest_detail = StockiestWiseMedicalStoreData::with(['store_detail','stockiest_detail' => function($q){ $q->with(['stockiest_detail']); },'mr_detail' => function($q){ $q->with(['mr_detail']); }])->where('id',$id)->first();

        return view('sales_history.stockiest_sales.medical_store.doctor_data.doctor_report',compact('get_medical_store_data','get_stockiest_detail'));        
    }

    public function saveDoctorAmount(Request $request){

        $get_stockist_data = StockiestWiseMedicalStoreData::where('id',$request->store)->first();

        $query = MedicalStoreDoctorData::where('medical_store_id',$request->store);

        //store sales amount
        $store_sales_amount = $query->sum( 'sales_amount' );

        $check_same_value = $query->where('id',$request->id)->first();   

        $total_amount = $get_stockist_data->sales_amount + $get_stockist_data->extra_business + $get_stockist_data->scheme_business + $get_stockist_data->ethical_business;


        (empty($check_same_value) ? $add_new_amount = $store_sales_amount + $request->amount : $add_new_amount = $store_sales_amount - $check_same_value->sales_amount + $request->amount); 

        /*if(empty($check_same_value)){
            $add_new_amount = $store_sales_amount + $request->amount;

        }else{
            $add_new_amount = $store_sales_amount - $check_same_value->sales_amount + $request->amount;
        }*/


        if($add_new_amount > $total_amount){
            
            return 'false';

        }else{   

            if($request->amount != ''){
                $priority = 1;
            }else{
                $priority = 0;
            }
                    
            $updateAmount = MedicalStoreDoctorData::where('id',$request->id)->update(['sales_amount' => $request->amount,'priority' => $priority]);

            return $updateAmount ? 'true' : 'false';
        }

    }

    public function deleteDoctorData($id,$store_id,$stockiest_id,$mr_id){

        $updateEntry = MedicalStoreDoctorData::where('id',$id)->update(['sales_amount' => NULL,'priority' => 0]);

        return redirect(route('admin.medicalstoreDoctorSalesReport',[$store_id,$stockiest_id,$mr_id]))->with('messages', [
              [
                  'type' => 'success',
                  'title' => 'Entry',
                  'message' => 'Entry Successfully Cleared',
              ],
        ]);

    }
}

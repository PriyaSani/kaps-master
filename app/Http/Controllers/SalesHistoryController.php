<?php

namespace App\Http\Controllers;

use Auth;
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
use App\Model\MrTerritory;
use App\Model\StockiestTerritory;
use App\Model\MedicalStoreTerritory;
use App\Model\DoctorTerritory;
use App\Model\DoctorDetails;

class SalesHistoryController extends GlobalController
{
    public function __construct(){
       $this->middleware('auth');
       $this->middleware('checkpermission');
    }

    // MR wise sales history List
    public function salesHistoryList(Request $request){

        // At 25th date
        $entry_date = date("Y-m").'-25';
        // Get current date
        $current_date = date("Y-m-d");

        $mrData = MrDetail::with(['get_territory' => function($q){ $q->with(['territory_name']); }])->where('is_delete',0)->get();

        // Current month sales data
        $get_current_sales_data = SalesHistory::where('sales_month',$current_date)->get();

        if($get_current_sales_data->isEmpty()){

            if($entry_date == $current_date){

                if(!is_null($mrData)){
                    foreach($mrData as $mk => $mv){

                        $save_sales_data = new SalesHistory;
                        $save_sales_data->mr_id = $mv->id;
                        $save_sales_data->sales_month = $current_date;
                        $save_sales_data->save();

                    }
                }
            }
        }

        // Month array
        $months = array("January","February","March","April","May","June","July","August","September","Octomber","November","December");

        $get_year = SalesHistory::orderBy('id','DESC')->first();

        // First year
        if(!empty($get_year)){
            $first_year = date('Y',strtotime($get_year->sales_month));
            $last_year = $first_year + 5;

        } else {

            $first_year = '';
            $last_year = '';
        }

        // Get all mr data
        $mr_name = MrDetail::where('is_active',1)->where('is_delete',0)->get();

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
        $get_sales_data = $query->orderBy('sales_month','DESC')->get();
        if(Auth::guard()->user()->id != 1){
            $get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
            $get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));

            $get_sales_data = $query->with(['get_mr_territory'])->orderBy('sales_month','DESC')->whereHas('get_mr_territory', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('get_mr_territory', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->get();
        }

        return view('sales_history.mr_sales_history_list',compact('get_sales_data','months','first_year','last_year','mr_name','month','year','mr','mr_id','status','filter'));
    }

    // Sales status change
    public function salesStatusChange(Request $request){

        if($request->staus == 0){
            $updateStatus = SalesHistory::where('id',$request->id)->update(['confirm_status' => $request->staus,'confirm_by_id' => NULL]);
        } else {
            $updateStatus = SalesHistory::where('id',$request->id)->update(['confirm_status' => $request->staus,'confirm_by_id' => $request->confirm_id]);
        }

        // $time = strtotime($request->sales_month);
        // $month = date("m",$time);
        // $check_year = date('Y');
        // $current_date = date("Y-m-d");

        // //app side conformation
        // $stockist_confirm = SalesHistory::where('mr_id',$request->mr_id)->whereMonth('sales_month',$month)->where('is_submited',1)->first();

        // if(($request->staus == 1) && (!empty($stockist_confirm))){

        //     $get_mr_territories = MrDetail::with(['get_territory'])->where('id',$request->mr_id)->first();

        //     //mr territories and sub territories
        //     $territories = array();
        //     $sub_territories = array();
        //     if(!empty($get_mr_territories['get_territory'])){

        //         foreach ($get_mr_territories['get_territory'] as $tk => $tv) {

        //             $territories[] = $tv['territories_id'];
        //             $sub_territories[] = $tv['sub_territories'];
        //         }
        //     }

        //     $all_doctor = DoctorDetail::with(['get_territory'])->where('is_delete',0)->get();

        //     //get stockiest depend on mr territories & sub territories
        //     $doctor_id = array();

        //     if(!empty($all_doctor)){
        //         foreach ($all_doctor as $dk => $dv) {
        //             foreach ($dv['get_territory'] as $dk => $dv) {
        //                 if(in_array($dv['territories_id'],$territories) && in_array($dv['sub_territories'],$sub_territories)){
        //                     $doctor_id[] = $dv->doctor_id;

        //                 }
        //             }
        //         }
        //     }

        //     $doctor_profile = DoctorProfile::whereIn('doctor_id',$doctor_id)->where('is_delete',0)->pluck('id');

        //     $get_doctor_offset = DoctorOffset::whereIn('profile_id',$doctor_profile)->whereIn('doctor_id',$doctor_id)->whereMonth('carry_forward_date',$month)->orderBy('id','DESC')->with(['commission'])->get();

        //     if((!$get_doctor_offset->isEmpty())){

        //         foreach ($get_doctor_offset as $gk => $gv) {

        //             $get_sales = MedicalStoreDoctorData::where('doctor_id',$gv->doctor_id)->where('doctor_profile',$gv->profile_id)->whereMonth('sales_month',$month)->sum('sales_amount');

        //             //net sales
        //             $net_sales = $gv->carry_forward + $get_sales;

        //             //eligibility
        //             $eligibility = $net_sales * $gv['commission']['commission']/100;

        //             $get_request_amount = AllRequest::where('profile_id',$gv->profile_id)->where('doctor_id',$gv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->sum('request_amount');

        //             //next target
        //             $target = $get_request_amount * $gv['commission']['commission'];

        //             $update_amount = AllRequest::where('profile_id',$gv->profile_id)->where('doctor_id',$gv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->update(['is_considered_by_sales' => 1]);

        //             //new eligibility
        //             $new_eligibility = $eligibility - $get_request_amount;

        //             $carry_forward = $new_eligibility * $gv['commission']['commission'];

        //             $save_offset = DoctorOffset::findOrFail($gv->id);
        //             $save_offset->last_month_sales = $gv->last_month_sales;

        //             //set carry forward and eligibility date
        //             $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

        //             $save_offset->last_month_date = $previous_month_date;
        //             $save_offset->previous_second_month_sales = $gv->previous_second_month_sales;

        //             //set previous and second month date
        //             $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
        //             $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

        //             $save_offset->previous_second_month_date = $previous_second_month_date;
        //             $save_offset->previous_third_month_sales = $gv->previous_third_month_sales;
        //             $save_offset->previous_third_month_date = $previous_third_month_date;
        //             $save_offset->target_previous_month = $target;
        //             $save_offset->target_previous_month_date = $current_date;
        //             $save_offset->carry_forward = $carry_forward;
        //             $save_offset->carry_forward_date = $current_date;
        //             $save_offset->eligible_amount = $new_eligibility;
        //             $save_offset->eligible_amount_date = $current_date;
        //             $save_offset->profile_id = $gv->profile_id;
        //             $save_offset->doctor_id = $gv->doctor_id;
        //             $save_offset->save();

        //         }

        //     }

        //     //which is not in doctor offset
        //     $other_profile_id = DoctorOffset::whereMonth('carry_forward_date',$month)->orderBy('id','DESC')->pluck('profile_id');

        //     $doctor_profile = DoctorProfile::with(['doctor_commission'])->whereNotIn('id',$other_profile_id)->whereIn('doctor_id',$doctor_id)->where('is_delete',0)->get();

        //     if(!empty($doctor_profile)){

        //         foreach ($doctor_profile as $pk => $pv) {

        //             if(!empty($pv['doctor_commission'])){
        //                 $get_sales = MedicalStoreDoctorData::where('doctor_id',$pv->doctor_id)->where('doctor_profile',$pv->id)->whereMonth('sales_month',$month)->sum('sales_amount');

        //                 //net sales
        //                 $net_sales = $get_sales;

        //                 //eligibility
        //                 $eligibility = $net_sales * $pv['doctor_commission']['commission']/100;

        //                 $get_request_amount = AllRequest::where('profile_id',$pv->id)->where('doctor_id',$pv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->sum('request_amount');

        //                  //next target
        //                 $target = $get_request_amount * $pv['doctor_commission']['commission'];

        //                 $update_amount = AllRequest::where('profile_id',$pv->id)->where('doctor_id',$pv->doctor_id)->whereYear('request_date',$check_year)->whereMonth('request_date',$month)->where('is_considered_by_sales',0)->where('status',2)->update(['is_considered_by_sales' => 1]);

        //                 //new eligibility
        //                 $new_eligibility = $eligibility - $get_request_amount;

        //                 $carry_forward = $new_eligibility * $pv['doctor_commission']['commission'];

        //                 $save_offset = new DoctorOffset;
        //                 $save_offset->last_month_sales = 0;

        //                 //set carry forward and eligibility date
        //                 $previous_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

        //                 $save_offset->last_month_date = $previous_month_date;
        //                 $save_offset->previous_second_month_sales = 0;

        //                 //set previous and second month date
        //                 $previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
        //                 $previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));

        //                 $save_offset->previous_second_month_date = $previous_second_month_date;
        //                 $save_offset->previous_third_month_sales = 0;
        //                 $save_offset->previous_third_month_date = $previous_third_month_date;
        //                 $save_offset->target_previous_month = $target;
        //                 $save_offset->target_previous_month_date = $current_date;
        //                 $save_offset->carry_forward = $carry_forward;
        //                 $save_offset->carry_forward_date = $current_date;
        //                 $save_offset->eligible_amount = $new_eligibility;
        //                 $save_offset->eligible_amount_date = $current_date;
        //                 $save_offset->profile_id = $pv->id;
        //                 $save_offset->doctor_id = $pv->doctor_id;
        //                 $save_offset->save();

        //             }

        //         }

        //     }
        // }

        return $updateStatus ? 'true' : 'false';
    }

    // Mr wise history report list
    public function mrHistoryReportList($id){

        //Get mr territories
        $get_mr_territories = SalesHistory::with(['mr_detail' => function($q){ $q->with(['get_territory']); } ,'user_detail'])->where('id',$id)->first();

        // Mr territories & sub territories
        $mrTerritories = array();
        $mrSubTerritories = array();
        if(!empty($get_mr_territories['mr_detail']['get_territory'])){
            foreach ($get_mr_territories['mr_detail']['get_territory'] as $tk => $tv) {
                $mrTerritories[] = $tv['territories_id'];
                $mrSubTerritories[] = $tv['sub_territories'];
            }
        }

        // Get Stockiest territories & sub territories
        $stockiestID = StockiestTerritory::whereIn('territories_id', array_unique($mrTerritories))
                                            ->whereIn('sub_territories',array_unique($mrSubTerritories))
                                            ->groupBy('stockiest_id')
                                            ->pluck('stockiest_id')
                                            ->toArray();

        // Territories & sub territories wise stockiest name
        $territorist_stockiest = Stockiest::whereIn('id',$stockiestID)->with(['stockiest_user','stockiest_territories'])->where('is_delete',0)->get();


        // Mr wise stockiest data check
        $check_data = MrWiseStockiestData::where('sales_id',$id)->where('sales_month',$get_mr_territories->sales_month)->first();

        // Save stockiest data
        if(!is_null($territorist_stockiest)){
            foreach ($territorist_stockiest as $sk => $sv) {
                $data = MrWiseStockiestData::where('sales_id', $id)->where('stockiest_id',$sv->id)->where('sales_month', $get_mr_territories->sales_month)->first();
                if (is_null($data)) {
                    $save_stockiest = new MrWiseStockiestData;
                    $save_stockiest->stockiest_id = $sv->id;
                    $save_stockiest->sales_id = $id;
                    $save_stockiest->mr_id = $get_mr_territories->mr_id;
                    $save_stockiest->sales_month = $get_mr_territories->sales_month;
                    $save_stockiest->priority = 0;
                    $save_stockiest->save();
                }

            }
        }

        $get_stockiest_data = MrWiseStockiestData::where('sales_id',$id)->where('is_delete',0)->with(['stockiest_detail','mr_detail'])->orderBy('priority','DESC')->get();

        return view('sales_history.stockiest_sales.monthly_sales_history',compact('get_mr_territories','get_stockiest_data'));
    }

    // Save stockiest amount 
    public function saveStockiestAmount(Request $request){

        // Update amount of stockiest
        if($request->amount == ''){
            $priority = 0;
        } else {
            $priority = 1;
        }
        $updateAmount = MrWiseStockiestData::where('id',$request->id)->update(['amount' => $request->amount,'priority' => $priority]);

        return $updateAmount ? 'true' : 'false';

    }

    // Delete stockiest data from database
    public function deleteStockiestData($id,$mr_id){

        $updateAmount = MrWiseStockiestData::where('id',$id)->update(['amount' => NULL,'submitted_on' => NULL,'priority' => 0]);

        // Remove attachment
        $updateAttachment = StockiestStatement::where('data_id',$id)->delete();

        // Remove store data
        $updateAttachment = StockiestWiseMedicalStoreData::where('stockiest_id',$id)->delete();

        // Remove doctor data
        $updateAttachment = MedicalStoreDoctorData::where('stockiest_id',$id)->delete();

        return redirect(route('admin.mrHistoryReportList',$mr_id))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Entry',
                'message' => 'Entry Successfully Cleared',
            ],
        ]);
    }

    // Statement of stockiest
    public function stockiestStatement(Request $request){

        $get_statement = MrWiseStockiestData::with(['stockiest_detail'])->where('id',$request->id)->where('is_delete',0)->first();

        $get_attachment = StockiestStatement::where('data_id',$request->id)->where('is_delete',0)->get();

        return view('sales_history.stockiest_sales.stockiest_statement',compact('get_statement','get_attachment'));
    }

    // Stockiest attchment
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

        return redirect(route('admin.mrHistoryReportList',$request->sales_id))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Attachment',
                'message' => 'Attachment Successfully Added',
            ],
        ]);
    }

    // Remove attachment statement
    public function removeAttachment(Request $request){

        $removeStatement = StockiestStatement::where('id',$request->id)->update(['is_delete' => 1]);

        return $removeStatement ? 'true' : 'false';
    }

    // Download all statements zip
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

    // Medical store history report list
    public function medicalstoreHistoryReportList($id,$mr_id){

        // Get mr territories
        $get_mr_territories = SalesHistory::with(['mr_detail' => function($q){ $q->with(['get_territory']); } ,'user_detail'])->where('id',$mr_id)->first();

        // Mr territories and sub territories
        $mrTerritories = array();
        $mrSubTerritories = array();

        if(!is_null($get_mr_territories->mr_detail->get_territory)){
            foreach($get_mr_territories->mr_detail->get_territory as $sk => $sv){
                
                if(!in_array($sv->territories_id,$mrTerritories)){
                    $mrTerritories[] = $sv['territories_id'];
                }

                if(!in_array($sv->sub_territories,$mrSubTerritories)){
                    $mrSubTerritories[] = $sv['sub_territories'];
                }
            }
        }  

        // Get stockiest data
        $stockiestTerritory = array();
        $stockiestSubTerritory = array();

        $getStokist = StockiestTerritory::whereIn('territories_id',$mrTerritories)
                                        ->whereIn('sub_territories',$mrSubTerritories)
                                        ->select('territories_id','sub_territories')
                                        ->get();

        if(!is_null($getStokist)){
            foreach($getStokist as $sk => $sv){
                
                if(!in_array($sv['territories_id'],$stockiestTerritory)){
                    $stockiestTerritory[] = $sv['territories_id'];
                }

                if(!in_array($sv['sub_territories'],$stockiestSubTerritory)){
                    $stockiestSubTerritory[] = $sv['sub_territories'];
                }
            }
        }    

        // Medical store ids array
        $getMedicalStore = MedicalStoreTerritory::whereIn('territories_id',$stockiestTerritory)
                                ->whereIn('sub_territories',$stockiestSubTerritory)
                                ->groupBy('medical_store_id')
                                ->pluck('medical_store_id')
                                ->toArray();     
        
        // Medical store data
        $store_id = MedicalStore::whereIn('id',$getMedicalStore)
                                   ->with(['medical_store_user','mendical_store_territories'])
                                   ->where('is_delete',0)
                                   ->get();     
        
        // Check data that medical store is added or not in the stockiest wise medical store data
        $checkData = array();

        if(!is_null($get_mr_territories)){
           
            $checkData = StockiestWiseMedicalStoreData::where([
                            ['stockiest_id',$id],
                            ['mr_id',$get_mr_territories->mr_id],
                            ['sales_month',$get_mr_territories->sales_month]
                        ])->first();    
        }

        // Get mr wise stokiest data
        $sales_id = MrWiseStockiestData::where('id',$id)->where('mr_id',$get_mr_territories->mr_id)->first();         

        // Save stockiest data
        if(is_null($checkData)){
            if(!is_null($store_id) && !is_null($sales_id)){
                foreach($store_id as $sk => $sv) {

                    $save_stockiest = new StockiestWiseMedicalStoreData;
                    $save_stockiest->medical_store_id = $sv->id;
                    $save_stockiest->stockiest_id = $id;
                    $save_stockiest->sales_id = $mr_id;
                    $save_stockiest->mr_id = $get_mr_territories->mr_id;
                    $save_stockiest->sales_month = $get_mr_territories->sales_month;
                    $save_stockiest->priority = 0;
                    $save_stockiest->save();
                }
            }
        }

        // Stockiest Wise Medical Store Data
        $get_medical_store_data = StockiestWiseMedicalStoreData::where('mr_id',$get_mr_territories->mr_id)->where('stockiest_id',$id)->where('is_delete',0)->with(['stockiest_detail','mr_detail','store_detail'])->orderBy('priority','DESC')->get();

        // Mr wise stockiest list
        $get_stockiest_detail = MrWiseStockiestData::with(['stockiest_detail','mr_detail'])->where('id',$id)->first();

        return view('sales_history.stockiest_sales.medical_store.medical_store_report',compact('get_medical_store_data','get_stockiest_detail'));
    }

    // Update medical store amount
    public function saveMedicalStoreAmount(Request $request){
        
        $get_stockist_data = MrWiseStockiestData::where('id',$request->store_id)->first();

        $query = StockiestWiseMedicalStoreData::where('stockiest_id',$request->store_id)->where('sales_month',$request->date);

        // Store sales amount
        $store_sales_amount = $query->sum( 'sales_amount' );
        // Extra business
        $extra_business = $query->sum( 'extra_business' );
        // Scheme business
        $scheme_business = $query->sum( 'scheme_business' );
        // Ethical business
        $ethical_business = $query->sum( 'ethical_business' );
        // Store total amount
        $store_total_amount = $store_sales_amount + $extra_business + $scheme_business + $ethical_business; //
                
        // Check same value
        $check_same_value = $query->where('id',$request->id)->first();

        if(!is_null($check_same_value) && $check_same_value->sales_amount != ''){
            $basicAmount = $store_total_amount - $check_same_value->sales_amount;
            $add_new_amount = $basicAmount + $request->amount;
        } else {
            $add_new_amount = $store_total_amount + $request->amount;
        }

        if($add_new_amount > $get_stockist_data->amount){

            return 'false';

        } else {

            // Sales amount
            if(isset($request->type) && ($request->type == 1)){

                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['sales_amount' => $request->amount]);

            }

            // Extra business
            if(isset($request->type) && ($request->type == 2)){

                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['extra_business' => $request->amount]);

            }

            // Scheme business
            if(isset($request->type)  && ($request->type == 3)){

                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['scheme_business' => $request->amount]);

            }

            // Ethical business
            if(isset($request->type) && ($request->type == 4)){

                $updateAmount = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['ethical_business' => $request->amount]);

            }

            // Check priority
            $updatePriority = StockiestWiseMedicalStoreData::where('id',$request->id)->whereNull('sales_amount')->whereNull('extra_business')->whereNull('scheme_business')->whereNull('ethical_business')->first();

            // Update priority
            if(!empty($updatePriority)){
                $updatePriority = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['priority' => 0]);
            } else {
                $updatePriority = StockiestWiseMedicalStoreData::where('id',$request->id)->update(['priority' => 1]);
            }
        }

        return $updateAmount ? 'true' : 'false';
    }

    // Delete medical store data
    public function deleteMedicalStoreData($id,$stockiest_id,$mr_id){

        $updateEntry = StockiestWiseMedicalStoreData::where('id',$id)->update(['sales_amount' => NULL,'extra_business' => NULL,'scheme_business' => NULL,'ethical_business' => NULL,'submitted_on' => NULL,'priority' => 0]);

        // Remove doctor data
        $updateAttachment = MedicalStoreDoctorData::where('medical_store_id',$id)->delete();

        return redirect(route('admin.medicalstoreHistoryReportList',[$stockiest_id,$mr_id]))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Entry',
                'message' => 'Entry Successfully Cleared',
            ],
        ]);
    }

    // Medical store doctor sales report
    public function medicalstoreDoctorSalesReport($id,$stockiest_id,$mr_id){

        // Get mr territories & sub territories
        $get_mr_territories = SalesHistory::with(['mr_detail' => function($q){ $q->with(['get_territory']); } ,'user_detail'])->where('id',$mr_id)->first();

        // Get medical store id
        $get_medical_store_id = StockiestWiseMedicalStoreData::where('id', $id)->where('sales_id', $mr_id)->where('mr_id',$get_mr_territories->mr_id)->where('stockiest_id',$stockiest_id)->where('is_delete',0)->first();

        // $doctorName = MedicalStoreDoctorData::where('medical_store_id',$id)->where('mr_id',$get_mr_territories->mr_id)->where('stockiest_id',$stockiest_id)->where('is_delete',0)->whereYear('sales_month',$get_mr_territories->sales_month)->with(['stockiest_detail'])->get();

        // //mr territories and sub territories
        // $mrTerritories = array();
        // $mrSubTerritories = array();

        // if(!empty($get_mr_territories['mr_detail']['get_territory'])){
        //     foreach ($get_mr_territories['mr_detail']['get_territory'] as $sk => $sv) {
                
        //         if(!in_array($sv['territories_id'],$mrTerritories)){
        //             $mrTerritories[] = $sv['territories_id'];
        //         }

        //         if(!in_array($sv['sub_territories'],$mrSubTerritories)){
        //             $mrSubTerritories[] = $sv['sub_territories'];
        //         }
        //     }
        // }

        // //get stockiest data
        // $stockiestTerritory = array();
        // $stockiestSubTerritory = array();

        // $getStokist = StockiestTerritory::whereIn('territories_id',$mrTerritories)
        //                                 ->whereIn('sub_territories',$mrSubTerritories)
        //                                 ->select('territories_id','sub_territories')
        //                                 ->get();

        // if(!is_null($getStokist)){
        //     foreach($getStokist as $sk => $sv){
                
        //         if(!in_array($sv['territories_id'],$stockiestTerritory)){
        //             $stockiestTerritory[] = $sv['territories_id'];
        //         }

        //         if(!in_array($sv['sub_territories'],$stockiestSubTerritory)){
        //             $stockiestSubTerritory[] = $sv['sub_territories'];
        //         }
        //     }
        // }

        // //Get medical store data
        // $medicalStoreTerritories = array();
        // $medicalStoreSubTerritories = array();

        // $getMedicalStore = MedicalStoreTerritory::whereIn('territories_id',$stockiestTerritory)
        //                         ->whereIn('sub_territories',$stockiestSubTerritory)
        //                         ->select('territories_id','sub_territories')
        //                         ->get();    
        
        // if(!is_null($getMedicalStore)){
        //     foreach($getMedicalStore as $sk => $sv){
                
        //         if(!in_array($sv['territories_id'],$medicalStoreTerritories)){
        //             $medicalStoreTerritories[] = $sv['territories_id'];
        //         }

        //         if(!in_array($sv['sub_territories'],$medicalStoreSubTerritories)){
        //             $medicalStoreSubTerritories[] = $sv['sub_territories'];
        //         }
        //     }
        // } 

        // // Get Medical store territories & sub territories
        // $doctorID = DoctorTerritory::whereIn('territories_id', array_unique($medicalStoreTerritories))
        //                             ->whereIn('sub_territories',array_unique($medicalStoreSubTerritories))
        //                             ->groupBy('doctor_id')
        //                             ->pluck('doctor_id')
        //                             ->toArray();

        
        
        $getMedicalStore = MedicalStoreTerritory::where('medical_store_id',$get_medical_store_id->medical_store_id)->get();
        // Mr territories & sub territories
        if(!is_null($getMedicalStore)){
            foreach ($getMedicalStore as $tk => $tv) {
                $territories[] = $tv->territories_id;
                $sub_territories[] = $tv->sub_territories;
            }
        }

        //doctors detail
        $doctorId = DoctorTerritory::whereIn('territories_id',$territories)
                                            ->whereIn('sub_territories',$sub_territories)
                                            ->select('territories_id','sub_territories','doctor_id')
                                            ->pluck('doctor_id')->toArray();
        
        //get doctor depend on mr territories
        $territoristDoctorDetail = DoctorProfile::whereIn('doctor_id',$doctorId)->where('is_delete',0)->get();

        // Medical store wise doctors data
        $check_data = MedicalStoreDoctorData::where('medical_store_id',$get_medical_store_id->medical_store_id)->where('sales_month',$get_mr_territories->sales_month)->first();

        // Save stockiest data
        if(empty($check_data)){
            if(!is_null($territoristDoctorDetail)){
                foreach($territoristDoctorDetail as $sk => $sv) {
                    $save_doctor_detail = new MedicalStoreDoctorData;
                    $save_doctor_detail->doctor_profile = $sv->id;
                    $save_doctor_detail->doctor_id = $sv->doctor_id;
                    $save_doctor_detail->medical_store_id = $get_medical_store_id->medical_store_id;
                    $save_doctor_detail->stockiest_id = $stockiest_id;
                    $save_doctor_detail->sales_id = $mr_id;
                    $save_doctor_detail->mr_id = $get_mr_territories->mr_id;
                    $save_doctor_detail->sales_month = $get_mr_territories->sales_month;
                    $save_doctor_detail->priority = 0;
                    $save_doctor_detail->save();
                }
            }
        }

        /* $get_medical_store_data = MedicalStoreDoctorData::where('mr_id',$get_mr_territories->mr_id)->where('stockiest_id',$stockiest_id)->where('medical_store_id',$id)->where('is_delete',0)->with(['doctor_detail','stockiest_detail','mr_detail','store_detail','profile_detail'])->orderBy('priority','DESC')->get();*/

        // Medical store wise doctors data
        $get_medical_store_data = MedicalStoreDoctorData::where('medical_store_id', $get_medical_store_id->medical_store_id)->where('mr_id',$get_mr_territories->mr_id)->where('stockiest_id',$stockiest_id)->where('is_delete',0)->whereYear('sales_month',$get_mr_territories->sales_month)->with(['stockiest_detail', 'commission'])->get();

        // Stockiest wise medical store data
        $get_stockiest_detail = StockiestWiseMedicalStoreData::where('id',$id)->with(['store_detail','stockiest_detail' => function($q){ $q->with(['stockiest_detail']); },'mr_detail'])->first();

        return view('sales_history.stockiest_sales.medical_store.doctor_data.doctor_report',compact('get_medical_store_data','get_stockiest_detail'));
    }

    // Save doctor amount
    public function saveDoctorAmount(Request $request){

        $get_stockist_data = StockiestWiseMedicalStoreData::where('id',$request->store)->first();

        $query = MedicalStoreDoctorData::where('medical_store_id',$get_stockist_data->medical_store_id)->where('sales_month',$get_stockist_data->sales_month);

        // Store sales amount sum
        $store_sales_amount = $query->sum( 'sales_amount' );

        $check_same_value = $query->where('id', $request->id)->first();

        $total_amount = $get_stockist_data->sales_amount;

        if(empty($check_same_value)){
            
            $add_new_amount = $store_sales_amount + $request->amount;

        } else {

            $add_new_amount = $store_sales_amount - $check_same_value->sales_amount + $request->amount;
        } 
        
        if($add_new_amount > $total_amount){

            return 'false';

        } else {

            //$salesMonth = '2021-12-25';
            $date = explode('-', date('Y-m-d'));
            $salesMonth = $date[0].'-'.$date[1].'-25';

            $priority = $request->amount != '' ? 1 : 0;
            
            // Update amount of doctors sales
            $update_amount = MedicalStoreDoctorData::findOrFail($request->id);
            $old_amount = $update_amount->sales_amount;
            $update_amount->sales_amount = $request->amount;
            $update_amount->priority = $priority;
            $current_date = $update_amount->sales_month;
            if($update_amount->isDirty()){   
                $update_amount->previous_sales_amount = $old_amount;
                $update_amount->is_considered = 0;
            }
            $update_amount->save();
            
            //doctor offset calculations
            // $updateAmount = MedicalStoreDoctorData::where('id',$request->id)->update(['sales_amount' => $request->amount,'priority' => $priority]);

            // Get doctor id
            $getDoctorDetail = MedicalStoreDoctorData::with(['commission'])->where('id',$request->id)->first();

            $getDoctorSales = MedicalStoreDoctorData::where('doctor_profile',$getDoctorDetail->doctor_profile)
                                                    ->where('doctor_id',$getDoctorDetail->doctor_id)->where('sales_month',$salesMonth)->first();

            if(!is_null($getDoctorSales)){

                $getTotalSale = MedicalStoreDoctorData::where('doctor_profile',$getDoctorDetail->doctor_profile)
                                                    ->where('doctor_id',$getDoctorDetail->doctor_id)->where('sales_month',$salesMonth)->sum('sales_amount');

                $getDoctorOffset = DoctorOffset::where('profile_id',$getDoctorDetail->doctor_profile)
                                               ->where('doctor_id',$getDoctorDetail->doctor_id)
                                               ->orderBy('id','DESC')
                                               ->first();                                        


                $lastMonthSales = !is_null($getDoctorOffset) ? $getDoctorOffset->carry_forward : 0;
                
                $amount = $request->amount != null ? $request->amount : 0;
                            
                $carrryForwardAmount = 0;

                if($lastMonthSales > 0){
                    $carrryForwardAmount = $lastMonthSales + $old_amount;
                } else {
                    $carrryForwardAmount = $lastMonthSales - $old_amount;
                }

                if(!is_null($getDoctorDetail) && !is_null($getDoctorDetail->commission)){
                    if($lastMonthSales != 0){
                        $totalSales = $amount + $carrryForwardAmount;
                    } else {
                        $totalSales = $amount + 0;
                    }
                       
                    $eligibility = ($totalSales * $getDoctorDetail->commission->commission) / 100;
                       
                    $target = 0;
                       
                    $carry_forward  = $totalSales - $target;

                    $saveoffset = new DoctorOffset;
                    $saveoffset->last_month_sales = $getTotalSale ? $getTotalSale : 0;
                    $saveoffset->last_month_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
                    $saveoffset->target_previous_month_date = $current_date;
                    $saveoffset->carry_forward = $carry_forward;
                    $saveoffset->carry_forward_date = $current_date;
                    $saveoffset->eligible_amount = $eligibility;
                    $saveoffset->eligible_amount_date = $current_date;
                    $saveoffset->profile_id = $getDoctorDetail->doctor_profile;
                    $saveoffset->doctor_id = $getDoctorDetail->doctor_id;
                    $saveoffset->previous_second_month_sales = !is_null($getDoctorOffset) ? $getDoctorOffset->previous_second_month_sales  : 0;
                    $saveoffset->previous_second_month_date = date('Y-m-d', strtotime('-1 month', strtotime($current_date)));
                    $saveoffset->previous_third_month_date = date('Y-m-d', strtotime('-2 month', strtotime($current_date)));
                    $saveoffset->previous_third_month_sales = !is_null($getDoctorOffset) ? $getDoctorOffset->previous_third_month_sales : 0;
                    $saveoffset->target_previous_month = 0;
                    $saveoffset->save();

                    return 'true';
                }
            } else {
                return 'false';
            }
        }
    }

    // Delete doctor data
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
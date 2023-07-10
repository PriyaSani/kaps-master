<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use App\Model\User;
use App\Model\AllRequest;
use App\Model\DoctorDetail;
use App\Model\UserTerritory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;

class AdminController extends GlobalController
{
    public function __construct(){

        $this->middleware('auth');
    }

    // Admin dashboard with calendar
    public function adminindex(){
        
        // Doctors date of birth
    	$doctors_dob = DoctorDetail::where('is_delete', 0)->selectRaw('year(dob) year, monthname(dob) month, day(dob) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->with(['get_doctor_territory' => function($q){ $q->with(['territory_name']); }])->get();

    	// Doctors anniversary date
    	$doctors_anniversary = DoctorDetail::where('is_delete', 0)->selectRaw('year(anniversary_date) year, monthname(anniversary_date) month, day(anniversary_date) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->with(['get_doctor_territory' => function($q){ $q->with(['territory_name']); }])->get();

    	// Doctors clinic opening date
    	$clinic_open_date = DoctorDetail::where('is_delete', 0)->selectRaw('year(clinic_opening_date) year, monthname(clinic_opening_date) month, day(clinic_opening_date) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->with(['get_doctor_territory' => function($q){ $q->with(['territory_name']); }])->get();

    	// Mr payment received date
    	$payment_rec = AllRequest::with(['mr_detail'])->get();

    	// Mr payment paid to doctor date
    	$payment_paid = AllRequest::with(['mr_detail'])->with(['doctor_detail'])->get();

		if(Auth::guard()->user()->id != 1){
			
			$get_user_territory = array_unique($this->userTerritory(Auth::guard()->user()->id));
			$get_user_sub_territory = array_unique($this->userSubTerritory(Auth::guard()->user()->id));

			// Doctors date of birth
			$doctors_dob = DoctorDetail::where('is_delete', 0)->selectRaw('year(dob) year, monthname(dob) month, day(dob) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->with(['get_doctor_territory' => function($q){ $q->with(['territory_name']); }])->whereHas('territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->get();

			// Doctors anniversary date
			$doctors_anniversary = DoctorDetail::where('is_delete', 0)->selectRaw('year(anniversary_date) year, monthname(anniversary_date) month, day(anniversary_date) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->with(['get_doctor_territory' => function($q){ $q->with(['territory_name']); }])->whereHas('territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->get();

			// Doctors clinic opening date
			$clinic_open_date = DoctorDetail::where('is_delete', 0)->selectRaw('year(clinic_opening_date) year, monthname(clinic_opening_date) month, day(clinic_opening_date) date, full_name, id')->groupBy('id', 'year', 'month', 'date', 'full_name')->with(['get_doctor_territory' => function($q){ $q->with(['territory_name']); }])->whereHas('territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territories_id', $get_user_territory); })->WhereHas('territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territories',$get_user_sub_territory); })->get();
			
			// Mr payment received date
			$payment_rec = AllRequest::with(['mr_detail'])->whereHas('main_territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territory_id', $get_user_territory); })->WhereHas('main_territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territory_id',$get_user_sub_territory); })->get();
			
			// Mr payment paid to doctor date
			$payment_paid = AllRequest::with(['mr_detail'])->with(['doctor_detail'])->whereHas('main_territory_detail', function ($query) use ($get_user_territory) { $query->whereIn('territory_id', $get_user_territory); })->WhereHas('main_territory_detail', function ($query) use ($get_user_sub_territory) { $query->whereIn('sub_territory_id',$get_user_sub_territory); })->get();

		}
		
    	$dob = array();				// Doctor's birthdate array
    	$anniversary = array();		// Doctor's anniversary array
    	$clinic_open = array();		// Doctor's clinic opening date array
    	$pay_rec = array();			// Mr payment recived date array
    	$pay_paid = array();		// Mr payment paid to doctor date array 
    
    	if(!empty($doctors_dob)){
	    	foreach ($doctors_dob as $bk => $bv) {
	    		
				$dob[$bk]['id']= $bk;
				if(!empty($bv->get_doctor_territory)){
					$dob[$bk]['name'] = $bv->full_name."'s Birthday (". $bv->get_doctor_territory->territory_name->territory_id.")";	
				}else{
					$dob[$bk]['name'] = $bv->full_name."'s Birthday";	
				}
				
				$dob[$bk]['date'] = $bv->month."/".$bv->date."/".$bv->year;
				$dob[$bk]['everyYear'] = true;
				$dob[$bk]['type'] = "birthday";

	     	}
	    }

	    if(!empty($doctors_anniversary)){
	     	foreach ($doctors_anniversary as $ak => $av) {

	    		$anniversary[$ak]['id']= $ak;

	    		if(!empty($bv->get_doctor_territory)){
					$anniversary[$ak]['name'] = $av->full_name."'s Anniversary (". $av->get_doctor_territory->territory_name->territory_id.")";
				}else{
					$anniversary[$ak]['name'] = $av->full_name."'s Anniversary";
				}

				
				$anniversary[$ak]['date'] = $av->month."/".$av->date."/".$av->year;
				$anniversary[$ak]['everyYear'] = true;
				$anniversary[$ak]['type'] = "anniversary";

	     	}
	    }

	    if(!empty($clinic_open_date)){
	     	foreach ($clinic_open_date as $ck => $cv) {
	     		
	    		$clinic_open[$ck]['id']= $ak;

	    		if(!empty($bv->get_doctor_territory)){
					$clinic_open[$ck]['name'] = $cv->full_name."'s Clinic Opening Anniversary (". $cv->get_doctor_territory->territory_name->territory_id.")";
				}else{
					$clinic_open[$ck]['name'] = $cv->full_name."'s Clinic Opening Anniversary";
				}

				
				$clinic_open[$ck]['date'] = $cv->month."/".$cv->date."/".$cv->year;
				$clinic_open[$ck]['everyYear'] = true;
				$clinic_open[$ck]['type'] = "clinic";
				
	     	}
	    }

	    if(!empty($payment_rec)){
			foreach ($payment_rec as $rk => $rv)
		   {
			   $pay_rec[$rk]['id']= $ak;
			   $pay_rec[$rk]['name'] = "₹ ".$rv->request_amount." received by ".$rv->mr_detail->full_name;
			   $month = date('F', strtotime($rv->received_on));
			   $date = date('d', strtotime($rv->received_on));
			   $year = date('Y', strtotime($rv->received_on));
			   $pay_rec[$rk]['date'] = $month."/".$date."/".$year;
			   $pay_rec[$rk]['type'] = "mrrec";
			}
	   }

	   if(!empty($payment_paid)){
			foreach ($payment_paid as $pk => $pv) 
		   {
			   $pay_paid[$pk]['id']= $ak;
			   $pay_paid[$pk]['name'] = $pv->mr_detail->full_name." paid ₹ ".$pv->request_amount." to ".$pv->doctor_detail->full_name;
			   $month = date('F', strtotime($rv->paid_on));
			   $date = date('d', strtotime($rv->paid_on));
			   $year = date('Y', strtotime($rv->paid_on));
			   $pay_paid[$pk]['date'] = $month."/".$date."/".$year;
			   $pay_paid[$pk]['type'] = "mrpaid";
			}
	   }
	
     	$all_data = array_merge($dob,$anniversary,$clinic_open,$pay_rec,$pay_paid);	// Merge all array

     	$dates = json_encode($all_data); // Encoding merge all array

     	$calendar = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $dates); // Removed double inverted comma form array

    	return view('calendar.event_list',compact('calendar'));
    }

    // Change admin password
    public function changeAdminPassword(){

        return view('admin.dashboard.change_password');
    }

    // Update admin password
    public function updateAdminPassword(Request $request){

        $this->validate($request, [
            'old_pass' => 'required',
            'new_pass' => 'required'
        ]);

        $adminId = Auth::guard()->user()->id;
        $user = User::where('id', '=', $adminId)->first();

        if(Hash::check($request->old_pass,$user->password)){

            $users = User::findOrFail($adminId);
            $users->password = Hash::make($request->new_pass);
            $users->save();

            return redirect(route('dashboard'))->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'Password',
                    'message' => 'Password Successfully changed',
                ],
            ]); 

        } else {
          
            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Password',
                    'message' => 'Plese check your current password',
                ],
            ]); 
        }
    }
}

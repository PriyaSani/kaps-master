<div>
	<div class="vertical-menu">

	    <div data-simplebar class="h-100">

	        <!--- Sidemenu -->
	        <div id="sidebar-menu">
	            <!-- Left Menu Start -->
	            <ul class="metismenu list-unstyled" id="side-menu">
	                <li class="menu-title">Menu</li>

	                <li>
	                    <a href="{{ route('dashboard') }}" class="waves-effect">
	                        <i class="bx bx-home-circle"></i><span class="badge badge-pill badge-info float-right"></span>
	                        <span>Calendar</span>
	                    </a>
	                </li>

	                @if(in_array('territory',$module))
	                <li>
	                    <a href="javascript: void(0);" class="has-arrow waves-effect">
	                        <i class="bx bx-customize"></i>
	                        <span>Territory</span>
	                    </a>
	                    <ul class="sub-menu" aria-expanded="false">
	                        <li><a href="{{ route('admin.addTerritory') }}">Add Territory</a></li>
	                        <li><a href="{{ route('admin.territoryList') }}">All Territory</a></li>
	                    </ul>
	                </li>
	                @endif

	                @if(in_array('employee',$module))
	                <li>
	                    <a href="javascript: void(0);" class="has-arrow waves-effect">
	                        <i class="bx bx-user"></i>
	                        <span>Employees</span>
	                    </a>
	                    <ul class="sub-menu" aria-expanded="false">
	                        <li><a href="{{ route('admin.addEmployee') }}">Add Employees</a></li>
	                        <li><a href="{{ route('admin.employeeList') }}">All Employees</a></li>
	                    </ul>
	                </li>
	                @endif

	                @if(in_array('mr',$module))
	                <li>
	                    <a href="javascript: void(0);" class="has-arrow waves-effect">
	                        <i class="bx bx-user"></i>
	                        <span>MR</span>
	                    </a>
	                    <ul class="sub-menu" aria-expanded="false">
	                        <li><a href="{{ route('admin.addMr') }}">Add MR</a></li>
	                        <li><a href="{{ route('admin.mrList') }}">All MR</a></li>
	                    </ul>
	                </li>
	                @endif

	                @if(in_array('doctor',$module))
	                <li>
	                    <a href="javascript: void(0);" class="has-arrow waves-effect">
	                        <i class="bx bx-user"></i>
	                        <span>Doctor</span>
	                    </a>
	                    <ul class="sub-menu" aria-expanded="false">
	                        <li><a href="{{ route('admin.addDoctor') }}">Add Doctor</a></li>
	                        <li><a href="{{ route('admin.doctorList') }}">All Doctors</a></li>
	                    </ul>
	                </li>
	                @endif

	                @if(in_array('medical-store',$module))
	                <li>
	                    <a href="javascript: void(0);" class="has-arrow waves-effect">
	                        <i class="bx bx-store"></i>
	                        <span>Medical Store</span>
	                    </a>
	                    <ul class="sub-menu" aria-expanded="false">
	                        <li><a href="{{ route('admin.addStore') }}">Add Medical Store</a></li>
	                        <li><a href="{{ route('admin.storeList') }}">All Medical Store</a></li>
	                    </ul>
	                </li>
	                @endif

	                @if(in_array('stockiest',$module))
	                <li>
	                    <a href="javascript: void(0);" class="has-arrow waves-effect">
	                        <i class="bx bx-briefcase"></i>
	                        <span>Stockiest</span>
	                    </a>
	                    <ul class="sub-menu" aria-expanded="false">
	                        <li><a href="{{ route('admin.addStockiest') }}">Add Stockiest</a></li>
	                        <li><a href="{{ route('admin.stockiestList') }}">All Stockiest</a></li>
	                    </ul>
	                </li>
	                @endif

	                @if(in_array('medical-store',$module) || in_array('stockiest',$module))
 					<li>
	                    <a href="{{ route('admin.associatedUserList') }}" class="waves-effect">
	                        <i class="bx bx-group"></i><span class="badge badge-pill badge-info float-right"></span>
	                        <span>Associated User List</span>
	                    </a>
	                </li>
	                @endif

	                @if(in_array('sales-history',$module))
	                <li>
	                    <a href="{{ route('admin.salesHistoryList') }}" class="waves-effect">
	                        <i class="bx bx-align-left"></i><span class="badge badge-pill badge-info float-right"></span>
	                        <span>Sales History</span>
	                    </a>
	                </li>
	                @endif


	                @if(in_array('all-request',$module))
	                <li>
	                    <a href="{{ route('admin.allRequestList') }}" class="waves-effect">
	                        <i class="bx bx-log-in-circle"></i><span class="badge badge-pill badge-info float-right"></span>
	                        <span>All Request</span>
	                    </a>
	                </li>
	                @endif

	                <!-- <li>
	                    <a href="{{ route('admin.eventList') }}" class="waves-effect">
	                        <i class="bx bx-calendar"></i>
	                        <span>Calendar</span>
	                    </a>
	                </li> -->

	            </ul>
	            
	        </div>
	        <!-- Sidebar -->
	    </div>
	</div>
</div>
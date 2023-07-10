@extends('layouts.admin')
@section('title','Calendar')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        Event List
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Event List</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->

        <div id="calendarList" class="lnb-calendars-d1 mt-4 mr-sm-0 mb-4">
            <div class="lnb-calendars-item">
                <label>
                    <input type="checkbox" class="tui-full-calendar-checkbox-round" value="1" checked="">
                    <span style="border-color: #FF0000; background-color: #FF0000;"></span>
                    <span>Birthday</span>
                </label>
            </div>
            <div class="lnb-calendars-item">
                <label>
                    <input type="checkbox" class="tui-full-calendar-checkbox-round" value="2" checked="">
                    <span style="border-color: #FFFF00; background-color: #FFFF00;"></span>
                    <span>Anniversary</span>
                </label>
            </div>
            <div class="lnb-calendars-item">
                <label>
                    <input type="checkbox" class="tui-full-calendar-checkbox-round" value="2" checked="">
                    <span style="border-color: #008000; background-color: #008000;"></span>
                    <span>Clinic opening anniversary</span>
                </label>
            </div>
            <div class="lnb-calendars-item">
                <label>
                    <input type="checkbox" class="tui-full-calendar-checkbox-round" value="2" checked="">
                    <span style="border-color: #000000; background-color: #000000;"></span>
                    <span>MR payment received</span>
                </label>
            </div>
            <div class="lnb-calendars-item">
                <label>
                    <input type="checkbox" class="tui-full-calendar-checkbox-round" value="2" checked="">
                    <span style="border-color: #0000FF; background-color: #0000FF;"></span>
                    <span>MR payment paid to doctor</span>
                </label>
            </div>
        </div>

        <div id="evoCalendar"></div>

    </div> <!-- container-fluid -->
</div>
@endsection

@section('js')
<script>

    myEvents = {!! $calendar !!},

    $('#evoCalendar').evoCalendar({
        calendarEvents: myEvents,
        theme: 'Orange Coral'
    });


</script>
@endsection
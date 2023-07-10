<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | KAPS3</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('components.admin.partials.header_link')
    </head>
    
    <body data-sidebar="dark">
    
       
        <div id="layout-wrapper" >
       
            <x-admin-topnavigation />
            <x-admin-sidebar />
            <div class="main-content">
                @yield('content')
                @if(\Route::current()->getName() == 'admin.addStockiest' || \Route::current()->getName() == 'admin.editStockiest' || \Route::current()->getName() == 'admin.addStore' || \Route::current()->getName() == 'admin.editStore') 
                    @include('components.admin.partials.admin_modal')
                @else
                    @include('components.admin.partials.admin_image_modal')
                @endif
                @include('components.admin.partials.footer')
            </div>
        </div>
        <div class="rightbar-overlay"></div>
        @include('components.admin.partials.footer_link')
        @yield('js')
    </body>
</html>
<script type="text/javascript">
    @if(Session::has('messages'))
        $(document).ready(function() {
            @foreach(Session::get('messages') AS $msg) 
                toastr['{{ $msg["type"] }}']('{{$msg["message"]}}');
            @endforeach
        });
    @endif

    @if (count($errors) > 0) 
        $(document).ready(function() {
            @foreach($errors->all() AS $error)
                toastr['error']('{{$error}}');
            @endforeach     
        });
    @endif
</script>
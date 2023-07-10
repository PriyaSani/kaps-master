<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | {{ env('APP_TITLE') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
        @include('components.login.header_link')
    </head>
    <body>
        @yield('content')
    </body>
        @include('components.login.footer_link')
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="informer/informer.css" type="text/css" />
        <script language="javascript" src="js/jquery-1.11.0.min.js"></script>
        <script language="javascript" src="informer/informer.js"></script>
        <script>
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name="csrf-token"]').attr("content") }
            });
        </script>
        @section('special_links')
        
        @show
    </head>
    <title>Uniservice</title>
    <body>
        <div class="menu">
            <img class = "logo" src="img/logo.png" />
            @if (Auth::user())
                <a href="/logout"><img class = "logoff pic" src="img/arrow.png" /></a> 
                @if (Auth::user()->type == "Клиент")
                    <img class = "q pic" src="img/q.png" />
                    <a href="/shipped"><img class = "truck pic" src="img/truck.png" /></a>
                    <a href="/"><img class = "search pic" src="img/search.png" /></a>
                @elseif (Auth::user()->type == "Администратор")
                    <!-- <a href="/download"><img class = "todownload pic" src="img/todownload.png" /></a> -->
                    <img class = "todownload pic" src="img/todownload.png" />
                    <img class = "users pic" src="img/users.png" />
                @endif
            @endif
        </div>
        @yield('content')
    </body>
</html>
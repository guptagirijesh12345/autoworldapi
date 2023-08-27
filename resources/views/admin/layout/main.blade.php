<html>
    <head>
        @include('admin.include.header')
    </head>
    <body>
        <div class="wrapper">
            @include('admin.include.sidebar')
            <div class="main">
                @include('admin.include.navbar')

                @yield('content')
            </div>
        </div>
        
        @include('admin.include.footer')
    </body>
</html>
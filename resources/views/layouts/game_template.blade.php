<html>
    <head>
      <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
        <title>@yield('title')</title>
        @yield("head")
    </head>
    <body>


        @yield("css")


      @yield('content')
    </div>
    </body>
</html>

<script type="text/javascript" src="<?php echo asset('assets/js/jquery.js'); ?>"></script>

@yield('javascript')

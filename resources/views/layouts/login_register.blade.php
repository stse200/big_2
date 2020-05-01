<html>
  <head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
      <title>@yield('title')</title>
      @yield("head")
  </head>
  <body>
    <style>
      body{ background-color: #808080;
      }

      .content{
        background-color: #ffffff;
        width: 25%;
        margin: 0 auto;
        margin-top: 10%;
        border-radius: 20px;
        padding: 10px;
        border: 2px solid #000000;
      }
    </style>

      @yield("css")

      <div class="content">
        @yield('content')
      </div>
  </div>
  </body>
</html>

<script type="text/javascript" src="<?php echo asset('assets/js/jquery.js'); ?>"></script>

@yield('javascript')

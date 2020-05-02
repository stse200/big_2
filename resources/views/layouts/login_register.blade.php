<html>
  <head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
      <title>@yield('title')</title>
      @yield("head")
  </head>
  <body>
    <style>
      #submit_form{
        margin-top: 20px;
        background-color: rgb(48,166,74);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        font-size: 18pt;
        color: rgb(255,255,255);
        padding: 3px;
      }

      body {
      background-color: rgb(109,117,125);
      margin: 0px;
      }

      .heading{
        background-color: #0f2ca3;
        color: #b89a2e;
        font-size: 24pt;
        text-align: center;
        margin-top: 0px;
        padding-top: 10px;
        padding-bottom: 10px;
        font-family: "Arial Black";
      }

      .content{
        background-color: #ffffff;
        width: 25%;
        margin: 0 auto;
        border-radius: 20px;
        margin-top: 5px;
        padding: 10px;
        border: 2px solid #000000;
      }
    </style>

    @yield("css")
    <div class="heading">
      Welcome to Dai Di!
    </div>
    <div class="content">
      @yield('content')
    </div>
  </body>
</html>

<script type="text/javascript" src="<?php echo asset('assets/js/jquery.js'); ?>"></script>

@yield('javascript')

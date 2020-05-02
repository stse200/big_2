<html>
  <head>
    <script src="https://kit.fontawesome.com/f7d7392e66.js" crossorigin="anonymous"></script>
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
      background-color: rgb(64,64,64);
      margin: 0px;
      }

      .heading{
        background-color: rgb(38,38,38);
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.7);
        color: #b89a2e;
        font-size: 24pt;
        text-align: center;
        margin-top: 0px;
        padding-top: 10px;
        padding-bottom: 10px;
        font-family: "Arial Black";
      }

      .content{
        background-color: rgb(245,248,251);
        width: 25%;
        margin: 0 auto;
        border-radius: 20px;
        margin-top: 15px;
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

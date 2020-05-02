<html>
  <head>
    <script src="https://kit.fontawesome.com/f7d7392e66.js" crossorigin="anonymous"></script>
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
      <title>@yield('title')</title>
      @yield("head")
  </head>
  <body>
    <style>
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

      .main_section{


      }

      .sidebar{
        display: grid;
        background-color: rgb(0,13,102);
        position: absolute;
        top: 85px;
        left: 20px;
        width: 230;
      }

      .sidebar a{
        font-family: "Arial";

        font-size: 14pt;
        color: rgb(255,255,255);
        border-bottom: 1px solid rgb(161,173,255);
        border-top: 1px solid rgb(161,173,255);
        padding-left: 20px;
        vertical-align: middle;
        line-height: 50px;
        text-decoration: none;
      }

      .content{
        background-color: rgb(245,248,251);
        margin: 20px 20px 20px 270px;
      }


    </style>


    @yield("css")

    <div class="heading">
      Welcome to Dai Di!
    </div>
    <div class="main_section">
      <div class="sidebar">
        <a href="{{action("UsersController@logout")}}"><i class="fas fa-door-open"></i> Logout</a>
      </div>
      <div class="content">
        @yield('content')

      </div>
    </div>

  </body>
</html>

<script type="text/javascript" src="<?php echo asset('assets/js/jquery.js'); ?>"></script>

@yield('javascript')

<html>
  <head>
    <script src="https://kit.fontawesome.com/f7d7392e66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
      <title>@yield('title') | Dai Di Online</title>
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
        border-bottom: 1px solid rgb(0, 17, 130);
        border-top: 1px solid rgb(0, 22, 166);
        padding-left: 20px;
        vertical-align: middle;
        line-height: 50px;
        text-decoration: none;
      }

      .content{
        background-color: rgb(245,248,251);
        margin: 20px 20px 20px 270px;
      }

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
        font-family: "Arial";
      }

      .footer{
        text-align: center;
        margin-left: 270px;
        margin-top: 50px;
        color: rgb(116,135,166);
      }


    </style>


    @yield("css")

    <div class="heading">
      Welcome to the Tse Casino
    </div>
    <div class="main_section">
      <div class="sidebar">
        <a href="{{action("UsersController@home")}}"><i class="fas fa-home"></i> Home</a>
        @yield("sidebar")
        <a href="{{action("UsersController@logout")}}"><i class="fas fa-door-open"></i> Logout</a>
      </div>
      <div class="content">
        @yield('content')

      </div>
    </div>
    <div class="footer">
      Made By Stephen Tse in <i class="fab fa-laravel"></i>Laravel
    </div>

  </body>
</html>

<script type="text/javascript" src="<?php echo asset('assets/js/jquery.js'); ?>"></script>

@yield('javascript')

@extends('layouts.home_template')


@section("title")
Admin Controls
@endsection

@section("css")

<style>

.container{
  padding: 20px;
}

.panel_content{
  width: 50%;
}

i{
  padding-left: 5px;
}

#username_exists{
  color: rgb(48,166,74);
  display: none;
}

#username_no_exists{
  color: rgb(218,56,73);
  display: none;
}

.input_error{
  color: rgb(184,9,32);
  display: none;
  grid-column-start: 1;
  grid-column-end: 3;
}

</style>

@endsection

@section("javascript")

<script>

$("#username").keyup(function(){

  if($("#username").val().length > 0){

    $.ajax({
      type:"POST",
      url:"/check_username",
      data:{_token: '<?php echo csrf_token() ?>', username: $("#username").val()},
      success: function(data){
        if(data.is_valid){
          //ASSERT: valid username
          $("#username_exists").css("display", "none");
          $("#username_no_exists").css("display", "inline-block");
        }
        else{
          //ASSERT: username is taken
          $("#username_exists").css("display", "inline-block");
          $("#username_no_exists").css("display", "none");
        }
      }

    });
  }
  else{
    $("#username_exists").css("display", "none");
    $("#username_no_exists").css("display", "none");
  }
});

$("#change_password_button").on("click", function(){
  var valid_form = true;

  if($("#username_exists").css("display") != "inline-block"){
    valid_form = false;
    $("#username_error").css("display", "inline-block");
  }

  if($("#p1").val() == $("#p2").val()) {
    if(($("#p1").val().length >= 8) && ($("#p1").val().length <= 30)){
      $("#change_password_form").submit();
    }
    else{
      $("#password_length_error").css("display", "grid");
    }
  }
  else{
    $("#password_error").css("display", "grid");
  }

  if(valid_form){
    $("#change_password").submit();
  }
});
$("#p1").keydown(function(){
  $("#password_length_error").css("display", "none");
  $("#password_error").css("display", "none");
});

$("#username").keydown(function(){
  $("#username_error").css("display", "none");
});



</script>

@endsection

@section("content")

<div class="container">
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-change_password" aria-selected="true"><i class="fas fa-key"></i> Change Password</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-change_scores" aria-selected="false"><i class="fas fa-pencil-alt"></i> Change Scores</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-restore_games" aria-selected="false"><i class="fas fa-trash-restore-alt"></i> Restore Games</a>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-change_password-tab">
    <form id="change_password" method="POST" action="{{action("UsersController@admin_change_password")}}">
      @csrf
      <div class="panel_content">
        Change password for specific User ID.<br><br>
        <label>User ID: </label><i class="fas fa-check" id="username_exists"></i><i class="fas fa-times" id="username_no_exists"></i>
        <input class="form-control" id="username" type="text" name="username" autocomplete="off">
        <div class="input_error" id="username_error">Invalid User ID entered.</div><br>
        <label>New Password:</label>
        <input class="form-control" id="p1" type="password" name="new_password">
        <label>Repeat Password:</label>
        <input class="form-control" id="p2" type="password">
        <div class="input_error" id="password_error">Passwords do not match</div>
        <div class="input_error" id="password_length_error">Password must be between 8 and 30 characters long</div><br>
        <button type="button" class="btn btn-primary" id="change_password_button">Change Password</button>
      </div>
    </form>
  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-change_scores-tab">
    Change scores in a game.
  </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-restore_games-tab">
    Restore deleted games.
  </div>
</div>
</div>

@endsection

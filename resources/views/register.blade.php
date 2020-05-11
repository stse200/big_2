@extends("layouts.login_register")

@section('title')
  Register | Dai Di Online
@endsection

@section("javascript")

  @section("javascript")

<script>

//prevent enter from submitting form
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

$("#submit_form").on("click", function(){
  var name_letters = /^[0-9a-zA-Z ]+$/;
  var username_letters = /^[0-9a-zA-Z]+$/;

  var valid_form = true;

  if(!($("#p1").val() == $("#p2").val())){
    //ASSERT: passwords do not match
    valid_form = false;
    $("#password_error").css("display", "grid");
  }
  if(($("#p1").val().length < 8) || ($("#p1").val().length > 30)){
    //invalid password length
    valid_form = false;
    $("#password_length_error").css("display", "grid");
  }
  if(!($("#username").val().match(username_letters))){
    //ASSERT: invalid username
    valid_form = false;
    $("#username_error").css("display", "grid");
  }
  if(!($("#name").val().match(name_letters))){
    //ASSERT: invalid name
    valid_form = false;
    $("#name_error").css("display", "grid");
  }

  if(valid_form){
    //ASSERT: input is valid, form will be submited
    $("#register_form").submit();
  }
});

$("#username").keyup(function(){

  if($("#username").val().length > 0){

    $.ajax({
      type:"POST",
      url:"/check_username",
      data:{_token: '<?php echo csrf_token() ?>', username: $("#username").val()},
      success: function(data){
        if(data.is_valid){
          //ASSERT: valid username
          $("#username_taken").css("display", "none");
          $("#username_available").css("display", "grid");
        }
        else{
          //ASSERT: username is taken
          $("#username_taken").css("display", "grid");
          $("#username_available").css("display", "none");
        }
      }

    });
  }
  else{
    $("#username_available").css("display", "none");
    $("#username_taken").css("display", "none");
  }
  $("#username_error").css("display", "none");
});

$("#p1").keydown(function(){
  $("#password_error").css("display", "none");
  $("#password_length_error").css("display", "none");
});

$("#p2").keydown(function(){
  $("#password_error").css("display", "none");
  $("#password_length_error").css("display", "none");
});

$("#name").keydown(function(){
  $("#name_error").css("display", "none");
});

</script>

  @endsection

@endsection


@section("css")
<style>

.container{
  display: grid;
  font-family: verdana;
}

.container input{
  font-size: 18pt;
  outline: none;
}

#back_to_login{
  margin-top: 20px;
  background-color: rgb(51,57,63);
  border: none;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none;
  text-align: center;
  font-size: 18pt;
  color: rgb(255,255,255);
  padding: 3px;
}

.input_error{
  color: rgb(184,9,32);
  display: none;
}

#username_available{
  color: #1d9e16;
}

.title{
  font-size: 25pt;
  text-align: center;
  width: 100%
}


</style>
@endsection

@section("content")
  <div class="title">
    Register
  </div>

<form id="register_form" method="POST" action="{{action("UsersController@process_register")}}">
    @csrf
  <div class="container">
    <span>User ID:</span>
    <input id="username" type="text" name="new_username" autocomplete="off" maxlength="10" required>
    <span style="display: none" id="username_available">User ID Available</span>
    <span class="input_error" style="display: none" id="username_taken" >User ID Taken</span>
    <span class="input_error" id="username_error">Username must be letters and numbers only.</span>

    <span>Your Name:</span>
    <input id="name" type="text" name="new_name" autocomplete="off" maxlength="20" required>
    <span class="input_error" id="name_error">Name must be letters and numbers only.</span>
    <span>Password:</span>
    <input id="p1" type="password" name="new_password" maxlength="20" required>

    <span>Confirm Password:</span>
    <input id="p2" type="password" name="confirm_password" maxlength="30" required>
    <span class="input_error" id="password_error">Passwords do not match</span>
    <span class="input_error" id="password_length_error">Password must be between 8 and 30 characters long</span>

    <a id="submit_form"><i class="fas fa-user-circle"></i> Create Account</a>
    <a id="back_to_login" href="{{action("UsersController@login")}}"><i class="fas fa-undo-alt"></i> Back to Login</a>
  </div>
</form>
@endsection

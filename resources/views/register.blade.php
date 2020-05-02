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
  var letters = /^[0-9a-zA-Z]+$/;

  if($("#p1").val() == $("#p2").val()){
    if(($("#username").val().match(letters)) && ($("#p1").val().match(letters)) && ($("#name").val().match(letters))){
      if($("#username_available").css("display") == "grid") {
        $("#login_form").submit();
      }
    }
    else{
      alert("Letters and Numbers Only");
    }

  }
  else{
    $("#password_error").css("display", "grid");
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
});

$("#p1").keydown(function(){
  $("#password_error").css("display", "none");
});

$("#p2").keydown(function(){
  $("#password_error").css("display", "none");
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

#username_available{
  color: #1d9e16;
}

#username_taken{
  color: #b80920;
}

#password_error{
  color: #b80920;
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

<form id="login_form" method="POST" action="{{action("UsersController@process_register")}}">
    @csrf
  <div class="container">
    <span>Username:</span>
    <input id="username" type="text" name="new_username" autocomplete="off" maxlength="10" required>
    <span style="display: none" id="username_available">Username Available</span>
    <span style="display: none" id="username_taken" >Username Taken</span>

    <span>Name:</span>
    <input id="name" type="text" name="new_name" autocomplete="off" maxlength="20" required>
    <span>Password:</span>
    <input id="p1" type="password" name="new_password" maxlength="20" required>

    <span>Confirm Password:</span>
    <input id="p2" type="password" name="confirm_password" maxlength="20" required>
    <span style="display: none" id="password_error">Passwords do not match</span>

    <a id="submit_form"><i class="fas fa-user-circle"></i> Create Account</a>
    <a id="back_to_login" href="{{action("UsersController@login")}}"><i class="fas fa-undo-alt"></i> Back to Login</a>
  </div>
</form>
@endsection

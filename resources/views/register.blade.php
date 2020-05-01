@extends("layouts.login_register")

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
  if($("#p1").val() == $("#p2").val()){
    $("#login_form").submit();
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

#submit_form{
  margin-top: 10px;
  background-color: #1d9e16;
  cursor: pointer;
  font-size: 18pt;
}

#back_to_login{
  margin-top: 20px;
  background-color: #999999;
  cursor: pointer;
  text-decoration: none;
  text-align: center;
  font-size: 18pt;
  color: #000000;
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


</style>
@endsection

@section("content")
<form id="login_form" method="POST" action="{{action("UsersController@process_register")}}">
    @csrf
  <div class="container">
    <span>Username:</span>
    <input id="username" type="text" name="new_username" autocomplete="off" required>
    <span style="display: none" id="username_available">Username Available</span>
    <span style="display: none" id="username_taken" >Username Taken</span>

    <span>Name</span>
    <input type="text" name="new_name" autocomplete="off" required>
    <span>Password:</span>
    <input id="p1" type="password" name="new_password" required>

    <span>Confirm Password:</span>
    <input id="p2" type="password" name="confirm_password" required>
    <span style="display: none" id="password_error">Passwords do not match</span>

    <button type="button" id="submit_form">Create Account</button>
    <a id="back_to_login" href="{{action("UsersController@login")}}">Back to Login</a>
  </div>
</form>
@endsection

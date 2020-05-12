@extends("layouts.login_register")


@section('title')
  Login | Dai Di Online
@endsection

@section("javascript")

<script>

function check_form(){
  if(($("#username").val() != "") && ($("#password").val() != "")){
    //ASSERT: A username and password have been entered
    $("#login_form").submit();
  }
}

//prevent enter from submitting form
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      check_form();

    }
  });
});

$("#submit_form").on("click", function(){
  check_form();
});

</script>

@endsection

@section("css")
<style>

.title{
  font-size: 25pt;
  text-align: center;
  width: 100%
}

.container{
  display: grid;
  grid-gap: 10px;
  width: 100%;
  margin-top: 10px;
  font-family: verdana;
}

.input_box{
  outline: none;
  font-size: 18pt;
  width: 100%;
}

#create_account{
  text-decoration: none;
  color: rgb(20,119,235);
  text-align: center;
}

#create_account:hover{
  text-decoration: underline;
}

</style>
@endsection

@section("content")

<div class="title">
  Login
</div>

<form id="login_form" method="POST" action={{action("UsersController@process_login")}}>
  @csrf

  <div class="container">
    <span>Username:</span>
    <input id="username" class="input_box" type="text" name="username" autocomplete="off" autofocus="autofocus" onfocus="this.select()" required>
    <span>Password:</span>
    <input id="password" class="input_box" type="password" name="password" required>

    <a id="submit_form"><i class="fas fa-sign-in-alt"></i> Login</a>
    <a id="create_account" href="{{action("UsersController@register")}}">Create An Account</a>
  </div>
</form>

@endsection

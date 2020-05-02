@extends("layouts.login_register")


@section('title')
  Login | Dai Di Online
@endsection

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

$(".player_number_option").on("click", function(){
  $(".player_number_option").removeClass("selected");
  $(this).addClass("selected");

  $("#player_number").val($(this).html());
});

$("#submit_form").on("click", function(){
  $("#login_form").submit();
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
    <input class="input_box" type="text" name="username" autocomplete="off" required>
    <span>Password:</span>
    <input class="input_box" type="password" name="password" required>

    <a id="submit_form">Login</a>
    <a id="create_account" href="{{action("UsersController@register")}}">Create Account</a>
  </div>
</form>

@endsection

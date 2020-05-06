@extends("layouts.home_template")

@section("title")
  Profile
@endsection

@section("css")

<style>

.container{
  display: grid;
  grid-template-columns: auto auto 1fr;
  padding: 20px;
  grid-column-gap: 30px;
}

label{
  font-family: "Arial";
  font-size: 14pt;
  text-align: right;
}

.value{
  font-size: 14pt;
  font-weight: bold;
}

.change_button{
  text-align: left;
  padding-top: 0px;
}

.modal-body{
  display: grid;
  grid-template-columns: auto 1fr;
  grid-gap: 5px;
}



</style>

@endsection

@section("javascript")

<script>

$("#change_password_button").on("click", function(){
  var letters = /^[0-9a-zA-Z ]+$/;

  if($("#p1").val() == $("#p2").val()) {
    if($("#p1").val().match(letters)){
      $("#change_password_form").submit();
    }
    else{
      alert("Letters, numbers, and spaces only");
    }
  }
  else{
    alert("Passwords do not match");
  }
});

$("#change_name_button").on("click", function(){
  var letters = /^[0-9a-zA-Z ]+$/;

  if($("#new_name").val().match(letters)){
    $("#change_name_form").submit();
  }
  else{
    alert("Letters, numbers, and spaces only");
  }

});

</script>

@endsection

@section("content")

<div class="container">
  <label>Username:</label><span class="value">{{$data->username}}</span><div></div>
  <label>Name:</label><span class="value">{{$data->name}}</span><button class="btn btn-link change_button" data-toggle="modal" data-target="#change_name">Change Name</button>
  <label>Password:</label><span class="value">********</span><button class="btn btn-link change_button" data-toggle="modal" data-target="#change_password">Change Password</button>

</div>

<!--Change Password Modal-->
<form id="change_password_form" method="POST" action="{{action("UsersController@change_password")}}">
  @csrf
  <div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="change_password_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="change_password_label">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label>New Password:</label>
          <input id="p1" class="form-control" type="password" name="new_password">
          <label>Confirm Password:</label>
          <input id="p2" class="form-control" type="password">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="change_password_button" type="button" class="btn btn-primary">Change Password</button>
        </div>
      </div>
    </div>
  </div>
</form>


<!--Change Name Modal-->
<form id="change_name_form" method="POST" action="{{action("UsersController@change_name")}}">
  @csrf
  <div class="modal fade" id="change_name" tabindex="-1" role="dialog" aria-labelledby="change_name_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="change_name_label">Change Name</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label>Current Name:</label>
          <input class="form-control" type="text"  value="{{$data->name}}" disabled>
          <label>New Name:</label>
          <input id="new_name" class="form-control" name="new_name" type="text" autocomplete="off">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="change_name_button" type="button" class="btn btn-primary">Change Name</button>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection

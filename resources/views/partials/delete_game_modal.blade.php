<form method="POST" action="{{action("Big2Controller@delete_game")}}">
@csrf
<div class="modal fade" id="delete_game" tabindex="-1" role="dialog" aria-labelledby="delete_game_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delete_game_label">Delete Game</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <input type="hidden" id="delete_game_id" name="id">
          Are you sure you want to delete the game: <strong><span id="delete_game_name"></span></strong>?
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-danger" value="Delete">
      </div>
    </div>
  </div>
</div>
</form>

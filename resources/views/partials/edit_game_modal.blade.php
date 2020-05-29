<form method="POST" action="{{action("Big2Controller@edit_game")}}">
@csrf
<div class="modal fade" id="edit_game" tabindex="-1" role="dialog" aria-labelledby="edit_game_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit_game_label">Edit Game: <span id="edit_game_name"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="form-check">
            <input type="hidden" id="edit_game_id" name="id">
            <label class="scoring_box">Use Cumulative Scoring
              <input type="checkbox" id="cumulative_scoring" name="cumulative_scoring" value="true">
              <span class="checkmark"></span>
            </label>
          </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-primary" value="Save changes">
      </div>
    </div>
  </div>
</div>
</form>

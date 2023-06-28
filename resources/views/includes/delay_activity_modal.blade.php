<div class="modal fade" id="myDelayModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reason for delay</h4>
        </div>
        <div class="modal-body">
          <textarea class="form-control" id="delay-msg"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" onclick="finishWithDelay('{{ $task_details->id }}')">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
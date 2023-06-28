<div class="modal fade" id="myReopenModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Re-open Task</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
                <label>Start date</label>
                <input type="datetime-local" class="form-control" id="start_date" value="{{ $task_details->start_date }}">
            </div>
            <div class="col-md-6">
                <label>End date</label>
                <input type="datetime-local" class="form-control" id="end_date" value="{{ $task_details->end_date }}">
            </div>
            <div class="col-md-12">
                <label>Re-open description</label>
                <textarea class="form-control" id="reopen-des"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" onclick="reopenTask('{{ $task_details->id }}')">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
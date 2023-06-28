@extends('./layout/main')
@section('content')
<style>
    .note-editor .note-editable{
        height: 233px;
    }
</style>
<div class="page-title">
    <h3 class="breadcrumb-header">Assign Task</h3>
</div> 
@can('task-list')

    <div class="panel panel-white" style="margin-top: 8px;padding: 16px;margin-left: 9px;margin-right: 9px;">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Start Date</label>
                    <input type="date" id="start_date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>End Date</label>
                    <input type="date" id="end_date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Status</label>
                    <select name="status" id="status" class="selct2-ajax form-control" style="width: 100%">
                        <option value="">Select</option>
                        <option value="0">Not Started</option>
                        <option value="1">On-going</option>
                        <option value="2">Re-open</option>
                        <option value="3">Under Review</option>
                        <option value="4">Complete</option>
                    </select>
                </div>
            </div>
            <div class="space-button">
                <button type="button" class="btn btn-primary space-button" onclick="taskAssignList()"><span class="icon-magnifier"></span> Search</button>
                <button type="button" class="btn btn-warning space-button" onclick="return window.location.reload()"><span class="icon-reload"></span> Reset</button>
            </div>
        </div>
    </div><!-- Row -->

@endcan

<div class="panel panel-white" id="accordion2" style="margin-left: 9px;margin-right: 9px;">
    <div class="panel-heading clearfix label-primary">
        <a data-toggle="collapse" data-parent="#accordion2" href="#task-list" aria-expanded="true" aria-controls="collapseOne" style="color: white;text-decoration:none">
            Tasks List
        </a>
        {{-- <h3 class="panel-title" style="color: white">Tasks List</h3> --}}
    </div>
    <div class="panel-body collapse in" id="task-list">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#main-wrapper-ajax" role="tab" data-toggle="tab"><strong>@if(in_array(Auth::user()->role_id,[1,2]))Task @else My Task @endif</strong></a></li>
                <li role="presentation"><a href="#tab22" role="tab" data-toggle="tab"><strong>Team Task</strong></a></li>
                <li role="presentation"><a href="#tab23" role="tab" data-toggle="tab"><strong>Observer Task</strong></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active fade in" id="main-wrapper-ajax">
                    
                       
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab22">
                    
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab23">
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    taskAssignList();
    $('.select2-ajax').select2({});
});
function taskAssignList()
{
    var url = '{{ route("task-assign-list-ajax") }}';
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var status = $('#status').val();

    $.ajax({
        url:url,
        type:'GET',
        data:{"_token":"{{ csrf_token() }}","start_date":start_date,"end_date":end_date,"status":status},
        dataType:"JSON",
        success:function(res)
        {
            $('#main-wrapper-ajax').html(res);
        }
    });
    taskObserveList();
}
function taskObserveList()
{
    var url = '{{ route("task-observe-list-ajax") }}';
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var status = $('#status').val();

    $.ajax({
        url:url,
        type:'GET',
        data:{"_token":"{{ csrf_token() }}","start_date":start_date,"end_date":end_date,"status":status},
        dataType:"JSON",
        success:function(res)
        {
            $('#tab23').html(res);
        }
    });
    taskTeamList();
}
function taskTeamList()
{
    var url = '{{ route("task-team-list-ajax") }}';
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var status = $('#status').val();

    $.ajax({
        url:url,
        type:'GET',
        data:{"_token":"{{ csrf_token() }}","start_date":start_date,"end_date":end_date,"status":status},
        dataType:"JSON",
        success:function(res)
        {
            $('#tab22').html(res);
        }
    });
}
</script>
@endsection
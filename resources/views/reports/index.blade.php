@extends('./layout/main')
@section('content')
@php
 $departments = getTableAll('departments',[['id','!=',7]]);
 if(!in_array(Auth::user()->dept_id,[7]))
 {
    $users = getTableAll('users',[['dept_id','!=',7],['is_deleted',0],['id',Auth::user()->id]]);
 } else{
    $users = getTableAll('users',[['dept_id','!=',7],['is_deleted',0]]);
 }
@endphp
<div class="panel panel-white" style="margin-top: 8px;padding: 16px;margin-left: 9px;margin-right: 9px;">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <label>Start Date</label>
                <input type="date" id="start_date" class="form-control" value="{{ @$start_date }}">
            </div>
            <div class="col-md-4">
                <label>End Date</label>
                <input type="date" id="end_date" class="form-control" value="{{ @$end_date }}">
            </div>
            <div class="col-md-4">
                <label>Status</label>
                <select name="status" id="status" class="select2 form-control" style="width: 100%">
                    <option value="">Select</option>
                    <option value="0" @if(!empty($status) && $status == 0) selected @endif>Not Started</option>
                    <option value="1" @if(!empty($status) && $status == 1) selected @endif>On-going</option>
                    <option value="2" @if(!empty($status) && $status == 2) selected @endif>Re-open</option>
                    <option value="3" @if(!empty($status) && $status == 3) selected @endif>Under Review</option>
                    <option value="4" @if(!empty($status) && $status == 4) selected @endif>Complete</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Users</label>
                <select name="user_id" id="user_id" class="select2 form-control" style="width: 100%">
                    <option value="">Select</option>
                    @if(!empty($users))
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if(!empty($user_id) && $user_id == $user->id) selected @endif>{{ getUserName($user->id) }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label>Departments</label>
                <select name="dept_id" id="dept_id" class="select2 form-control" style="width: 100%" onchange="getSubDepartments(this.value)">
                    <option value="">Select</option>
                    @if(!empty($departments))
                    @foreach ($departments as $item)
                        <option value="{{ $item->id }}" @if(!empty($dept_id) && $dept_id == $item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label>Sub Departments</label>
                <select name="sub_dept_id" id="sub_dept_id" class="select2 form-control" style="width: 100%">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Participants Start Date</label>
                <input type="date" id="task_start_date" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Participants End Date</label>
                <input type="date" id="task_end_date" class="form-control">
            </div>
        </div>
        <div class="space-button">
            <button type="button" class="btn btn-primary space-button" onclick="reportList()"><span class="icon-magnifier"></span> Search</button>
            <button type="button" class="btn btn-warning space-button" onclick="return window.location.reload()"><span class="icon-reload"></span> Reset</button>

        </div>
    </div>
</div><!-- Row -->

<div class="panel panel-white" id="accordion2" style="margin-left: 9px;margin-right: 9px;">
    <div class="panel-heading clearfix label-primary">
        <a data-toggle="collapse" data-parent="#accordion2" href="#task-list" aria-expanded="true" aria-controls="collapseOne" style="color: white;text-decoration:none">
           Task Report List
        </a>
        <div class="text-right" style="display:inline-flex;float: right;">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Reload" style="color:white;text-decoration:none" onclick="reportList()"><i class="icon-reload"></i></a>
        </div>
        {{-- <h3 class="panel-title" style="color: white">Tasks List</h3> --}}
    </div>

    <div class="panel-body collapse in" id="task-list">

        <div role="tabpanel" id="report-list">

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    reportList();
});
function reportList()
{
    var data = {};
    data['start_date'] = $('#start_date').val();
    data['end_date'] = $('#end_date').val();
    data['status'] = $('#status').val();
    data['user_id'] = $('#user_id').val();
    data['dept_id'] = $('#dept_id').val();
    data['sub_dept_id'] = $('#sub_dept_id').val();
    data['task_start_date'] = $('#task_start_date').val();
    data['task_end_date'] = $('#task_end_date').val();

    var url = "{{ route('reports-list') }}";

    $.ajax({
        url:url,
        type:'GET',
        data:{"_token":"{{ csrf_token() }}",...data},
        dataType:"JSON",
        success:function(res)
        {
            $('#report-list').html(res);
        }
    })
}
</script>
@endsection

@extends('../layout/main')
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
        </div>
        <div class="space-button">
            <button type="button" class="btn btn-primary space-button" onclick="otherReportList()"><span class="icon-magnifier"></span> Search</button>
            <button type="button" class="btn btn-warning space-button" onclick="return window.location.reload()"><span class="icon-reload"></span> Reset</button>

        </div>
    </div>
</div><!-- Row -->

<div class="panel panel-white" id="accordion2" style="margin-left: 9px;margin-right: 9px;">
    <div class="panel-heading clearfix label-primary">
        <a data-toggle="collapse" data-parent="#accordion2" href="#other-list" aria-expanded="true" aria-controls="collapseOne" style="color: white;text-decoration:none">
            Other Report List
        </a>
        <div class="text-right" style="display:inline-flex;float: right;">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Reload" style="color:white;text-decoration:none" onclick="otherReportList()"><i class="icon-reload"></i></a>
        </div>
        {{-- <h3 class="panel-title" style="color: white">Tasks List</h3> --}}
    </div>

    <div class="panel-body collapse in" id="other-list">

        <div role="tabpanel" id="other-wise-report-list">

        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    otherReportList();
});
</script>
@endsection


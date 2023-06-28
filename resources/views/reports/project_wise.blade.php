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
                <label>Estimate Start Date</label>
                <input type="date" id="start_date" class="form-control" value="{{ @$start_date }}">
            </div>
            <div class="col-md-4">
                <label>Estimate End Date</label>
                <input type="date" id="end_date" class="form-control" value="{{ @$end_date }}">
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
        </div>
        <div class="space-button">
            <button type="button" class="btn btn-primary space-button" onclick="projectReportList()"><span class="icon-magnifier"></span> Search</button>
            <button type="button" class="btn btn-warning space-button" onclick="return window.location.reload()"><span class="icon-reload"></span> Reset</button>

        </div>
    </div>
</div><!-- Row -->

<div class="panel panel-white" id="accordion2" style="margin-left: 9px;margin-right: 9px;">
    <div class="panel-heading clearfix label-primary">
        <a data-toggle="collapse" data-parent="#accordion2" href="#project-list" aria-expanded="true" aria-controls="collapseOne" style="color: white;text-decoration:none">
            Project Wise Report List
        </a>
        <div class="text-right" style="display:inline-flex;float: right;">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Reload" style="color:white;text-decoration:none" onclick="projectReportList()"><i class="icon-reload"></i></a>
        </div>
        {{-- <h3 class="panel-title" style="color: white">Tasks List</h3> --}}
    </div>

    <div class="panel-body collapse in" id="project-list">

        <div role="tabpanel" id="project-wise-report-list">

        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    projectReportList();
});
</script>
@endsection


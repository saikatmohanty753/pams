@extends('./layout/main')
@section('content')
<style>
    .note-editable{
        height: 233px;
    }
</style>
@php
  $status = array('1' => 'Active', '2'=>'In-Active');  
  $departments = getTableAll('departments',[['is_active',1],['id','!=',7]]);
  $subdepartments = getTableAll('sub_departments',[['is_active',1],['dept_id',3]]);
  $sub_dept_arr = getSubDeptArr($projects->id,3);
  $dept_arr = getDeptArr($projects->id);
  //dd($sub_dept_arr);
@endphp
<div class="page-title">
    <h3 class="breadcrumb-header"> Projects</h3>
</div> 

@can('project-edit')
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('update-project') }}" onsubmit="return beforeSubmitProject()">
                @csrf
                <input type="hidden" name="id" value="{{ @$projects->id }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Project Name <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter project name" autocomplete="off" value="{{ @$projects->name }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="estimate_start_date">Estimate Start Date <span style="color: red">*</span></label>
                        <input type="date" class="form-control" name="estimate_start_date" id="estimate_start_date" placeholder="Enter project name" autocomplete="off" value="{{ @$projects->estimate_start_date }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="estimate_end_date">Estimate End Date <span style="color: red">*</span></label>
                        <input type="date" class="form-control" name="estimate_end_date" id="estimate_end_date" placeholder="Enter project name" autocomplete="off" value="{{ @$projects->estimate_end_date }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="actual_start_date">Actual Start Date</label>
                        <input type="date" class="form-control" name="actual_start_date" id="actual_start_date" placeholder="Enter project name" autocomplete="off" value="{{ @$projects->actual_start_date }}">
                    </div>
                    <div class="col-md-4">
                        <label for="actual_end_date">Actual End Date</label>
                        <input type="date" class="form-control" name="actual_end_date" id="actual_end_date" placeholder="Enter project name" autocomplete="off" value="{{ @$projects->actual_end_date }}">
                    </div>
                    <div class="col-md-4">
                        <label for="is_active">Status <span style="color: red">*</span></label>
                        <select name="is_active" id="is_active" class="form-control select2" required>
                            <option value=""> --Select-- </option>
                            <option value="1" @if(!empty($projects->is_active) && $projects->is_active == 1) selected @endif>Active</option>
                            <option value="2" @if(!empty($projects->is_active) && $projects->is_active == 2) selected @endif>In-Active</option>
                        </select>
                    </div>
                    <div class="col-md-12 space-button" style="padding-top:20px">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo" class="btn btn-primary" style="width: 100%;text-align:left"><h4>Choose Department (Default All the departments are assigned)</h4></a>
                        <div class="panel panel-white collapse in" id="demo">
                            <div class="panel-body">
                                <div class="depart">
                                    @if(!empty($departments))
                                    @foreach($departments as $department)
                                    <input type="checkbox" class="form-control checkbox-class" name="dept_id[]" value="{{ $department->id }}" onclick="showProduction(this.value)" @if(!empty($dept_arr) && in_array($department->id,$dept_arr)) checked @endif> {{ $department->name }} &nbsp;
                                    @endforeach
                                    <div id="sub_dept_div" style="padding-top:12px">
                                        <select class="select2 form-control sub-dept-class" name="sub_department[]" id="sub_department" style="width: 100%" placeholder="Select Sub Department" multiple>
                                            @if(!empty($subdepartments))
                                            @foreach($subdepartments as $sub_dept)
                                                <option value="{{ $sub_dept->id.'@@'.$sub_dept->dept_id }}" @if(!empty($sub_dept) && in_array($sub_dept->id.'@@'.$sub_dept->dept_id, $sub_dept_arr)) selected @endif>{{ $sub_dept->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea name="description" class="summernote">{{ @$projects->description }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary m-t-xs m-b-xs">Submit</button>
            </form>
        </div>
    </div><!-- Row -->
</div>
@endcan

@endsection
@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header">Add Reporting Designation</h3>
</div>
@php
    $status = array('1' => 'Active', '2'=>'In-Active'); 
    $departments = getTableAll('departments',['is_active'=>1]);
    $designations = getTableAll('designations',['is_active'=>1]);
@endphp
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('save-report') }}" class="formSave">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="dept_id">Department <span style="color: red">*</span></label>
                        <select name="dept_id" id="dept_id" class="form-control select2" required>
                            <option value="">Select</option>
                            @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="desig_id">Designation <span style="color: red">*</span></label>
                        <select name="desig_id" id="desig_id" class="form-control select2" required>
                            <option value="">Select</option>
                            @if(isset($designations) && count($designations) > 0)
                            @foreach($designations as $designation)
                            <option value="{{ $designation->id }}" >{{ $designation->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="reporting_id">Reporting Designation <span style="color: red">*</span></label>
                        <select name="reporting_id" id="reporting_id" class="form-control select2" required>
                            <option value="">Select</option>
                            @if(isset($designations) && count($designations) > 0)
                            @foreach($designations as $designation)
                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="is_active">Status <span style="color: red">*</span></label>
                        <select name="is_active" id="is_active" class="form-control select2" required>
                            <option value=""> --Select-- </option>
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary m-t-xs m-b-xs">Submit</button>
            </form>
        </div>
    </div><!-- Row -->
</div>
@php
 $report_lists = getTableAll('reporting_desig_details',[['is_active',1]]);
 $deginationList = getPluck('designations',['is_active'=>1],'id','name');
 $departmentsList = getPluck('departments',['is_active'=>1],'id','name');
@endphp
<div class="panel panel-white">
    <div class="panel-body">
        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne1">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#user-list" aria-expanded="true" aria-controls="collapseOne">
                            Reporting designation List
                        </a>
                    </h4>
                </div>
                <div id="user-list" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne1">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="datatable table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Reporting Designation</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($report_lists) && count($report_lists) > 0)
                                    @foreach($report_lists as $reportListKey=>$report_list)
                                    <tr>
                                        <td>{{ $reportListKey+1 }}</td>
                                        <td>{{ (!empty($report_list->dept_id))?$departmentsList[$report_list->dept_id]:'' }}</td>
                                        <td>{{ (!empty($report_list->desig_id))?$deginationList[$report_list->desig_id]:'' }}</td>
                                        <td>{{ (!empty($report_list->reporting_id))?$deginationList[$report_list->reporting_id]:'' }}</td>
                                        <td>{{ $status[$report_list->is_active] }}</td>
                                        <td>
                                            <a href="{{ route('edit-report',[encrypt($report_list->id)])}}" class="btn btn-rss m-b-xs" title="Edit"><span class="icon-note"></span> Edit</a>
                                            <a href="{{ route('delete-report',[encrypt($report_list->id)])}}" class="btn btn-danger m-b-xs" title="Delete" onclick="return confirm('Are you sure ?')"><span class="icon-trash"></span> Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
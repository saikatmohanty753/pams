@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header">Add Role</h3>
</div> 
@php
$departments = getTableAll('departments',['is_active'=>1]);
@endphp
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body">
            @if(!empty($roles->id))
            <form method="POST" enctype="multipart/form-data" action="{{ route('update-role') }}">
            @else
            <form method="POST" enctype="multipart/form-data" action="{{ route('save-role') }}">
                @endif
                @csrf
                <input type="hidden" name="id" value="{{ @$roles->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Role Name <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter role name" autocomplete="off" value="{{ @$roles->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dept_id">Department <span style="color: red">*</span></label>
                        <select name="dept_id" id="dept_id" class="form-control select2" required>
                            <option value="">Select</option>
                            @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" @if(!empty($roles->dept_id) && $roles->dept_id == $department->id) selected @endif>{{ $department->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary m-t-xs m-b-xs" style="margin-top: 24px">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- Row -->
</div>
@php
    $rolesdata = getTableAll('roles');
    $departmentsList = getPluck('departments',['is_active'=>1],'id','name');
@endphp
<div class="panel panel-white">
    <div class="panel-body">
        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne1">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#user-list" aria-expanded="true" aria-controls="collapseOne">
                            Roles List
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
                                        <th>Role Name</th>
                                        <th>Department</th>
                                        <th>Created on</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($rolesdata) && count($rolesdata) > 0)
                                    @foreach($rolesdata as $rolesdataKey=>$role)
                                    <tr>
                                        <td>{{ $rolesdataKey+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ (!empty($role->dept_id))?$departmentsList[$role->dept_id]:'' }}</td>
                                        <td>{{ date('d-m-Y',strtotime($role->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('edit-role',[encrypt($role->id)])}}" class="btn btn-rss m-b-xs" title="Edit"><span class="icon-note"></span> Edit</a>
                                            {{-- <a href="{{ route('delete-role',[encrypt($role->id)])}}" class="btn btn-danger m-b-xs" title="Delete" onclick="return confirm('Are you sure ?')"><span class="icon-trash"></span> Delete</a> --}}
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
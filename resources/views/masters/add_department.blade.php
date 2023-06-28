@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header"> Department</h3>
</div> 
@can('master-create') 
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body"> 
            <form method="POST" enctype="multipart/form-data" action="{{ route('save-department') }}" class="formSave">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Department Name <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter department name" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="is_active">Status <span style="color: red">*</span></label>
                        <select name="is_active" id="is_active" class="form-control select2" required>
                            <option value=""> --Select-- </option>
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
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
@endcan
@php
    $departmentdata = getTableAll('departments');
@endphp

@can('master-list')
<div class="panel panel-white">
    <div class="panel-body">
        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne1">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#user-list" aria-expanded="true" aria-controls="collapseOne">
                            Department List
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
                                        <th>Department Name</th>
                                        <th>Created on</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($departmentdata) && count($departmentdata) > 0)
                                    @foreach($departmentdata as $departmentdataKey=>$department)
                                    <tr>
                                        <td>{{ $departmentdataKey+1 }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>{{ date('d-m-Y',strtotime($department->created_at)) }}</td>
                                        <td>
                                            @can('master-edit')
                                            <a href="{{ route('edit-department',[encrypt($department->id)])}}" class="btn btn-rss m-b-xs" title="Edit"><span class="icon-note"></span> Edit</a>
                                            @endcan
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
@endcan
@endsection
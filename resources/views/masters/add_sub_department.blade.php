@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header"> Department</h3>
</div> 
@can('master-create') 
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body"> 
            <form method="POST" enctype="multipart/form-data" action="{{ route('save-sub-department') }}" class="formSave">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Department <span style="color: red">*</span></label>
                        <select name="dept_id" id="dept_id" class="form-control select2">
                            <option value="">Select</option>
                            @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $depart)
                            <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="name">Sub Department <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter department name" autocomplete="off" required>
                    </div>
                    <div class="col-md-4">
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

@include('./masters/sub_department_list')
@endsection
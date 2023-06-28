@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header"> Department</h3>
</div> 
@can('master-create') 
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body"> 
            <form method="POST" enctype="multipart/form-data" action="{{ route('update-sub-department') }}" class="formSave">
                @csrf
                <input type="hidden" name="id" value="{{ @$sub_department->id }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="dept_id">Department <span style="color: red">*</span></label>
                        <select name="dept_id" id="dept_id" class="form-control select2">
                            <option value="">Select</option>
                            @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $depart)
                            <option value="{{ $depart->id }}" @if(!empty($sub_department->dept_id) && $sub_department->dept_id == $depart->id) selected @endif>{{ $depart->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="name">Sub Department <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter department name" autocomplete="off" value="{{ $sub_department->name }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="is_active">Status <span style="color: red">*</span></label>
                        <select name="is_active" id="is_active" class="form-control select2" required>
                            <option value=""> --Select-- </option>
                            <option value="1" @if(!empty($sub_department->is_active) && $sub_department->is_active == 1) selected @endif>Active</option>
                            <option value="2" @if(!empty($sub_department->is_active) && $sub_department->is_active == 2) selected @endif>In-Active</option>
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


@include('./masters/sub_department_list')
@endsection
@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header"> Designations</h3>
</div> 
@can('master-create') 
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body"> 
            <form method="POST" enctype="multipart/form-data" action="{{ route('save-designation') }}" class="formSave">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Designation <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter designation " autocomplete="off" required>
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

@include('./masters/designation_list')

@endsection
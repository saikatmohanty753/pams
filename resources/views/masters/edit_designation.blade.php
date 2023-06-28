@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header"> Designations</h3>
</div> 
@can('master-edit') 
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body"> 
            <form method="POST" enctype="multipart/form-data" action="{{ route('update-designation') }}" class="formSave">
                @csrf
                <input type="hidden" name="id" value="{{ @$designations->id }}" >
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Designations <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter designation name" autocomplete="off" value="{{ @$designations->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="is_active">Status <span style="color: red">*</span></label>
                        <select name="is_active" id="is_active" class="form-control select2" required>
                            <option value=""> --Select-- </option>
                            <option value="1" @if(!empty($designations->is_active) && $designations->is_active == 1) selected @endif>Active</option>
                            <option value="2" @if(!empty($designations->is_active) && $designations->is_active == 2) selected @endif>In-Active</option>
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
@extends('./layout/main')
@section('content')
<div class="page-title">
    <h3 class="breadcrumb-header">Role Permission ({{$roles->name}})</h3>
</div> 
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body">  
            <div class="row">
                <div class="col-xl-12">
                    <form method="POST" action="{{ route('update-role') }}" class="formSave">
                    @csrf
                    <input type="hidden" name="id" value="{{ $roles->id }}">
                    <div class="panel-body">
                        <div class="form-group col-md-6">
                            <label for="inputRole" class="col-sm-4 form-label">Role Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter New Role Name" value="{{$roles->name}}">
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
                        <table class="table table-bordered">
                            <tr>
                                <th>Module</th>
                                <th>List</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @foreach ($permission->chunk(5) as $chunk)
                            <tr>
                                @foreach ( $chunk as $key => $value)
                                <td><input type="checkbox" id="md_checkbox_{{$key}}" class="filled-in chk-col-primary"
                                        value="{{$value->id}}" name="permission[]" {{in_array($value->id, $rolePermissions) ?
                                    'checked' : ''}}>
                                    <label for="md_checkbox_{{$key}}">{{ ($key % 5 == 0) ? $value->name : '' }}</label>
                                </td>
                                @endforeach
                            </tr>
        
                            @endforeach
        
                        </table>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary float-end mb-4">Submit</button>
                            <button type="button" onclick="history.back()" class="btn btn-warning float-end mb-4">Back</button>   
                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div><!-- Row -->
</div>
@endsection
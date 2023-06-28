@extends('./layout/main')
@section('content')
@php
  $status = array('1' => 'Active', '2'=>'In-Active');  
  $tiers = array('1' => 'Tier - 1', '2'=>'Tier - 2','3'=>'Tier - 3');
@endphp
<div class="page-title">
    <h3 class="breadcrumb-header">Add User</h3>
</div>
@php
    $departments = getTableAll('departments',['is_active'=>1]);
    $designations = getTableAll('designations',['is_active'=>1]);
    $subdepartments = getTableAll('sub_departments',[['is_active',1],['dept_id',3]]);
@endphp


@can('user-edit')

<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('update-user') }}" class="formSave">
                @csrf
                <input type="hidden" name="id" value="{{ @$usersdata->id }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="first_name">First Name <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name" autocomplete="off" value="{{ @$usersdata->first_name }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="last_name">Last Name <span style="color: red">*</span></label>
                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter last name" autocomplete="off" value="{{ @$usersdata->last_name }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="emp_code">Employee Code <span style="color: red">*</span></label>
                        <input type="text" name="emp_code" value="{{ @$usersdata->emp_code }}" class="form-control" id="emp_code" placeholder="Enter employee code" autocomplete="off" required>
                    </div>
                    <div class="col-md-3">
                        <label for="dept_id">Department <span style="color: red">*</span></label>
                        <select name="dept_id" id="dept_id" class="form-control select2" onchange="getRole()" required>
                            <option value="">Select</option>
                            @if(isset($departments) && count($departments) > 0)
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" @if(!empty($usersdata->dept_id) && $usersdata->dept_id == $department->id) selected @endif>{{ $department->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="dob">Birthday date <span style="color: red">*</span></label>
                        <input type="date" name="dob" value="{{ @$usersdata->dob }}" class="form-control" id="dob" autocomplete="off" required>
                    </div>
                    <div class="col-md-3">
                        <label for="desig_id">Designation <span style="color: red">*</span></label>
                        <select name="desig_id" id="desig_id" class="form-control select2" required>
                            <option value="">Select</option>
                            @if(isset($designations) && count($designations) > 0)
                            @foreach($designations as $designation)
                            <option value="{{ $designation->id }}" @if(!empty($usersdata->desig_id) && $usersdata->desig_id == $designation->id) selected @endif>{{ $designation->name }}</option>
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
                            <option value="{{ $designation->id }}" @if(!empty($usersdata->reporting_id) && $usersdata->reporting_id == $designation->id) selected @endif>{{ $designation->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="role_id">Role <span style="color: red">*</span></label>
                        <select name="role_id" id="role_id" class="form-control select2" required>
                            <option value="">Select</option>
                            @if(!empty($usersdata->role_id))
                                @php
                                    $roles = getTableAll('roles',['dept_id'=>$usersdata->dept_id]);
                                @endphp
                                @if(isset($roles) && count($roles) > 0)
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @if(!empty($usersdata->role_id) && $usersdata->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                    </div>   
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="email">Email <span style="color: red">*</span></label>
                        <input type="email" name="email" value="{{ @$usersdata->email }}" class="form-control" id="email" placeholder="Enter email" autocomplete="off" required>
                    </div>
                    <div class="col-md-3">
                        <label for="mobile_no">Mobile number <span style="color: red">*</span></label>
                        <input type="text" name="mobile_no" class="form-control numbers" id="mobile_no" placeholder="Enter mobile number" maxlength="10" autocomplete="off" value="{{ @$usersdata->mobile_no }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="alt_mobile_no">Alternate Mobile Number</label>
                        <input type="text" name="alt_mobile_no" class="form-control numbers" id="alt_mobile_no" maxlength="10" placeholder="Enter alternate mobile number" value="{{ @$usersdata->alt_mobile_no }}" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for="tier_user">Tier User <span style="color: red">*</span></label>
                        <select name="tier_user" id="tier_user" class="form-control select2" onchange="getRole()" required>
                            <option value=""> --Select-- </option>
                            @foreach($tiers as $tierKey=>$tier)
                            <option value="{{ $tierKey }}" @if(!empty($usersdata->tier_user) && $usersdata->tier_user == $tierKey) selected @endif> {{ $tier }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3" @if(empty($usersdata->sub_dept_id)) style="display: none" @endif id="sub_dept_id_div">
                        <label for="dept_id">Sub Department <span style="color: red">*</span></label>
                        <select name="sub_dept_id" id="sub_dept_id" style="width:100%" class="form-control select2">
                            <option value="">Select</option>
                            @if(isset($subdepartments) && count($subdepartments) > 0)
                                @foreach($subdepartments as $subdepartment)
                                <option value="{{ $subdepartment->id }}" @if(!empty($usersdata->sub_dept_id) && $usersdata->sub_dept_id == $subdepartment->id) selected @endif>{{ $subdepartment->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="is_active">Status <span style="color: red">*</span></label>
                        <select name="is_active" id="is_active" class="form-control select2" required>
                            <option value=""> --Select-- </option>
                            <option value="1" @if(!empty($usersdata->is_active) && $usersdata->is_active == 1) selected @endif>Active</option>
                            <option value="2" @if(!empty($usersdata->is_active) && $usersdata->is_active == 2) selected @endif>In-Active</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary m-t-xs m-b-xs">Submit</button>
            </form>
        </div>
    </div><!-- Row -->
</div>
@endcan

@include('./masters/user_list')

@endsection
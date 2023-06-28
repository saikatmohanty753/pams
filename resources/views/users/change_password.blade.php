@extends('./layout/main')
@section('content')
<style>
.Short {  
    width: 100%;  
    background-color: #dc3545;  
    margin-top: 5px;  
    height: 3px;  
    color: #dc3545;  
    font-weight: 500;  
    font-size: 12px;  
}  
.Weak {  
    width: 100%;  
    background-color: #ffc107;  
    margin-top: 5px;  
    height: 3px;  
    color: #ffc107;  
    font-weight: 500;  
    font-size: 12px;  
}  
.Good {  
    width: 100%;  
    background-color: #28a745;  
    margin-top: 5px;  
    height: 3px;  
    color: #28a745;  
    font-weight: 500;  
    font-size: 12px;  
}  
.Strong {  
    width: 100%;  
    background-color: #d39e00;  
    margin-top: 5px;  
    height: 3px;  
    color: #d39e00;  
    font-weight: 500;  
    font-size: 12px;  
}
</style>
<div class="page-title">
    <h3 class="breadcrumb-header">Add Project</h3>
</div>
<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body">
            <form method="POST" id="form-save" action="{{ route('update-change-password') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="old_password">Old Password</label>
                        <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" autocomplete="off" required>
                    </div>
                    <div class="col-md-4">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" autocomplete="off" onkeyup="changePassword()"  required>
                        <span id="newpasswordMsg" style="display: inline-block"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" autocomplete="off" onkeyup="changePassword()" required>
                        <span id="confirmpasswordMsg" style="display: inline-block"></span>
                    </div>
                </div>
                <button type="button" onclick="updatePassword()" class="btn btn-primary m-t-xs m-b-xs">Submit</button>
            </form>
        </div>
    </div><!-- Row -->
</div>
@endsection
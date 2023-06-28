@php
 $users = getTableAll('users',[['is_deleted',0],['role_id','!=',1]]);
 $deginationList = getPluck('designations',['is_active'=>1],'id','name');
 $departmentList = getPluck('departments',['is_active'=>1],'id','name');
@endphp
@can('user-list')
<div class="panel panel-white">
    <div class="panel-body">
        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne1">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#user-list" aria-expanded="true" aria-controls="collapseOne">
                            User List
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
                                        <th>Name</th>
                                        <th>Employee Code</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Reporting Designation</th>
                                        <th>User Tier</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($users) && count($users) > 0)
                                    @foreach($users as $userKey=>$user)
                                    <tr>
                                        <td>{{ $userKey+1 }}</td>
                                        <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                        <td>{{ $user->emp_code }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $departmentList[$user->dept_id] }}</td>
                                        <td>{{ (!empty($user->desig_id))?$deginationList[$user->desig_id]:'' }}</td>
                                        <td>{{ (!empty($user->reporting_id))?$deginationList[$user->reporting_id]:'' }}</td>
                                        <td>{{ tierStatus($user->tier_user) }}</td>
                                        <td>{{ $status[$user->is_active] }}</td>
                                        <td>
                                            @can('user-edit')
                                            <a href="{{ route('edit-user',[encrypt($user->id)])}}" class="btn btn-rss m-b-xs space-button" title="Edit"><span class="icon-note"></span> Edit</a>
                                            @endcan

                                            @can('user-delete')
                                            <a href="{{ route('delete-user',[encrypt($user->id)])}}" class="btn btn-danger m-b-xs space-button" title="Edit" onclick="return confirm('Are you sure ?')"><span class="icon-trash"></span> Delete</a>
                                            @endcan

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
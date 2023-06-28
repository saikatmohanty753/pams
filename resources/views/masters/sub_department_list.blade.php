@can('master-list')
@php
    $subdepartmentdata = getTableAll('sub_departments');
    $departments = getPluck('departments',[],'id','name');
@endphp
<div class="panel panel-white">
    <div class="panel-body">
        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne1">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#user-list" aria-expanded="true" aria-controls="collapseOne">
                           Sub Department List
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
                                        <th>Department </th>
                                        <th>Sub Department</th>
                                        <th>Status</th>
                                        <th>Created on</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($subdepartmentdata) && count($subdepartmentdata) > 0)
                                    @foreach($subdepartmentdata as $subdepartmentdataKey=>$department)
                                    <tr>
                                        <td>{{ $subdepartmentdataKey+1 }}</td>
                                        <td>{{ $departments[$department->dept_id] }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>{{ getStatus($department->is_active) }}</td>
                                        <td>{{ date('d-m-Y',strtotime($department->created_at)) }}</td>
                                        <td>
                                            @can('master-edit')
                                            <a href="{{ route('edit-sub-department',[encrypt($department->id)])}}" class="btn btn-rss m-b-xs" title="Edit"><span class="icon-note"></span> Edit</a>
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
@extends('./layout/main')
@section('content')
@php
    //$projectsdata = getTableAll('project_masters',[['is_deleted',0]]);
    //$departments = getTableAll('departments',['is_active'=>1]);
    $task_status = array(1=>'Started',2=>'Re-open', 3=> 'Under Review', 4=>'Complete','0'=>'Not Started');
    $badge_status = array(1=>'primary',2=>'info', 3=> 'danger', 4=>'success','0'=>'secondary');
    $blink_status = array(1=>'',2=>'blink_me', 3=> 'blink_me', 4=>'','0'=>'');
    $status = array('1' => 'Active', '2'=>'In-Active');
    $departments = getTableAll('departments',[['is_active',1],['id','!=',7]]);
    $subdepartments = getTableAll('sub_departments',[['is_active',1],['dept_id',3]]);

@endphp
@can('project-list')
<div class="panel panel-white">
    <div class="panel-body">
        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne1">
                    <div style="display: inline">
                        <h4 class="panel-title" >
                            <a data-toggle="collapse" data-parent="#accordion2" href="#user-list" aria-expanded="true" aria-controls="collapseOne">
                                Project List
                            </a>
                        </h4>
                        <a href="{{ route('add-project') }}" class="btn btn-success" style="float:right;margin-top: -23px;" title="Add Project"><span class="icon-plus"></span></a>
                    </div>
                </div>
                <div id="user-list" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne1">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="datatable table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th width="10%">Project Name</th>
                                        <th width="10%">Estimate Start Date</th>
                                        <th width="10%">Estimate End Date</th>
                                        <th width="10%">Actual Start Date</th>
                                        <th width="10%">Actual End Date</th>
                                        <th width="15%">Task Count</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($projectsdata) && count($projectsdata) > 0)
                                    @foreach($projectsdata as $projectKey=>$project)
                                    @php
                                        $user = DB::table('users')->where('id',$project->created_by)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $projectKey+1 }}</td>

                                        <td>
                                            {{ $project->name }}
                                            @if(!empty($project->description))
                                                <a href="javascript:;" data-toggle="popover{{ $project->id }}" title="{{ $project->name }}" data-content="{{ $project->description }}" style="text-decoration: none" data-html="true"  data-trigger="hover focus" onmouseover="popoverFun('popover{{ $project->id }}')"><span class=" icon-info"></span></a>
                                            @endif
                                        </td>

                                        <td>{{ date('d-m-Y',strtotime($project->estimate_start_date)) }}</td>
                                        <td>{{ date('d-m-Y',strtotime($project->estimate_end_date)) }}</td>
                                        <td>{{ (!empty($project->actual_start_date))?date('d-m-Y',strtotime($project->actual_start_date)):'N.A' }}</td>
                                        <td>{{ (!empty($project->actual_end_date))?date('d-m-Y',strtotime($project->actual_end_date)):'N.A' }}</td>

                                        <td>
                                            @php
                                                $totalTask = 0;
                                                if(in_array(Auth::user()->role_id,[1,2]))
                                                {

                                                    $totalTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->get()->count();
                                                    $totalOnGoingTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->whereIn('is_complete',[1,2,3])->get()->count();
                                                    $totalNotStartedTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->whereIn('is_complete',[0])->get()->count();
                                                    $totalClosedTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->whereIn('is_complete',[4])->get()->count();
                                                }elseif(in_array(Auth::user()->tier_user,[1,2]))
                                                {

                                                    $totalTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->where('dept_id',Auth::user()->dept_id)->get()->count();
                                                    $totalOnGoingTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->whereIn('is_complete',[1,2,3])->where('dept_id',Auth::user()->dept_id)->get()->count();
                                                    $totalNotStartedTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->whereIn('is_complete',[0])->where('dept_id',Auth::user()->dept_id)->get()->count();
                                                    $totalClosedTask = DB::table('task_details')->where('project_id',$project->id)->where('is_delete',0)->whereIn('is_complete',[4])->where('dept_id',Auth::user()->dept_id)->get()->count();
                                                }
                                            @endphp
                                            @if($totalTask > 0)
                                            <ul style="list-style: none;">
                                                <li><span class="badge badge-secondary" style="font-weight: bold">Not started</span> - {{ $totalNotStartedTask }}/{{ $totalTask }}</li>
                                                <li><span class="badge badge-info" style="font-weight: bold">On-going</span> - {{ $totalOnGoingTask }}/{{ $totalTask }}</li>
                                                <li><span class="badge badge-success" style="font-weight: bold">Closed</span> - {{ $totalClosedTask }}/{{ $totalTask }}</li>
                                            </ul>
                                            @endif
                                        </td>
                                        <td>{{ $status[$project->is_active] }}</td>
                                        <td>
                                            @can('project-edit')
                                            @if(Auth::user()->id == $project->created_by || Auth::user()->dept_id == 7)
                                            <a href="{{ route('edit-project',[encrypt($project->id)])}}" class="btn btn-rss m-b-xs space-button" title="Edit"><span class="icon-note"></span> </a>
                                            @endif
                                            @endcan

                                            @can('project-delete')
                                            @if(Auth::user()->id == $project->created_by || Auth::user()->dept_id == 7)
                                            <a href="{{ route('delete-project',[encrypt($project->id)])}}" class="btn btn-danger m-b-xs space-button" title="Delete" onclick="return confirm('Are you sure ?')"><span class="icon-trash"></span></a>
                                            @endif
                                            @endcan

                                            <a href="{{ route('task-list',[encrypt($project->id)]) }}" class="btn btn-success m-b-xs space-button" title="Task Status"><span class="icon-eye"></span> </a>

                                            <a href="{{ route('view-task-details',[encrypt($project->id)]) }}" class="btn btn-info m-b-xs space-button" title="Task Details"><span class="icon-user-follow"></span> </a>

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

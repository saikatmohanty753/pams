@extends('./layout/main')
@section('content')
@can('task-list')
@php
    $delay_status = array(0=>'success',1=>'danger', 2=> 'warning');
    $project_status = array(0=>'In-active',1=>'Active');
    $project_assign = DB::table('departs_project_details')->where('project_id',$project_details->id)->get()->toArray();
    $project_departments = DB::table('departments')->pluck('name','id');
    $departments = DB::table('departments')->where('is_active',1)->get();
    $proj_dept = '';
    if(isset($project_assign) && count($project_assign) > 0)
    {
        foreach ($project_assign as $projkey => $projass) {
            $proj_dept .= $project_departments[$projass->dept_id].',';
        }
        $proj_dept = rtrim($proj_dept,',');
    }
    $project = $project_details;
@endphp
<style>
.dataTables_filter {
   float: left !important;
}
.dt-buttons{
    float: right !important;
}
.dt-buttons > .dt-button {
    display: inline-block;
    border: 1px solid #ececec;
    border-radius: 3px;
    font-size: 18px;
    line-height: 18px;
    border-radius: 6px;
    cursor: pointer;
    color: #fff;
}
.dt-button.buttons-excel {
    background: #14A2BB;
}
.dt-button.buttons-pdf {
    background: #DE4D4D;
}
.row > .col-md-3 {
    margin-top: 2%;
    justify-content: space-between;
    font-weight: 700;
}
</style>
<div class="container-card">
    <div class="panel panel-white">
        <div class="panel-body">
            <div style="float: right">
                <a href="{{ route('view-task-details',[encrypt($project_details->id)]) }}" class="btn btn-info m-b-xs space-button" title="Task Details"><span class="icon-user-follow"></span> </a>

                <a class="btn btn-success" title="Create Task" data-toggle="modal" data-target="#myModal{{ $project->id }}" data-backdrop="static" data-keyboard="false">ADD | <i class="fa fa-caret-down"></i></a>

                <a href="{{ route('project-list') }}" class="btn btn-default m-b-xs space-button">Back </a>
            </div>

            <h2 style="text-decoration: underline">{{ $project_details->name }}</h2>
            <div class="row">
                <div class="col-md-3">
                    Estimate Start Date : {{ date('d-m-Y',strtotime($project_details->estimate_start_date)) }}
                </div>
                <div class="col-md-3">
                    Estimate End Date : {{ date('d-m-Y',strtotime($project_details->estimate_end_date)) }}
                </div>
                <div class="col-md-3">
                    Actual Start Date : {{ (!empty($project_details->actual_start_date))?date('d-m-Y',strtotime($project_details->actual_start_date)):'' }}
                </div>
                <div class="col-md-3">
                    Actual End Date : {{ (!empty($project_details->actual_end_date))?date('d-m-Y',strtotime($project_details->actual_end_date)):'' }}
                </div>
                <div class="col-md-3">
                    Status : {{ (!empty($project_details->is_active))?$project_status[$project_details->is_active]:'' }}
                </div>
                <div class="col-md-3">
                    Department Assign : {{ $proj_dept }}
                </div>
                <div class="col-md-3">
                    Description :  ❝ {!! $project_details->description !!} ❞
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Create Task Modal --}}
@include('../includes/create_task_modal')
{{-- Create Task Modal End --}}

<div id="main-wrapper">
    <div class="panel panel-white">
        <div class="panel-body">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#tab1" role="tab" data-toggle="tab" aria-expanded="false" style="font-weight:bold">List</a></li>
                    <li role="presentation" class=""><a href="#tab5" role="tab" data-toggle="tab" aria-expanded="false" style="font-weight:bold">Progress</a></li>
                    <li role="presentation" class=""><a href="#tab2" role="tab" data-toggle="tab" aria-expanded="false" style="font-weight:bold">Deadline</a></li>
                    <li role="presentation" class=""><a href="#tab3" role="tab" data-toggle="tab" aria-expanded="false" style="font-weight:bold">Planned</a></li>
                    <li role="presentation" class=""><a href="#tab4" role="tab" data-toggle="tab" aria-expanded="true" style="font-weight:bold">Closed</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="mytasks tab-pane fade  active in" id="tab1">
                        <table class="table datatable-tasklist">
                            <thead>
                                <tr>
                                    <th>List</th>
                                    <th>Name</th>
                                    <th width="10%">Active</th>
                                    <th>Deadline</th>
                                    <th>Created by</th>
                                    <th>Responsible person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($task_details) && $task_details->count() > 0)
                                @foreach($task_details as $key=>$tsk)
                                @php
                                    $project = getTable('project_masters',['id'=>$tsk->project_id]);
                                    $projectdetail = $tsk;
                                @endphp
                                @if(in_array($tsk->is_complete,[1,2,3]))
                                @php
                                    $delaydata = timeDifference($tsk->end_date);
                                @endphp

                                @endif
                                @if($tsk->is_complete == 0)
                                @php
                                    $delaydata = timeDifference($tsk->task_end_date);
                                @endphp

                                @endif
                                @if($tsk->is_complete == 4)
                                @php
                                    $delaydata = timeTotalDifference($tsk->task_end_date,$tsk->end_date);
                                @endphp

                                @endif
                                <tr>
                                    <th scope="row">{{ $key+1 }}</th>
                                    <td>
                                        <a data-toggle="modal" style="text-decoration: none;cursor: pointer;" data-target="#myupdateModal{{ $tsk->id }}" data-backdrop="static" data-keyboard="false">{{ $tsk->task_subject }}</a>
                                        @include('../includes/update_task_modal')
                                    </td>
                                    <td>{{ date('d-m-Y',strtotime($tsk->start_date)) }}</td>
                                    <td>
                                        @if($tsk->is_complete == 0)
                                        <button class="btn btn-default btn-rounded">
                                            Not Started
                                            </button>
                                        @else
                                        <button class="btn btn-{{ $delay_status[$delaydata['badge']] }} btn-rounded">
                                        {{ ($delaydata['badge'] == 0)?'On-going':$delaydata['elapsed'] }}</button>
                                        @endif
                                    </td>
                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($tsk->created_by) }} </td>
                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($tsk->responsible_person) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab2">
                        <table class="table datatable-plannedline">
                            <thead>
                                <tr>
                                    <th>List</th>
                                    <th>Name</th>
                                    <th>Active</th>
                                    <th>Deadline</th>
                                    <th>Created by</th>
                                    <th>Responsible person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($task_details_deadline) && count($task_details_deadline) > 0)
                                @foreach($task_details_deadline as $deadkey => $deadlines)
                                @php
                                    $project = getTable('project_masters',['id'=>$deadlines->project_id]);
                                @endphp
                                @if(in_array($deadlines->is_complete,[1,2,3]))
                                @php
                                    $delaydata = timeDifference($deadlines->end_date);
                                @endphp

                                @endif

                                @if($deadlines->is_complete == 4)
                                @php
                                    $delaydata = timeTotalDifference($deadlines->task_end_date,$deadlines->end_date);
                                @endphp

                                @endif
                                <tr>
                                    <td scope="row">{{ $deadkey+1 }}</td>
                                    <td>{{ $deadlines->task_subject }}</td>
                                    <td>{{ date('d-m-Y',strtotime($deadlines->start_date)) }}</td>
                                    <td><button class="btn btn-{{ $delay_status[$delaydata['badge']] }} btn-rounded">
                                        {{ ($delaydata['badge'] == 0)?'On-going':$delaydata['elapsed'] }}
                                    </button></td>
                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($deadlines->created_by) }} </td>
                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($deadlines->responsible_person) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab3">
                        <table class="table datatable-deadline">
                            <thead>
                                <tr>
                                    <th>List</th>
                                    <th>Name</th>
                                    <th>Active</th>
                                    <th>Created by</th>
                                    <th>Responsible person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($task_details_planned) && count($task_details_planned) > 0)
                                @foreach($task_details_planned as $plankey => $planned)
                                @php
                                    $project = getTable('project_masters',['id'=>$planned->project_id]);
                                @endphp
                                <tr>
                                    <td scope="row">{{ $plankey+1 }}</td>
                                    <td>{{ $planned->task_subject }}</td>
                                    <td>{{ date('d-m-Y',strtotime($planned->start_date)) }}</td>
                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($planned->created_by) }} </td>
                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($planned->responsible_person) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab4">
                        <table class="table datatable-closedline">
                            <thead>
                                <tr>
                                    <th>List</th>
                                    <th>Name</th>
                                    <th>Active</th>
                                    <th>Created by</th>
                                    <th>Responsible person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($task_details_closes) && count($task_details_closes) > 0)
                                @foreach($task_details_closes as $closekey => $closed)
                                @php
                                    $project = getTable('project_masters',['id'=>$closed->project_id]);
                                @endphp

                                <tr>
                                    <td scope="row">{{ $closekey+1 }}</td>
                                    <td>{{ $closed->task_subject }}</td>
                                    <td>{{ date('d-m-Y',strtotime($closed->start_date)) }}</td>

                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($closed->created_by) }} </td>
                                    <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($closed->responsible_person) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab5">
                        <div class="table-response">
                            <table class="table datatable-progressline">
                                <thead>
                                    <tr>
                                        <th>List</th>
                                        <th>Name</th>
                                        <th>Active</th>
                                        <th>Created by</th>
                                        <th>Responsible person</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($task_details_progress) && count($task_details_progress) > 0)
                                    @foreach($task_details_progress as $progresskey => $progress)
                                    @php
                                        $project = getTable('project_masters',['id'=>$progress->project_id]);
                                    @endphp

                                    <tr>
                                        <td scope="row">{{ $progresskey+1 }}</td>
                                        <td>{{ $progress->task_subject }}</td>
                                        <td>{{ date('d-m-Y',strtotime($progress->start_date)) }}</td>

                                        <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($progress->created_by) }} </td>
                                        <td><span><img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle avatar" width="30" alt=""></span> {{ getUserName($progress->responsible_person) }}</td>
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

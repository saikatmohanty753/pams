@extends('./layout/main')
@section('content')
<style>
    #task-assign-body{
        height: 600px;
        overflow-y: scroll;
    }
    .sub-border{
        border-left: 6px solid #ccc!important;
        border-color: #2196F3!important;
        color: #000!important;
        background-color: #ddffff!important;
    }
    .sub-delete{
        margin-right: 12px;
        margin-top: -39px;
    }
</style>
<div class="page-inner">
    @php
    $task_status = array(1=>'Started',2=>'Re-open', 3=> 'Under Review', 4=>'Complete','0'=>'Not Started');
    $badge_status = array(1=>'primary',2=>'info', 3=> 'danger', 4=>'success','0'=>'secondary');
    $blink_status = array(1=>'',2=>'blink_me', 3=> 'blink_me', 4=>'','0'=>'');
    @endphp
    <div id="main-wrapper">

        <div class="row mb-3">
            <div class="col-md-9">
                <h2>{{ $project->name }} </h2>
            </div>
            <div class="col-md-3 text-right" style="margin-top:15px;">
                <button class="btn btn-default"><i class="fa fa-bell"></i></button>
                <button class="btn btn-default"><i class="fa fa-gear"></i></button>

                <a class="btn btn-success" title="Create Task" data-toggle="modal" data-target="#myModal{{ $project->id }}" data-backdrop="static" data-keyboard="false">ADD | <i class="fa fa-caret-down"></i></a>
            </div>
        </div>
        
        {{-- Create Task Modal --}}
        @include('../includes/create_task_modal')
        {{-- Create Task Modal Ends --}}

        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-white">
                    <div class="panel-body" id="task-assign-body">
                        @if(isset($task_details) && count($task_details) > 0)
                        @foreach($task_details as $taskey=>$task)
                        <h4>{{ $task->task_subject }} - <span class="badge badge-{{ $badge_status[$task->is_complete] }} {{ $blink_status[$task->is_complete] }}" style="font-weight: bold">{{ $task_status[$task->is_complete] }}</span> </h4>
                        <hr/>
                        {{-- Delete the Main Task --}}
                        <div class="text-right">
                            @can('task-delete')
                            @if(Auth::user()->id == $task->created_by)
                            <a href="{{ route('delete-task',[encrypt($task->id)]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-danger"><span class="icon-trash"></span></a>
                            @endif
                            @endcan
                        </div>

                        {{-- Main Task List --}}
                        @php
                            $task_assigns = getTableAll('assign_users_details',[['task_detail_id',$task->id],['project_id',$project->id],['is_removed',0]]);
                        @endphp
                        <h4>Task Assigned</h4>
                        @if(isset($task_assigns) && count($task_assigns) > 0)
                        @foreach($task_assigns as $assign)
                        <p>{{ getUserName($assign->assign_user_id) }} @if($assign->is_responsible == 1) <span class="badge badge-success">Responsible Person</span> @endif</p>
                        @endforeach
                        @endif

                        {{-- Sub Task List --}}
                        @php
                            $subtasks = getSubTaskDetails($task->id);
                        @endphp
                        @if(isset($subtasks) && count($subtasks) > 0)
                        <div class="clearfix"></div>
                        <ol>
                        @foreach($subtasks as $subtsk)
                        <li>
                        <ul class="sub-border">
                        <li>
                            <h4 style="text-decoration: underline">Sub Task : {{ $subtsk->task_subject }} - <span class="badge badge-{{ $badge_status[$subtsk->is_complete] }} {{ $blink_status[$subtsk->is_complete] }}" style="font-weight: bold">{{ $task_status[$subtsk->is_complete] }}</span></h4>

                            <div class="text-right">
                                @can('task-delete')
                                @if(Auth::user()->id == $subtsk->created_by)
                                <a href="{{ route('delete-task',[encrypt($subtsk->id)]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-danger sub-delete" title="Delete Sub Task"><span class="icon-trash"></span></a>
                                @endif
                                @endcan
                            </div>
                        </li>

                        @php
                            $sub_task_assigns = getTableAll('assign_users_details',[['task_detail_id',$subtsk->id],['project_id',$project->id],['is_removed',0]]);
                        @endphp

                        <h4>Task Assigned</h4>
                        @if(isset($sub_task_assigns) && count($sub_task_assigns) > 0)
                        @foreach($sub_task_assigns as $subassign)
                        <p>{{ getUserName($subassign->assign_user_id) }} @if($subassign->is_responsible == 1) <span class="badge badge-success">Responsible Person</span> @endif</p>
                        @endforeach
                        @endif
                        </ul>
                        </li>
                        @endforeach
                        </ol>
                        @endif
                        {{-- Sub Task List Ends --}}

                        @php
                            $htmlTiltle = $task->task_subject.'<br/> <small><strong>Start Date : '.date('d-m-Y',strtotime($task->start_date)).' & End Date : '.date('d-m-Y',strtotime($task->end_date)).'</strong></small>';

                            $task_observers = getTableASCAll('assign_observer_users_details',[['task_detail_id',$task->id],['project_id',$task->project_id],['is_removed',0]]);

                            $html = '<h4>Observers</h4><hr/>';
                            $html .= '<ol>';
                            if(isset($task_observers) && count($task_observers) > 0)
                            {
                                foreach ($task_observers as $key => $value) {
                                    $html .= '<li>'.getUserName($value->observer_user_id).'</li>';
                                }
                            }
                            $html .= '</ol>';
                        @endphp
                        <div class="text-right">
                            <span><a href="javascript:;" data-toggle="popotask{{ $task->id }}" title="{{ $htmlTiltle }}" data-content="{{ $html }}" style="text-decoration: none" data-html="true"  data-trigger="hover focus" onmouseover="popoverFun('popotask{{ $task->id }}')" data-placement="left"></span>&nbsp;&nbsp;<span><i class="fa fa-eye"></i>&nbsp; {{ count($task_observers) }}</span></a>
                        </div>                                    
                        <hr/>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-white bdrs-10">
                    <div class="bg-info rounded bdrs-10 w-100" style="padding: 9px 15px;">
                        @if(!empty($project->actual_start_date))<span><strong> Start date </strong> {{ date('d-m-Y',strtotime($project->actual_start_date)) }} </span> @else <span><strong>Estimate Start date </strong> {{ date('d-m-Y',strtotime($project->estimate_start_date)) }} </span> @endif
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">@if(empty($project->actual_end_date)) Estimate Deadline @else Deadline @endif</div>
                            <div class="col-sm-6" style="text-decoration: dashed;">
                                <a href="#" class="link-dashed">@if(!empty($project->actual_end_date)) {{ date('d-m-Y',strtotime($project->actual_end_date)) }} @else {{ date('d-m-Y',strtotime($project->estimate_end_date)) }} @endif</a>
                            </div>                                    
                        </div>
                        <hr>
                        <div class="alert alert-success" role="alert">{!! @$project->description !!}</div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <p>Created By </p>
                                <hr class="mtb-1">
                                <div class="row">
                                    <div class="col-sm-2 col-xs-2">
                                        <img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle media-object" style="width:40px">
                                    </div>                                                
                                    <div class="col-sm-10 col-xs-10">
                                        <H4><a href="#">{{ getUserName($project->created_by) }}</a></H4>
                                    </div>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
</div><!-- Page Inner -->
@endsection
@extends('./layout/main')
@section('content')
<style>
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        padding: 5px;
    }
    .grid-item {
        padding: 5px;
        text-align: center;
    }
    .container-time {
        display: grid;
        column-gap: 50px;
    }
    .container-time p {
        padding: 5px;
    }
</style>
<div class="page-inner">
    @php
    $task_status = array(1=>'Started',2=>'Re-open', 3=> 'Under Review', 4=>'Complete','0'=>'Not Started');
    $badge_status = array(1=>'primary',2=>'info', 3=> 'danger', 4=>'success','0'=>'secondary');
    $blink_status = array(1=>'',2=>'blink_me', 3=> 'blink_me', 4=>'','0'=>'');
    $task_assign = getTableASCAll('assign_users_details',[['task_detail_id',$task_details->id],['project_id',$task_details->project_id],['is_removed',0]]);

    $task_comments = getTableASCAll('comment_details',[['task_detail_id',$task_details->id],['project_id',$task_details->project_id]]);
    $task_reopens = getTableASCAll('reopen_logs',[['task_id',$task_details->id],['project_id',$task_details->project_id]]);

    $task_assigns_ids = getPluck('assign_users_details',[['task_detail_id',$task_details->id],['project_id',$task_details->project_id],['is_removed',0]],'assign_user_id')->toArray();
    $task_observe = getTableASCAll('assign_observer_users_details',[['task_detail_id',$task_details->id],['project_id',$task_details->project_id],['is_removed',0]]);
    @endphp
    <div id="main-wrapper">

        <div class="row mb-3">
            <div class="col-md-9">
                <h2>{{ ($task_details->parent_task_id!=0 && $task_details->parent_task_id!='')?getTableName('task_details',['id'=>$task_details->parent_task_id],'task_subject').' ( Parent Task ) ':$task_details->task_subject }} </h2>
            </div>
            <div class="col-md-3 text-right" style="margin-top:15px;">
                <button class="btn btn-default"><i class="fa fa-bell"></i></button>
                <button class="btn btn-default"><i class="fa fa-gear"></i></button>
            </div>
        </div>


        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <h4>{{ ($task_details->parent_task_id!=0 && $task_details->parent_task_id!='')?' ( Sub Task ) '.$task_details->task_subject:$task_details->task_subject }} - <span class="badge badge-{{ $badge_status[$task_details->is_complete] }} {{ $blink_status[$task_details->is_complete] }}" style="font-weight: bold"> {{ $task_status[$task_details->is_complete] }} </span> </h4>
                        <hr/>
                        <div class="text-right">
                            <i class="fa fa-star"></i>
                        </div>
                        <p>{{ $task_details->task_description }}</p>
                        @if(isset($task_reopens) && count($task_reopens) > 0)
                        <h5>Reopen descriptions</h5>
                        <ol>
                        @foreach($task_reopens as $tsk_reopen)
                        <li><p>{{ ((Auth::user()->id == $tsk_reopen->created_by)?'You':getUserName($tsk_reopen->created_by)).' : '.$tsk_reopen->reopen_remark }}</p></li>
                        @endforeach
                        </ol>
                        @endif
                        <hr/>
                        <div class="d-flex">

                            @if($task_details->is_complete == 0)
                            @if(in_array(Auth::user()->id,$task_assigns_ids))
                            <button type="button" class="btn btn-success mx-1" id="start_task" onclick="startTask('{{ $task_details->id }}')">START</button>
                            @endif
                            @endif

                            @if($task_details->is_complete == 3 && Auth::user()->id == $task_details->created_by)
                            <button type="button" class="btn btn-info mx-1" data-target="#myReopenModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" id="reopen_task">RE-OPEN</button>
                            @include('../includes/reopen_task_modal')

                            @endif

                            @if($task_details->end_date > date('Y-m-d h:i:s'))

                            @if($task_details->is_complete != 0 && $task_details->is_complete != 4 && $task_details->is_complete != 3 && !in_array(Auth::user()->tier_user,[1,2]))
                            @if(in_array(Auth::user()->id,$task_assigns_ids) || Auth::user()->id == $task_details->created_by)

                            <button type="button" class="btn btn-success mx-1" onclick="finishTask('{{ $task_details->id }}')" id="finish_task">FINISH</button>

                            @endif
                            @endif

                            @if($task_details->is_complete != 0 && $task_details->is_complete != 4 && in_array(Auth::user()->tier_user,[1,2]) && ($task_details->created_by == Auth::user()->id || $task_details->responsible_person == Auth::user()->id))

                            @if(Auth::user()->tier_user == 2 && $task_details->responsible_person != Auth::user()->id)
                            <button type="button" class="btn btn-success mx-1" onclick="finishTask('{{ $task_details->id }}')" id="finish_task">FINISH</button>
                            @elseif(Auth::user()->tier_user == 1)
                            <button type="button" class="btn btn-success mx-1" onclick="finishTask('{{ $task_details->id }}')" id="finish_task">FINISH</button>
                            @elseif($task_details->created_by == Auth::user()->id)
                            <button type="button" class="btn btn-success mx-1" onclick="finishTask('{{ $task_details->id }}')" id="finish_task">FINISH</button>
                            @endif

                            @endif

                            @else

                            @if($task_details->is_complete != 0 && $task_details->is_complete != 4 && in_array(Auth::user()->tier_user,[3]) && $task_details->is_complete != 3)

                            <button type="button" class="btn btn-success mx-1" data-toggle="modal" data-target="#myDelayModal" data-backdrop="static" data-keyboard="false">FINISH</button>
                            @include('../includes/delay_activity_modal')

                            @elseif($task_details->is_complete != 0 && $task_details->is_complete != 4 && in_array(Auth::user()->tier_user,[1,2]) && $task_details->created_by == Auth::user()->id)

                            <button type="button" class="btn btn-success mx-1" onclick="finishTask('{{ $task_details->id }}')" id="finish_task">FINISH</button>

                            @endif

                            @endif
                        </div>
                    </div>
                </div>


                <div class="panel-body">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab1" role="tab" data-toggle="tab" aria-expanded="false">Comments </a></li>
                            <li role="presentation" class=""><a href="#tab3" role="tab" data-toggle="tab" aria-expanded="false">Delay Reason</a></li>
                            <li role="presentation" class=""><a href="#tab4" role="tab" data-toggle="tab" aria-expanded="true">Time elapsed</a></li>
                            <li role="presentation" class=""><a href="#tab2" role="tab" data-toggle="tab" aria-expanded="false">History</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                <div id="show_comment"></div>
                                @if($task_details->is_complete !=0 && $task_details->is_complete!=4)
                                <div class="form-group row">
                                    <div class="col-sm-1 col-xs-2">
                                        <img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle media-object" style="width:40px">
                                    </div>
                                    <div class="col-sm-11 col-xs-10">
                                        <textarea class="form-control input-rounded" id="input-rounded"></textarea>
                                    </div>
                                </div>
                                <button type="button" id="comment_btn" class="btn btn-info" style="margin-left: 70px;display:none" onclick="showComment('{{ $task_details->id }}','{{ $task_details->project_id }}')"><span class="icon-paper-plane"></span> Send</button>
                                @endif
                            </div>

                            <div role="tabpanel" class="tab-pane" id="tab2">
                                @if(isset($task_comments) && count($task_comments) > 0)
                                @foreach($task_comments as $task_com)
                                <div class="panel panel-purple ui-sortable-handle">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{ (Auth::user()->id == $task_com->created_by)?'You':getUserName($task_com->created_by) }}</h3>
                                        <div class="panel-control">
                                            {{ date('d-m-Y',strtotime($task_com->commented_on)) }}
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <p>{{ $task_com->comment }}</p>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                           <div role="tabpanel" class="tab-pane" id="tab3">
                                <p>No reason found</p>
                            </div>
                           <div role="tabpanel" class="tab-pane" id="tab4">
                            @php
                                $time_elapsed = getTableASCAll('time_elapse_details',[['project_id',$task_details->project_id],['task_id',$task_details->id]]);
                                $time_elapsed_check = DB::table('time_elapse_details')->where([['project_id',$task_details->project_id],['task_id',$task_details->id]])->whereDate('start_date',date('Y-m-d'));
                            @endphp
                            @if(isset($time_elapsed) && count($time_elapsed) > 0)
                            @foreach($time_elapsed as $time_elps)
                               <div class="alert alert-info" role="alert" id="time-elapsed{{ $time_elps->id }}">
                                    <div class="container-time">
                                        <table>
                                            <tr>
                                                <td width="10%">{{ ((Auth::user()->id == $time_elps->given_by)?'You':getUserName($time_elps->given_by)) }}</td>
                                                <td width="10%">{{ date('d-m-Y',strtotime($time_elps->start_date))}} {{ date('h:i A',strtotime($time_elps->start_date)) }}</td>
                                                <td width="10%">{!! $time_elps->remark !!}</td>
                                                <td width="10%">{{ date('d-m-Y',strtotime($time_elps->end_date)) }} {{ date('h:i A',strtotime($time_elps->end_date)) }} </td>

                                                @if(Auth::user()->id == $task_details->created_by)
                                                <td width="5%">
                                                    <a href="javascript:;" style="text-decoration: none;float: right;margin-top: 15px" title="Edit time elapsed" onclick="getTimeUpdateElapsed('{{ $task_details->project_id }}','{{ $task_details->id }}','{{ $time_elps->id }}','{{ $time_elps->start_date }}','{{ $time_elps->end_date }}','{!! $time_elps->remark !!}','time-elapsed{{ $time_elps->id }}')"><span class="icon-pencil"></span></a>
                                                </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                            @php
                                $update_time = '06:30 PM';
                                $dateTime = new DateTime($update_time);
                            @endphp
                            @if($task_details->is_complete !=  4 && ($dateTime->diff(new DateTime)->format('%R') == '+' || Auth::user()->is_allowed_time_elapsed == 1))
                                <div class="clearfix" id="tspl-time"></div>
                                <div id="time_elapse_save_div" @if($time_elapsed_check->exists()) style="display:none" @endif>
                                    <input type="hidden" id="time_els_id" />
                                    <div class="grid-container">
                                        <div class="grid-item">
                                            <input type="datetime-local" id="time_start_date" class="form-control" max="{{ date('Y-m-d h:i') }}">
                                        </div>
                                        <div class="grid-item">
                                            <textarea class="form-control" id="remark" style="width: 416px; height: 33px;"></textarea>
                                        </div>
                                        <div class="grid-item">
                                            <input type="datetime-local" id="time_end_date" class="form-control" max="{{ date('Y-m-d h:i') }}">
                                        </div>
                                    </div>
                                    <button type="button"id="time_elapsed_save" class="btn btn-info" style="margin-left: 16px" onclick="getTimeElapsed('{{ $task_details->project_id }}','{{ $task_details->id }}')"><span class="icon-check"></span> Save</button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-white bdrs-10">
                    <div class="bg-info rounded bdrs-10 w-100" style="padding: 9px 15px;">
                        @if($task_details->is_complete != 4) <span><strong>pending since</strong> {{ date('d-m-Y',strtotime($task_details->start_date)) }}</span> @elseif(!empty($task_details->task_end_date)) <span><strong>Completed on</strong> {{ date('d-m-Y',strtotime($task_details->task_end_date)) }}</span> @endif
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">Deadline</div>
                            <div class="col-sm-6" style="text-decoration: dashed;">
                                <a href="#" class="link-dashed">{{ date('d-m-Y',strtotime($task_details->end_date)) }}</a>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-success" role="alert">@if(!empty($task_details->task_description)) {{ $task_details->task_description }} @else Require task status summary. @endif</div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <p>Created By </p>
                                <hr class="mtb-1">
                                <div class="row">
                                    <div class="col-sm-2 col-xs-2">
                                        <img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle media-object" style="width:40px">
                                    </div>
                                    <div class="col-sm-10 col-xs-10">
                                        <H4><a href="#">{{ getUserName($task_details->created_by) }}</a></H4>
                                    </div>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            <div class="col-sm-12">
                                <p>Responsible Person</p>
                                <hr class="mtb-1">
                                <div class="row">
                                    <div class="col-sm-2 col-xs-2">
                                        <img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle media-object" style="width:40px">
                                    </div>
                                    <div class="col-sm-10 col-xs-10">
                                        <H4><a href="#">{{ getUserName($task_details->responsible_person) }}</a></H4>
                                    </div>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            <div class="col-sm-12">
                                <p>Participants</p>
                                <hr class="mtb-1">
                                @if(isset($task_assign) && count($task_assign) > 0)
                                @foreach($task_assign as $assign)
                                <div class="row">
                                    <div class="col-sm-2 col-xs-2">
                                        <img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle media-object" style="width:40px">
                                    </div>
                                    <div class="col-sm-10 col-xs-10">
                                        <H4><a href="#">{{ getUserName($assign->assign_user_id) }}</a></H4>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <p>&nbsp;</p>
                            <div class="col-sm-12">
                                <p>Observer</p>
                                <hr class="mtb-1">
                                @if(isset($task_observe) && count($task_observe) > 0)
                                @foreach($task_observe as $observe)
                                <div class="row">
                                    <div class="col-sm-2 col-xs-2">
                                        <img src="{{ asset('assets/images/dummy-profile-pic.jpg') }}" class="img-circle media-object" style="width:40px">
                                    </div>
                                    <div class="col-sm-10 col-xs-10">
                                        <H4><a href="#">{{ getUserName($observe->observer_user_id) }}</a></H4>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
</div><!-- Page Inner -->

<script type="text/javascript">
$(document).ready(function(){
    setInterval(() => {
        getComments('{{ $task_details->id }}','{{ $task_details->project_id }}')
    }, 1000);
});

function getComments(taskId,projectId)
{
    var url = "{{ route('show-comment') }}";
    $.ajax({
        url:url,
        type:'GET',
        data:{"_token":"{{ csrf_token() }}","project_id":projectId,"task_id":taskId},
        dataType:'JSON',
        success:function(res)
        {
            $('#show_comment').html(res);
        }
    });

    getDelays(taskId,projectId);
}

function getDelays(taskId,projectId)
{
    var url = "{{ route('show-delay') }}";
    $.ajax({
        url:url,
        type:'GET',
        data:{"_token":"{{ csrf_token() }}","project_id":projectId,"task_id":taskId},
        dataType:'JSON',
        success:function(res)
        {
            $('#tab3').html(res);
        }
    });
}
</script>
@endsection

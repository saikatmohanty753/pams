@can('task-list')
    @php
        $task_status = array(1=>'Started',2=>'Re-open', 3=> 'Under Review', 4=>'Complete','0'=>'Not Started');
        $badge_status = array(1=>'primary',2=>'info', 3=> 'danger', 4=>'success','0'=>'secondary');
        $blink_status = array(1=>'',2=>'blink_me', 3=> 'blink_me', 4=>'','0'=>'');
        $delay_status = array(0=>'success',1=>'danger', 2=> 'warning');
    @endphp
    <div class="table-responsive">
        <table class="datatable-team-ajax table table-bordered">
            <thead>
                <tr>
                    <th>Sl.no</th>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Start Date</th>
                    <th>Deadline</th>
                    <th>Responsible Person</th>
                    <th>Status</th>
                    <th>Delay By</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($task_details) && count($task_details) > 0)
                @foreach($task_details as $tskey => $tsk_assign)
                @php
                    $project = getTable('project_masters',['id'=>$tsk_assign->project_id]);
                    $users = getTable('users',['id'=>$tsk_assign->responsible_person]);
                @endphp
                <tr>
                    <td>{{ $tskey+1 }}</td>
                    <td>{{ $project->name }}</td>
                    <td>
                        <a href="{{ route('assign-task-update',[encrypt($tsk_assign->id)])}}" style="text-decoration: none">{{ $tsk_assign->task_subject }}</a>
                        @if(!empty($tsk_assign->task_description))
                            <a href="javascript:;" data-toggle="popovertask{{ $tsk_assign->id }}" title="{{ $tsk_assign->task_subject }}" data-content="{{ $tsk_assign->task_description }}" style="text-decoration: none" data-html="true"  data-trigger="hover focus" onmouseover="popoverFun('popovertask{{ $tsk_assign->id }}')"><span class=" icon-info"></span></a>
                        @endif
                    </td>
                    <td>{{ (!empty($tsk_assign->start_date))?date('d-m-Y',strtotime($tsk_assign->start_date)):'Not available' }}</td>
                    <td>{{ (!empty($tsk_assign->end_date))?date('d-m-Y',strtotime($tsk_assign->end_date)):'Not available' }}</td>
                    <td>{{ @$users->first_name.' '.$users->last_name }}</td>
                    <td>
                        <span class="badge badge-{{ $badge_status[$tsk_assign->is_complete] }} {{ $blink_status[$tsk_assign->is_complete] }}" style="font-weight: bold">{{ $task_status[$tsk_assign->is_complete] }}</span>
                    </td>
                    <td>
                        @if($tsk_assign->is_complete!=0 && $tsk_assign->is_complete != 4)
                        @php
                            $delaydata = timeDifference($tsk_assign->end_date);
                        @endphp
                        <span class="badge badge-{{ $delay_status[$delaydata['badge']] }}"><strong>{{ ($delaydata['badge'] == 0)?'On-Time':$delaydata['elapsed'] }}</strong></span>
                        @endif

                        @if($tsk_assign->is_complete == 4)
                        @php
                            $delaydata = timeTotalDifference($tsk_assign->task_end_date,$tsk_assign->end_date);
                        @endphp
                        <span class="badge badge-{{ $delay_status[$delaydata['badge']] }}"><strong>{{ ($delaydata['badge'] == 0)?'On-Time':$delaydata['elapsed'] }}</strong></span>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        var table = $('.datatable-team-ajax').DataTable({});
    </script>
@endcan
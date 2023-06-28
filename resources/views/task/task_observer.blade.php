@can('task-list')
    @php
        $task_status = array(1=>'Started',2=>'Re-open', 3=> 'Under Review', 4=>'Complete','0'=>'Not Started');
        $badge_status = array(1=>'primary',2=>'info', 3=> 'danger', 4=>'success','0'=>'secondary');
        $blink_status = array(1=>'',2=>'blink_me', 3=> 'blink_me', 4=>'','0'=>'');
        $delay_status = array(0=>'success',1=>'danger', 2=> 'warning');
    @endphp
    <div class="table-responsive">
        <table class="datatable-observe-ajax table table-bordered">
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
                @foreach($task_details as $tskey => $tsk_obs)
                @php
                    $project = getTable('project_masters',['id'=>$tsk_obs->project_id]);
                    $users = getTable('users',['id'=>$tsk_obs->responsible_person]);
                @endphp
                <tr>
                    <td>{{ $tskey+1 }}</td>
                    <td>{{ $project->name }}</td>
                    <td>
                        <a href="{{ route('assign-task-update',[encrypt($tsk_obs->id)])}}" style="text-decoration: none">{{ $tsk_obs->task_subject }}</a>
                        @if(!empty($tsk_obs->task_description))
                            <a href="javascript:;" data-toggle="popovertask{{ $tsk_obs->id }}" title="{{ $tsk_obs->task_subject }}" data-content="{{ $tsk_obs->task_description }}" style="text-decoration: none" data-html="true"  data-trigger="hover focus" onmouseover="popoverFun('popovertask{{ $tsk_obs->id }}')"><span class=" icon-info"></span></a>
                        @endif
                    </td>
                    <td>{{ (!empty($tsk_obs->start_date))?date('d-m-Y',strtotime($tsk_obs->start_date)):'Not available' }}</td>
                    <td>{{ (!empty($tsk_obs->end_date))?date('d-m-Y',strtotime($tsk_obs->end_date)):'Not available' }}</td>
                    <td>{{ @$users->first_name.' '.$users->last_name }}</td>
                    <td>
                        <span class="badge badge-{{ $badge_status[$tsk_obs->is_complete] }} {{ $blink_status[$tsk_obs->is_complete] }}" style="font-weight: bold">{{ $task_status[$tsk_obs->is_complete] }}</span>
                    </td>
                    <td>
                        @if($tsk_obs->is_complete!=0 && $tsk_obs->is_complete != 4)
                        @php
                            $delaydata = timeDifference($tsk_obs->end_date);
                        @endphp
                        <span class="badge badge-{{ $delay_status[$delaydata['badge']] }}"><strong>{{ ($delaydata['badge'] == 0)?'On-Time':$delaydata['elapsed'] }}</strong></span>
                        @endif

                        @if($tsk_obs->is_complete == 4)
                        @php
                            $delaydata = timeTotalDifference($tsk_obs->task_end_date,$tsk_obs->end_date);
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
        var table = $('.datatable-observe-ajax').DataTable({});
    </script>
@endcan
<style>
    button.dt-button, div.dt-button, a.dt-button{
        color: white !important;
        border: none;
    }
    .dataTables_filter {
        float: left !important;
    }
    .dt-buttons{
        float: right !important;
    }
</style>
<div class="table-responsive">
    <table class="table report-ajax table-bordered">
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Project Name</th>
                <th>Departments</th>
                <th>Sub Departments</th>
                <th>Task Name</th>
                <th>Task Assign To</th>
                <th>Observer</th>
                <th width="10%">Task Start Date</th>
                <th width="10%">Task Deadline</th>
                <th width="10%">Participant Start Date</th>
                <th width="10%">Finished on</th>
                {{-- <th width="20%">Total Working Hours</th> --}}
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($task_details) && count($task_details) > 0)
            @php
            $task_status = array(1=>'Started',2=>'Re-open', 3=> 'Under Review', 4=>'Complete','0'=>'Not Started');
            $badge_status = array(1=>'primary',2=>'info', 3=> 'danger', 4=>'success','0'=>'secondary');
            $blink_status = array(1=>'',2=>'blink_me', 3=> 'blink_me', 4=>'','0'=>'');
            @endphp
            @foreach($task_details as $tskey=>$tsk)
            @php
                $assignDetails = getTableAll('assign_users_details',[['task_detail_id',$tsk->id],['is_removed',0]]);
                $observeDetails = getTableAll('assign_observer_users_details',[['task_detail_id',$tsk->id],['is_removed',0]]);
                $projectAssDepts = getTableAll('departs_project_details',[['project_id',$tsk->project_id]]);
                $projectAssSubDepts = getTableAll('sub_depts_project_details',[['project_id',$tsk->project_id]]);
            @endphp
            <tr>
                <td>{{ $tskey+1 }}</td>
                <td><a href="{{ route('view-task-details',[encrypt($tsk->project_id)]) }}" target="__blank" style="text-decoration: none"><strong>{{ getTableName('project_masters',['id'=>$tsk->project_id],'name') }}</strong></a></td>
                <td>

                    <ol>
                        @if(isset($projectAssDepts) && count($projectAssDepts) > 0)
                        @foreach($projectAssDepts as $projectDept)
                        <li>{{ getTableName('departments',['id'=>$projectDept->dept_id],'name') }}</li>
                        @endforeach
                        @endif
                    </ol>
                </td>
                <td>
                    <ol>
                        @if(isset($projectAssSubDepts) && count($projectAssSubDepts) > 0)
                        @foreach($projectAssSubDepts as $projectSubDept)
                        <li>{{ getTableName('sub_departments',['id'=>$projectSubDept->sub_dept_id],'name') }}</li>
                        @endforeach
                        @endif
                    </ol>
                </td>
                <td><a href="{{ route('assign-task-update',[encrypt($tsk->id)])}}" style="text-decoration: none"><strong>{{ $tsk->task_subject }}</strong></a></td>
                <td>
                    @if(!empty($user_id))
                    {{ getUserName($user_id) }}
                    @else
                    <ol>
                        @if(isset($assignDetails) && count($assignDetails) > 0)
                        @foreach($assignDetails as $assign)
                        <li>{{ getUserName($assign->assign_user_id) }} @if($assign->is_responsible == 1) - <span class="badge badge-success"> Responsible Person</span> @endif</li>
                        @endforeach
                        @endif
                    </ol>
                    @endif
                </td>
                <td>
                    <ol>
                        @if(isset($observeDetails) && count($observeDetails) > 0)
                        @foreach($observeDetails as $observe)
                        <li>{{ getUserName($observe->observer_user_id) }}</li>
                        @endforeach
                        @endif
                    </ol>
                </td>
                <td>{{ date('d F Y',strtotime($tsk->start_date))}}</td>
                <td>{{ date('d F Y',strtotime($tsk->end_date))}}</td>
                <td>{{ (!empty($tsk->task_start_date))?date('d F Y',strtotime($tsk->task_start_date)):''}}</td>
                <td>{{ (!empty($tsk->task_end_date))?date('d F Y',strtotime($tsk->task_end_date)):''}}</td>
                {{-- <td>
                    @if($tsk->is_complete == 4)
                    {{ calHours($tsk->task_start_date,$tsk->task_end_date) }}
                    @endif
                </td> --}}
                <td>
                    <span class="badge badge-{{ $badge_status[$tsk->is_complete] }} {{ $blink_status[$tsk->is_complete] }}" style="font-weight: bold">{{ $task_status[$tsk->is_complete] }}
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var tablerepo = $('.report-ajax').DataTable({
        "pageLength": 3,
        bLengthChange:false,
        dom: 'Bfrtip',
        "ordering": false,
        buttons: [
            'excel','pdf'
        ],
        initComplete: function() {
            $('.buttons-excel').html('<i class="fa fa-file-excel-o" />');
            $('.buttons-pdf').html('<i class="fa fa-file-pdf-o" />');
            $('.buttons-excel').addClass('btn btn-success');
            $('.buttons-pdf').addClass('btn btn-danger');
            $('.buttons-excel').attr('title','Download Excel');
            $('.buttons-pdf').attr('title','Download PDF');
        },
        fixedColumns: true
    });
</script>

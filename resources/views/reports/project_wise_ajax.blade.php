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
    <table class="table datatable-project-wise table-bordered">
        <thead>
            <tr>
                <th>Sl.no</th>
                <th>Project Name</th>
                <th>Assigned Department</th>
                @if(!empty($sub_dept_id))
                <th>Sub Department</th>
                @endif
                <th>Estimate Start Date</th>
                <th>Estimate End Date</th>
                <th>Actual Start Date</th>
                <th>Actual End Date</th>
            </tr>
        </thead>
        <tbody>
            @php
                $assign_sub_depts = DB::table('sub_departments')->pluck('name','id')->toArray();
            @endphp
            @if(isset($projects) && count($projects) > 0)
            @foreach($projects as $key=>$project)
            @php
                $assign_depts = DB::table('departs_project_details')->where('project_id',$project->id)->pluck('dept_id')->toArray();
            @endphp
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $project->name }}</td>
                <td>
                    @if(!empty($dept_id))
                        {{ $depts[$dept_id] }}
                    @else
                        <ol>
                            @if(!empty($assign_depts))
                            @foreach ($assign_depts as $adepts)
                                <li>{{ $depts[$adepts] }}<br></li>
                            @endforeach
                            @endif
                        </ol>
                    @endif
                </td>
                @if(!empty($sub_dept_id))
                <td>{{ $assign_sub_depts[$sub_dept_id] }}</td>
                @endif
                <td>{{ date('d-m-Y',strtotime($project->estimate_start_date)) }}</td>
                <td>{{ date('d-m-Y',strtotime($project->estimate_end_date)) }}</td>
                <td>{{ (!empty($project->actual_start_date))?date('d-m-Y',strtotime($project->actual_start_date)):'N.A' }}</td>
                <td>{{ (!empty($project->actual_end_date))?date('d-m-Y',strtotime($project->actual_end_date)):'N.A' }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var table6 = $('.datatable-project-wise').DataTable({
        /* "dom": '<"pull-left"f><"pull-right"l>tip', */
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
});
</script>

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
    <table class="table table-bordered other-ajax">
        <thead>
            <tr>
                <th>Sl.No</th>
                <th>Task Title</th>
                <th>Submitted By</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Total Working Hours (9hrs/day)</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($reports) && count($reports) > 0)
            @foreach($reports as $key=>$report)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $report->title }}</td>
                <td>{{ getUserName($report->created_by) }} </td>
                <td>{{ date('d-m-Y h:i A',strtotime($report->start_date)) }}</td>
                <td>{{ date('d-m-Y h:i A',strtotime($report->end_date)) }}</td>
                <td>{{ calHours($report->start_date,$report->end_date) }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var tablerepo = $('.other-ajax').DataTable({
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

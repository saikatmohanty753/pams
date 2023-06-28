@extends('./layout/main')
@section('content')
<link href="{{ url('assets/css/layers/dark-layer.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
<style>
    .bg-bluz {background-color: #0d6efd !important; }
.d-flex { display: flex; gap: 25px; }
canvas#geoChart { max-height: 170px; }
.panel-heading h4 { font-size: 21px; line-height: 21px; margin: 0; padding: 0; text-transform: uppercase; text-align: center; font-weight: 900; }
.user-tasks .table td, .user-tasks .table>tbody>tr>td, .user-tasks .table>tbody>tr>th, .user-tasks .table>thead>tr>th { padding: 9px 6px !important; }
.task-status { width: 110px; height: 90px; box-sizing: border-box; border-radius: 50%; text-align: center; line-height: 90px; font-size: 21px; margin: 15px auto; color: #ECECEC; font-weight: 900; }
.panel > .bg-success { margin: 0; padding: 15px 0; border-radius: 4px 4px 0 0;}
canvas#processChart, canvas#myChart {min-height:200px; max-height: 210px; }
.all-tasks div[class*="col-"] .panel { min-height: 252px !important; display: block; }

@media (min-width:990px){
    .maxh-42vh { max-height: 42vh!important; overflow: hidden; }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="page-title">
    <h3 class="breadcrumb-header">Dashboard</h3>
</div>
<div class="row">
    <div class="col-md-6" style="float: right">
        @include('alert_message')
    </div>
</div>

<div id="main-wrapper">
    <div class="maxh-42vh w-100 all-tasks">
        <div id="total-count"></div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">TASK UPDATES</div>
                <div class="panel-body" id="task-update-graph">

                </div>
            </div>
        </div>
    </div>

    <div class="w-100 maxh-42vh">
        <div class="col-md-5">
            <div class="panel panel-danger">
                <div class="panel-heading  text-center">Status of Projects</div>
                <div class="panel-body" id="project-status">

                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading  text-center">Department-Wise Task Status</div>
                <div class="panel-body" id="dept-wise-task">

                </div>
            </div>
        </div>
    </div>
</div>




<script>
$(document).ready(function(){
    totalCount();
})
// PIE CHART

function totalCount()
{
    var url = "{{ route('total-count-task') }}";
    var src = "{{ asset('assets/images/loader.gif') }}";
    $.ajax({
        url:url,
        type:"GET",
        data: {"_token":"{{ csrf_token() }}"},
        dataType:"JSON",
        success:function(res)
        {
            $('#total-count').html(res);
        }
    });
    taskUpdates();
}

function taskUpdates()
{
    var url = "{{ route('task-wise-updates') }}";
    var src = "{{ asset('assets/images/loader.gif') }}";
    $.ajax({
        url:url,
        type:"GET",
        data: {"_token":"{{ csrf_token() }}"},
        dataType:"JSON",
        beforeSend:function(){
            $('#task-update-graph').html('<span><img src='+src+' width="50" height="50"> <strong> Loading ...</strong></span>');
        },
        success:function(res)
        {
            $('#task-update-graph').html(res);
        }
    });
    projectStatus();
}

function deptTaskStatus()
{
    var url = "{{ route('dept-wise-task') }}";
    var src = "{{ asset('assets/images/loader.gif') }}";
    $.ajax({
        url:url,
        type:"GET",
        data: {"_token":"{{ csrf_token() }}"},
        dataType:"JSON",
        beforeSend:function(){
            $('#dept-wise-task').html('<span><img src='+src+' width="50" height="50"> <strong> Loading ...</strong></span>');
        },
        success:function(res)
        {
            $('#dept-wise-task').html(res);
        }
    });
}

function projectStatus()
{
    var url = "{{ route('project-status-graph') }}";
    var src = "{{ asset('assets/images/loader.gif') }}";
    $.ajax({
        url:url,
        type:"GET",
        data: {"_token":"{{ csrf_token() }}"},
        dataType:"JSON",
        beforeSend:function(){
            $('#project-status').html('<span><img src='+src+' width="50" height="50"> <strong> Loading ...</strong></span>');
        },
        success:function(res)
        {
            $('#project-status').html(res);
        }
    });
    deptTaskStatus();
}
</script>
@endsection

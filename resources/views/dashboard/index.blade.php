@extends('./layout/main')
@section('content')
<link href="{{ url('assets/css/layers/dark-layer.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
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
        <div class="col-md-2">
            <div class="panel panel-success">
                <h4 class="bg-success text-center">MY TASKS</h4>
                <div class="panel-body">
                    <div class="task-status bg-success"><span>11/15</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-success text-center">
                <h4 class="bg-success text-center">TEAM TASKS</h4>
                <div class="panel-body">
                    <div class="task-status bg-danger"><span>9/11</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-success">
                <h4 class="bg-success text-center">OBSERVATION</h4>
                <div class="panel-body">
                    <div class="task-status  bg-bluz"><span>2/3</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">TASK UPDATES</div>
                <div class="panel-body">
                    <canvas id="geoChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 maxh-42vh">
        <div class="col-md-5">
            <div class="panel panel-danger">
                <div class="panel-heading  text-center">Status of Projects</div>
                <div class="panel-body">
                    <canvas id="processChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading  text-center">Department-Wise Task Status</div>
                <div class="panel-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script>
// PIE CHART
const cty = document.getElementById('geoChart');
new Chart(cty, {
    type: 'pie',
    data: {
    labels: ['My Tasks','Team Tasks', 'Observations'],
    datasets: [{
        label: '# of Votes',
        data: [15, 11, 3],
        borderWidth: 1
    }]
    },
    options: {
    maintainAspectRatio: false,
    scales: {
        y: {
        beginAtZero: true
        }
    }
    }
});


var barChartData = {
  labels: ["SALES", "PRE-SALES", "PRODUCTION", "QUALITY", "FINANCE", "HR", ],
  datasets: [
    {
      label: "Total",
      backgroundColor: "#3498DB",
      borderColor: "grey",
      borderWidth: 1,
      data: [45,40,29,25,52,92]
    },
    {
      label: "Completed",
      backgroundColor: "#F39C12",
      borderColor: "grey",
      borderWidth: 1,
      data: [39,27,25,24,31,47]
    }
  ]
};



var chartOptions = {
maintainAspectRatio: false,
  responsive: true,
  legend: {
    position: "top"
  },
  title: {
    display: true,
    text: "Chart.js Bar Chart"
  },
  scales: {
    yAxes: [{
      ticks: {
        beginAtZero: true
      }
    }]
  }
}

window.onload = function() {
  var ctx = document.getElementById("myChart").getContext("2d");
  window.myBar = new Chart(ctx, {
    type: "bar",
    data: barChartData,
    options: chartOptions
  });
};



// DONOUT CHART
const ctz = document.getElementById('processChart');
new Chart(ctz, {
    type: 'doughnut',
    data: {
        labels: ['RFP','DPR', 'AGMT', 'SRS', 'DEV', 'QA', 'UAT', 'LIVE'],
        datasets: [{
            label: '# of Votes',
            data: [15, 11, 3, 15, 11, 3, 33, 44],
            borderWidth: 1
        }]
},
options: {
    maintainAspectRatio: false,
    scales: {
        y: {
            beginAtZero: true
        }
    }
}
});

  </script>
@endsection

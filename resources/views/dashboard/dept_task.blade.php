<canvas id="myChart"></canvas>

<script>
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

var ctx = document.getElementById("myChart").getContext("2d");
window.myBar = new Chart(ctx, {
  type: "bar",
  data: barChartData,
  options: chartOptions
});

</script>

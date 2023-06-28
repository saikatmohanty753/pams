<canvas id="processChart"></canvas>

<script>
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

<canvas id="geoChart"></canvas>

<script>
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
</script>

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// color highest magnitude display
function magnitudeColor(mag) {
    if (mag < 5.5) return 'text-white';
    if (mag <= 6.9) return 'text-yellow-400';
    return 'text-red-500';
}

document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('chart');
    console.log("canvas was here");
    let chart = null;
    let locations = [];

    if (canvas) {
        const labels = JSON.parse(canvas.dataset.labels);
        const magnitudes = JSON.parse(canvas.dataset.magnitudes).map(Number);
        locations = JSON.parse(canvas.dataset.locations);

        chart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Magnitude',
                    data: magnitudes,
                    borderColor: '#ffffff',
                    backgroundColor: 'rgba(255,255,255,0.05)',
                    tension: 0,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            afterBody: function(context) {
                                const index = context[0].dataIndex;
                                return 'Location: ' + (locations[index] ?? 'Unknown');
                            }
                        }
                    }
                },
                scales: {
                    x: { ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                    y: { ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                }
            }
        });
    }
    window.Echo.channel('earthquakes').listen('EarthquakeCreated', (e) => {
        console.log('New earthquake received', e);

        if (!chart) return;

        const filter = canvas.dataset.filter;
        const time = new Date(e.occured_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit'});

        chart.data.labels.push(time);
        chart.data.datasets[0].data.push(Number(e.magnitude));
        locations.push(e.location);

        const limit = filter === 'all' ? 200 : 15;
        if (chart.data.labels.length > limit) {
            chart.data.labels.shift();
            chart.data.datasets[0].data.shift();
            locations.shift();
        }
        chart.update('none');

        // update highest magnitude display
        const currentMax = parseFloat(document.getElementById('max-magnitude').textContent);
        const newMag = Number(e.magnitude);
        if (newMag > currentMax) {
            const maxMagEl = document.getElementById('max-magnitude');

            maxMagEl.textContent = newMag.toFixed(1);
            document.getElementById('max-location').textContent = e.location;

            maxMagEl.classList.remove('text-white', 'text-yellow-400', 'text-red-500');
            maxMagEl.classList.add(magnitudeColor(newMag));
        }
    });
});

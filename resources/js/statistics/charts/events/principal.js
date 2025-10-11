import Chart from "chart.js/auto";

// variable global para almacenar la instancia del chart
let placesChartInstance = null;

export function mainChart(placesData) {
    const labels = placesData.map((item) => item.place);
    const data = placesData.map((item) => item.total);
    const colors = placesData.map((item) => item.color);

    const ctx = document.getElementById("placesChart").getContext("2d");

    // Si ya existe el gráfico → destruirlo
    if (placesChartInstance) {
        placesChartInstance.destroy();
    }

    // Crear el nuevo gráfico
    placesChartInstance = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Num. de eventos",
                    data: data,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true },
            },
            scales: {
                x: {
                    ticks: { display: false },
                    grid: { drawTicks: false },
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 10 },
                },
            },
        },
    });
}

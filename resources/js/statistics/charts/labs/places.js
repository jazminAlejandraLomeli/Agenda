import Chart from "chart.js/auto";

// variable global para almacenar la instancia del chart
let placesChartInstance = null;

export function placesChart(placesData) {
    const labels = placesData.map((item) => item.place);
    const data = placesData.map((item) => item.total);
    const colors = placesData.map((item) => item.color);

    const ctx = document.getElementById("places").getContext("2d");

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
                title: {
                    display: true,
                    text: "Reservación de laboratorios",
                    color: "black",
                    font: {
                        size: 18,
                       //  family: "tahoma",
                        weight: "bolder",
                        //  style: "italic",
                    },
                },

                subtitle: {
                    display: true,
                    text: "Reservaciones del año actual",
                    color: "#cc5500",
                    font: {
                        size: 12,
                        //  family: "tahoma",
                        weight: "normal",
                        //  style: "italic",
                    },
                    padding: {
                        bottom: 10,
                    },
                },

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

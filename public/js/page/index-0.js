var statistics_chart = document.getElementById("myChart").getContext("2d");

var myChart = new Chart(statistics_chart, {
    type: "line",
    data: {
        labels: [
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "11",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17",
            "18",
            "19",
            "20",
            "21",
            "22",
            "23",
            "24",
            "25",
            "26",
            "27",
            "28",
            "29",
            "30",
            "31",
        ],
        datasets: [
            {
                label: "Stok Masuk",
                data: [
                    100, 120, 80, 150, 200, 180, 120, 160, 140, 200, 180, 220,
                    250, 180, 200, 220, 190, 210, 180, 200, 220, 250, 180, 200,
                    220, 190, 210, 180, 200, 220, 250,
                ],
                borderWidth: 5,
                borderColor: "#6777ef",
                backgroundColor: "transparent",
                pointBackgroundColor: "#fff",
                pointBorderColor: "#6777ef",
                pointRadius: 4,
            },
            {
                label: "Stok Keluar",
                data: [
                    80, 100, 70, 120, 150, 130, 100, 120, 110, 140, 120, 160,
                    180, 140, 150, 170, 140, 160, 130, 150, 170, 180, 140, 150,
                    170, 140, 160, 130, 150, 170, 180,
                ],
                borderWidth: 5,
                borderColor: "#ff5733",
                backgroundColor: "transparent",
                pointBackgroundColor: "#fff",
                pointBorderColor: "#ff5733",
                pointRadius: 4,
            },
        ],
    },
    options: {
        legend: {
            display: true,
        },
        scales: {
            yAxes: [
                {
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: 50,
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: {
                        color: "#fbfbfb",
                        lineWidth: 2,
                    },
                },
            ],
        },
    },
});

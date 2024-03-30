<script>
    // get colors array from the string
    function getChartColorsArray(chartId) {
        if (document.getElementById(chartId) !== null) {
            var colors = document.getElementById(chartId).getAttribute("data-colors");
            if (colors) {
                colors = JSON.parse(colors);
                return colors.map(function(value) {
                    var newValue = value.replace(" ", "");
                    if (newValue.indexOf(",") === -1) {
                        var color = getComputedStyle(document.documentElement).getPropertyValue(
                            newValue
                        );
                        if (color) return color;
                        else return newValue;
                    } else {
                        var val = value.split(",");
                        if (val.length == 2) {
                            var rgbaColor = getComputedStyle(
                                document.documentElement
                            ).getPropertyValue(val[0]);
                            rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                            return rgbaColor;
                        } else {
                            return newValue;
                        }
                    }
                });
            } else {
                console.warn('data-colors Attribute not found on:', chartId);
            }
        }
    }

// Convert appointment counts data to series and labels arrays
var series = {!! json_encode($appointmentCounts->pluck('count')) !!};
var labels = {!! json_encode($appointmentCounts->pluck('appointment')) !!};

// Get all distinct appointment types
var allAppointmentTypes = {!! json_encode($allAppointmentTypes) !!};

// Iterate over appointment types and check if they exist in the counts data
allAppointmentTypes.forEach(function(appointmentType, index) {
    if (!labels.includes(appointmentType)) {
        // If appointment type doesn't exist in the counts data, add it with count 0
        labels.push(appointmentType);
        series.push(0);
    }
});

// Pie chart
var pieChartColors = getChartColorsArray("appointment_chart");
if (pieChartColors) {
    var options = {
        chart: {
            height: 320,
            type: 'pie',
        },
        series: series,
        labels: labels,
        colors: pieChartColors,
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            verticalAlign: 'middle',
            floating: false,
            fontSize: '14px',
            offsetX: 0,
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: false
                },
            }
        }]
    };

    var chart = new ApexCharts(
        document.querySelector("#appointment_chart"),
        options
    );

    chart.render();
}

    // Pie chart for status counts
    var statusPieChartColors = getChartColorsArray("status_chart");
    if (statusPieChartColors) {
        var statusChartOptions = {
            chart: {
                height: 320,
                type: 'pie',
            },
            series: {!! json_encode($statusCounts->pluck('count')) !!},
            labels: {!! json_encode($statusCounts->pluck('applicant_role_status')) !!},
            colors: statusPieChartColors,
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '14px',
                offsetX: 0,
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]
        };

        var statusChart = new ApexCharts(
            document.querySelector("#status_chart"),
            statusChartOptions
        );

        statusChart.render();
    }

    // Pie chart for vehicle registration status counts
    var vehicleStatusPieChartColors = getChartColorsArray("vehicle_status_chart");
    if (vehicleStatusPieChartColors) {
        var vehicleStatusChartOptions = {
            chart: {
                height: 320,
                type: 'pie',
            },
            series: {!! json_encode($vehicleStatusCounts->pluck('count')) !!},
            labels: {!! json_encode($vehicleStatusCounts->pluck('registration_status')) !!},
            colors: vehicleStatusPieChartColors,
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '14px',
                offsetX: 0,
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]
        };

        var vehicleStatusChart = new ApexCharts(
            document.querySelector("#vehicle_status_chart"),
            vehicleStatusChartOptions
        );

        vehicleStatusChart.render();
    }

   // Pie chart for user role counts
var userRolePieChartColors = getChartColorsArray("user_chart");
if (userRolePieChartColors) {
    var userRoleChartOptions = {
        chart: {
            height: 320,
            type: 'pie',
        },
        series: {!! json_encode($roleCounts->pluck('count')) !!},
        labels: {!! json_encode($roleCounts->pluck('role')) !!},
        colors: userRolePieChartColors,
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            verticalAlign: 'middle',
            floating: false,
            fontSize: '14px',
            offsetX: 0,
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: false
                },
            }
        }]
    };

    var userRoleChart = new ApexCharts(
        document.querySelector("#user_chart"),
        userRoleChartOptions
    );

    userRoleChart.render();
}

</script>
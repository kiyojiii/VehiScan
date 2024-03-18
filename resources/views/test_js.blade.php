
<script>
    function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t)
                return (t = JSON.parse(t)).map(function(e) {
                    var t = e.replace(" ", "");
                    if (-1 === t.indexOf(",")) {
                        var r = getComputedStyle(document.documentElement).getPropertyValue(
                            t
                        );
                        return r || t;
                    }
                    var o = e.split(",");
                    return 2 != o.length ?
                        t :
                        "rgba(" +
                        getComputedStyle(document.documentElement).getPropertyValue(
                            o[0]
                        ) +
                        "," +
                        o[1] +
                        ")";
                });
            console.warn("data-colors Attribute not found on:", e);
        }
    }

    var options,
        chart,
        donutChartColors = getChartColorsArray("donut_chart");
    donutChartColors &&
        ((options = {
                chart: {
                    height: 320,
                    type: "donut"
                },
                series: <?= json_encode($series) ?>,
                labels: <?= json_encode($labels) ?>,
                colors: donutChartColors,
                legend: {
                    show: true,
                    position: "bottom",
                    horizontalAlign: "center",
                    verticalAlign: "middle",
                    floating: false,
                    fontSize: "14px",
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
                        }
                    },
                }, ],
            }),
            (chart = new ApexCharts(
                document.querySelector("#donut_chart"),
                options
            )).render());
</script> 
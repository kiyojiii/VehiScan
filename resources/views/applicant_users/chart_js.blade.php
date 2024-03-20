<script>
    function getChartColorsArray(e) {
  if (null !== document.getElementById(e)) {
    var t = document.getElementById(e).getAttribute("data-colors");
    if (t)
      return (t = JSON.parse(t)).map(function (e) {
        var t = e.replace(" ", "");
        if (-1 === t.indexOf(",")) {
          var r = getComputedStyle(document.documentElement).getPropertyValue(
            t
          );
          return r || t;
        }
        var o = e.split(",");
        return 2 != o.length
          ? t
          : "rgba(" +
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

var lineChartDatalabelColors = getChartColorsArray("user_dashboard_chart");
lineChartDatalabelColors &&
  ((options = {
    chart: {
      height: 380,
      type: "line",
      zoom: { enabled: !1 },
      toolbar: { show: !1 },
    },
    colors: lineChartDatalabelColors,
    dataLabels: { enabled: !1 },
    stroke: { width: [3, 3], curve: "straight" },
    series: [
      { name: "Time In", data: [26, 24, 32, 36, 33, 31, 33] },
      { name: "Time Out", data: [14, 11, 16, 12, 17, 13, 12] },
    ],
    title: {
      text: "Weekly Time Chart",
      align: "left",
      style: { fontWeight: "500" },
    },
    grid: {
      row: { colors: ["transparent", "transparent"], opacity: 0.2 },
      borderColor: "#f1f1f1",
    },
    markers: { style: "inverted", size: 6 },
    xaxis: {
      categories: ["Mon", "Tue", "Wed", "Thurs", "Fri", "Sat", "Sun"],
      title: { text: "Day" },
    },
    yaxis: { title: { text: "Time" }, min: 5, max: 40 },
    legend: {
      position: "top",
      horizontalAlign: "right",
      floating: !0,
      offsetY: -25,
      offsetX: -5,
    },
    responsive: [
      {
        breakpoint: 600,
        options: { chart: { toolbar: { show: !1 } }, legend: { show: !1 } },
      },
    ],
  }),
  (chart = new ApexCharts(
    document.querySelector("#user_dashboard_chart"),
    options
  )).render());
</script>
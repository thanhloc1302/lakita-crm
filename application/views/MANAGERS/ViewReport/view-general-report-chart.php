<div class="row">
    <h2 class="text-center"> BÁO CÁO MARKETING LŨY KẾ </h2>
    <div id="chart_div" style="width: 1200px; height: 500px;"></div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable
                ([['X', 'Thực đạt', 'KPI'],
<?php
foreach ($period as $dayName => $C3) {
    echo "['$dayName', $C3, 38],";
}
?>
                ]);
        var view = new google.visualization.DataView(data);
         view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
        var options = {
            vAxis: {title: 'Số C3'},
            hAxis: {title: 'Ngày'},
            series: {
                0: {type: 'bars'},
                1: {type: 'lines'}
            }
        };
        
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(view, options);
    }

</script>

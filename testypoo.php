<script src="assets/js/d3.v2.min.js"> </script>

<script src="assets/js/sm/column-chart.js"> </script>
<style>

.chart rect {
  stroke: white;
  fill-opacity: .6;
  fill: steelblue;

}
.bar.positive {
  fill: steelblue;
}

.bar.negative {
  fill: brown;
}

.axis text {
  font: 10px sans-serif;
}

.axis path, .axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}


</style>

<script>
//chart = ggchart();
//d3.select("#chartarea").call(chart);

var data = [["A",0.012], ["B",-0.025], ["C",0.008], ["D",0.023], ["E",-0.009], ["F", 0.005]];


d3.select("#chartarea")
  .datum(data)
    .call(columnChart()
      .width(200)
      .height(200)
      .x(function(d, i) { return d[0]; })
      .y(function(d, i) { return d[1]; }));

</script>

<div id="chartarea" class="grid-6"></div>


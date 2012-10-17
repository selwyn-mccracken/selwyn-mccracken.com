<script src="assets/js/d3.v2.min.js"> </script>
<script src="assets/js/sm/ggchart.js"> </script>

<script src="assets/js/jquery-ui.min.js"> </script>
<link href="assets/css/jquery-ui.css" rel="stylesheet"/>

<style type="text/css">
.ui-slider-horizontal .ui-state-default {background: white url("assets/css/images/ui-icons_228ef1_256x240.png") no-repeat scroll 60% 0%;}
</style>

<style type="text/css">

rect {
  fill: #ddd;
}

.grid line {
  stroke: #fff;
}

.grid line.minor {
  stroke-width: .5px;
}

.grid text {
  display: none;
}

.axis line {
  stroke: #000;
}

.grid path {
  display: none;
}

.axis path {
  display: none;
}

</style>

<script>

$(function()
{
    //slider set-up
    $( "#slider-horizontal" ).slider({
	orientation: "horizontal",
        range: "min",
        min: 1,
        max: 49,
        value: 20,
        slide: function( event, ui ) {
            console.log(ui.value);
        }
    });


    dummydata = {
	pathdata: [
	    [{x:0,y:0},{x:0.5,y:.5},{x:1,y:.5}],
	    [{x:0,y:1},{x:.5,y:.5},{x:0,y:1}]
	],
	starting_points: [{x:0,y:0}, {x:0,y:1}]
    };

    dummydata2 = {
	pathdata: [
	    [{x:.5,y:1},{x:0.5,y:0},{x:1,y:.5}],
	    [{x:1,y:0},{x:.1,y:.5},{x:1,y:1}]
	],
	starting_points: [{x:.5,y:1}, {x:1,y:0}]
    };


    
    chart = ggchart();

    d3.selectAll(".poo")
	.datum([dummydata,dummydata2])
	.call(chart);//.margin({top: 10, right: 10, bottom: 50, left: 50}));


    firstpath = d3.select('.line')
    p1 = firstpath.node()
 /*   p1.getPointAtLength(3)
    var totlen = p1.getTotalLength();
    var point = d3.select('.point')
    point.attr('cx',p1.getPointAtLength(totlen * .80).x)
    point.attr('cy',p1.getPointAtLength(totlen * .80).y)
*/

var point = d3.select('.point');

function transition() {
  point.transition()
      .duration(5000)
      .attrTween("transform", translateAlong(firstpath.node()))
      .each("end", transition);
}


    function translateAlong(path) {
	var l = path.getTotalLength();
	return function(d, i, a) {
	    return function(t) {
		var p = path.getPointAtLength(t * l);
		return "translate(" + p.x + "," + p.y + ")";
	    };
	};
}


});


</script>

<div id="page-title">

  <h1>ggplot2 style facets with D3 </h1>		
      
</div> <!-- /page-title -->

<div class="container">
  <div class="row">
    <div id="chartarea" class="grid-6 poo"></div>
    <div id="chartarea" class="grid-6 poo"></div>
  </div>
  <div class="row">
    <div id="slider-horizontal" style="width: 250px;" class="grid-12"></div> 
  </div>
</div>    


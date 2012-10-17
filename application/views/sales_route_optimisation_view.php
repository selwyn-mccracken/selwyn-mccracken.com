<script src="assets/js/d3.v2.min.js"> </script>

<script src="assets/js/jquery-ui.min.js"> </script>
<link href="assets/css/jquery-ui.css" rel="stylesheet"/>

<script src="assets/js/sm/ggchart2.js"> </script>

<style type="text/css">
.ui-slider-vertical .ui-state-default {background: white url("assets/css/images/ui-icons_228ef1_256x240.png") no-repeat scroll 53.3% 0%;}
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

.line {
    stroke:red;
}
</style>

<div id="page-title">

  <h1>Sales route optimisation </h1>		
      
</div> <!-- /page-title -->

    <div class="container">
      <div class="row">
	<div id="chartarea" class="grid-6"></div>
	<div id="controlarea" class="grid-1">
	  <p>
            <label for="amount">Number of Stops:</label>
            <input type="text" id="amount" style="border: 0; color: #f6931f; font-weight: bold;" />
	  </p>
 
	  <div id="slider-vertical" style="height: 250px;"></div> 
	</div>
	<div id="linechart" class="grid-5">
     
	</div>
      </div>
    </div>


<script type="text/javascript">
var _g = {
    circle_scale_factor:100,
    start_route:20,
    linechart: ggchart()
	.xScale(d3.scale.linear().domain([0, 50]))
	.yScale(d3.scale.linear().domain([0, 65]))
	.height(400).width(400)
	.interpolate('basis')
}

var xy_projection = d3.geo.albers().origin([12.5,55]).translate([200, 150]);
xy_projection.scale(600);

var path = d3.geo.path().projection(xy_projection);

var svg = d3.select("#chartarea")
    .append("svg")
    .attr("width", 400)
    .attr("height", 400);

var countries = svg.append("g")
     .attr("id", "countries");


var route = d3.svg.line()
    .x(function(d){return xy_projection([d.Longitude,d.Latitude])[0];})
    .y(function(d){return xy_projection([d.Longitude,d.Latitude])[1];})
    .interpolate("linear");
 

//route transition function
function change_route(route_id) {
    var newData =  _g.routes.filter(function(i){return i.id == route_id;} )
    
    countries.selectAll("path.route")
        .data(newData)
        .transition()
        .ease('exp')//.ease('bounce')
        .duration(1000)
        .attr("d", route(newData));
}
    
//TODO - add graticules when it gets merged into d3 main
//var graticule = d3.geo.graticule()
  //  .step([10, 10]);

    
$(function() {

//    make_line_chart() ;

  
pth2 = [
    [ { "x" : 0, "key" : "Revenue", "y" : 10.705 }, { "x" : 1, "key" : "Revenue", "y" : 16.048 }, { "x" : 2, "key" : "Revenue", "y" : 19.38 }, { "x" : 3, "key" : "Revenue", "y" : 22.71 }, { "x" : 4, "key" : "Revenue", "y" : 25.853 }, { "x" : 5, "key" : "Revenue", "y" : 28.497 }, { "x" : 6, "key" : "Revenue", "y" : 31.028 }, { "x" : 7, "key" : "Revenue", "y" : 32.793 }],
    [ { "x" : 35, "key" : "Profit", "y" : 14.6527606753479 }, { "x" : 36, "key" : "Profit", "y" : 11.5659792597193 }, { "x" : 37, "key" : "Profit", "y" : 5.70461327879051 }, { "x" : 38, "key" : "Profit", "y" : 14.1991822016556 }, { "x" : 39, "key" : "Profit", "y" : 14.3254279428087 }, { "x" : 40, "key" : "Profit", "y" : 6.84316983140512 }, { "x" : 41, "key" : "Profit", "y" : 13.8005558715188 }, { "x" : 42, "key" : "Profit", "y" : 6.83941710795572 }, { "x" : 43, "key" : "Profit", "y" : 15.3439136719832 }, { "x" : 44, "key" : "Profit", "y" : 9.95043253938967 }, { "x" : 45, "key" : "Profit", "y" : 17.413859646193 }, { "x" : 46, "key" : "Profit", "y" : 18.5064108756967 }, { "x" : 47, "key" : "Profit", "y" : 8.65038164773931 }, { "x" : 48, "key" : "Profit", "y" : 8.34449539993991 }, { "x" : 49, "key" : "Profit", "y" : 14.4019398828926 } ]
];

dummydata = {
	pathdata:pth2,
	points: [{x:0,y:0}, {x:0,y:1}]
    };


/*    dummydata = {
	pathdata: [
	    [{x:0,y:0},{x:0.5,y:.5},{x:1,y:.5}],
	    [{x:0,y:1},{x:.5,y:.5},{x:0,y:1}]
	],
	points: [{x:0,y:0}, {x:0,y:1}]
    };

    dummydata2 = {
	pathdata: [
	    [{x:.5,y:1},{x:0.5,y:0},{x:1,y:.5}],
	    [{x:1,y:0},{x:.1,y:.5},{x:1,y:1}]
	],
	points: [{x:.5,y:1}, {x:1,y:0}]
    };
*/

    var linechart = ggchart()
	.xScale(d3.scale.linear().domain([0, 50]))
	.yScale(d3.scale.linear().domain([0, 60]))
	.height(400).width(400)
    

    d3.select('#linechart').datum(dummydata).call(_g.linechart);
    
    //slider set-up
    $( "#slider-vertical" ).slider({
	orientation: "vertical",
        range: "min",
        min: 1,
        max: 49,
        value: _g.start_route,
        slide: function( event, ui ) {
            $( "#amount" ).val( ui.value );
            change_route(ui.value);
        }
    });

    $( "#amount" ).val( $( "#slider-vertical" ).slider( "value" ) );
        
    //map stuff
    d3.json("assets/data/western_europe.json",function(data) {
	countries.selectAll('path')
	    .data(data.features)
	    .enter().append("path")
	    .attr("d", path)
	    .style('fill','lightsteelblue')
	    .style('stroke','white');
       
       //get the cities and plot as circles on the map - area sized by value
	d3.json("assets/data/sales-route-cities.json",function(data) {

            _g.cities = data;

         countries.selectAll('circle.city')
             .data(data).enter().append('circle').attr('class','city')
             .attr("transform", function(d) { return "translate(" + xy_projection([d.Longitude,d.Latitude]) + ")"; })
             .style('opacity',0.5)
             .style('fill','red')
             .attr('r',function(d) {
               var val = Math.sqrt((d.Value * _g.circle_scale_factor)/Math.PI);
               return val;})
                          .each(function(d){
               //Popover content - try tipsy instead http://bl.ocks.org/1373263
               $(this).popover({'title':d.City, 'content': 'Anticipate revenue: $' + d.Value + 'm'})//.popover('show')
             })
//.style('pointer-events','none')

       });

       //fetch the routes and 
      d3.json("assets/data/sales-routes.json",function(data) {
      
         _g.routes = data;

         _g.current_route = countries.append("svg:path").classed("route", true)
            .attr("d", route(data.filter(function(i){return i.id == _g.start_route;} )))
            .style("stroke-width", 2)
            .style("stroke", "steelblue")
            .style("fill", "none");
         
       })

});
  });


var xx = null;
function make_line_chart() {
    xx = $.getJSON("assets/data/sales-routes-profits.json",function(data) {
	//console.log(data);
	var result = [];
	var linecolours = {'Revenue':'red','Costs':'green','Profit':'blue'};
    
	var linetypes = ['Revenue','Costs','Profit'];

	linetypes.map(function(i){
	    result.push(
		{
		    points: [{x:0,y:0.5}, {x:0,y:1}],
		    pathdata: data.filter(function(j){return j.key == i;}),
                    key: i,
                    colour: linecolours[i]
		}
	    );
	})

	_g.line_chart_data = result;
	console.log(result)
	d3.select("#linechart")
	    .datum(result)
	    .call(_g.linechart)
   

  })

}


  
</script>

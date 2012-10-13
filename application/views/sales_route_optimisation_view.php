<script src="assets/js/d3.v2.min.js"> </script>

<script src="assets/js/jquery-ui.min.js"> </script>
<link href="assets/css/jquery-ui.css" rel="stylesheet"/>

<script src="assets/js/nv.d3.js"> </script>
<link href="assets/css/nv.d3.css" rel="stylesheet"/>

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

#linechart path {
  display: none;
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
 
      <div id="slider-vertical" style="height: 250px;"></div> <!-- icon-sort  class="ui-icon-arrowthick-2-n-s" -->
    </div>
    <div id="linechart" class="grid-5">
     
    </div>
  </div>
</div>


<script type="text/javascript">
var _g = {
  circle_scale_factor:100,
  start_route:20
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
    get_line_chart_data()

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

       //  _g.cities = data;

         countries.selectAll('circle.city')
             .data(data).enter().append('circle').attr('class','city')
             .attr("transform", function(d) { return "translate(" + xy_projection([d.Longitude,d.Latitude]) + ")"; })
             .style('opacity',0.5)
             .style('fill','red')
             .attr('r',function(d) {
               var val = Math.sqrt((d.Value * _g.circle_scale_factor)/Math.PI);
               return val;})
                          .each(function(d){
               //Popover content
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


function make_linegraph(linedata){
 // Define identity (1:1) scales
var x = d3.scale.identity().domain([0,450]);
var y = d3.scale.identity().domain([0,300]);
 
// Define container
var chart = d3.select("#linechart")
  .append("svg")
    .attr("class", "chart")
    .attr("width", 400)
    .attr("height", 400)
    .append("g")
      // move 0,0 slightly down and right to accomodate axes
     .attr("transform", "translate(30,20)");
 
// Draw X-axis grid lines
chart.selectAll("line.x")
  .data(x.ticks(10))
  .enter().append("line")
  .attr("class", "x")
  .attr("x1", x)
  .attr("x2", x)
  .attr("y1", 0)
  .attr("y2", 300)
  .style("stroke", "#ccc");
 
// Draw Y-axis grid lines
chart.selectAll("line.y")
  .data(y.ticks(10))
  .enter().append("line")
  .attr("class", "y")
  .attr("x1", 0)
  .attr("x2", 0)
  .attr("y1", y )
  .attr("y2", y )
  .style("stroke", "#ccc");
 
// Define stock x and y axis
var xAxis = d3.svg.axis().scale(x).orient('bottom');
var yAxis = d3.svg.axis().scale(y).orient('left');
 
chart.append('g')
  .attr("class", "axis")
  .call(xAxis);
 
chart.append('g')
  .attr("class", "axis")
  .call(yAxis);
}

function get_line_chart_data() {
  d3.json("assets/data/sales-routes-profits.json",function(data) {
    var result = [];
    var linecolours = {'Revenue':'red','Costs':'green','Profit':'blue'};
    
    var linetypes = ['Revenue','Costs','Profit'];

    linetypes.map(function(i){
      result.push(
      {
        values: data.filter(function(j){return j.key == i;}),
                  key: i,
                  color: linecolours[i]
      }
      )
    }
    )

    _g.line_chart_data = result;

    make_linegraph(result);

  })

}


  
</script>

<script src="assets/js/d3.v2.min.js"> </script>

<script src="assets/js/jquery-ui.min.js"> </script>
<link href="assets/css/jquery-ui.css" rel="stylesheet"/>

<script src="assets/js/sm/ggchart2.js"> </script>

<script type="text/javascript" src="assets/js/jquery.tipsy.js"></script>
<link href="assets/css/tipsy.css" rel="stylesheet" type="text/css" />

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

.line[linekey='Revenue']{ stroke:red;}
.line[linekey='Costs']{ stroke:steelblue;}
.line[linekey='Profit']{ stroke:blue;}

svg {
  font: 10px sans-serif;
}


.popover.top{margin-left:110px;}
.popover.top .arrow{margin-left:-110px;}

.popover-title{padding:0px 0px;line-height:0;background-color:#f5f5f5;border-bottom:1px solid #eee;-webkit-border-radius:3px 3px 0 0;-moz-border-radius:3px 3px 0 0;border-radius:3px 3px 0 0;}
.popover-content{padding:3px;}



</style>

<style>
svg title{
 stroke:red;
 stroke-width: .5px;
    background-color: white;
}
}
</style>


<div id="page-title">

  <h1>Sales route profit optimisation </h1>		
      
</div> <!-- /page-title -->
<p> This is a contrived profit optimisation demonstration for a sales route with approximately fixed costs per kilometer travelled (as the crow flies), for example a touring rock band with a large entourage and roadshow that travels entirely by chartered plane.  </p>
    <div class="container">
      <div class="row">
	<div id="chartarea" class="grid-6"><h4 id="maptitle">Optimised Route.</h4></div>
	<div id="controlarea" class="grid-1">
	  <p>
            <label for="amount" >Number of Stops:</label>
            <!--input type="text"  id="amount" style="border: 0; color: #f6931f; font-weight: bold;" /-->
	    
            <label for="amount"  id="amount" style="color: #f6931f;font-weight:bold" >Number of Stops:</label>
	  </p>
 
	  <div id="slider-vertical" style="height: 250px;"></div> 
	</div>
	<div id="linechart" class="grid-5">
	  <h4>Cumulative Revenue, Costs &amp; Profit vs Stops</h4>
	</div>
      </div>
    </div>


<script type="text/javascript">
var _g = {
    circle_scale_factor:100,
    start_route:16,
    linechart: ggchart()
	.xScale(d3.scale.linear().domain([0, 50]))
	.yScale(d3.scale.linear().domain([0, 65]))
	.height(400).width(400)
	.interpolate('basis')
	.margin( {top: 10, right: 60, bottom: 40, left: 40}),
    linetypes: ['Revenue','Costs','Profit']
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
 
function highlight_chart_circles(nodeid){
    d3.selectAll("#linechart circle").style('fill',function(d){ return d.x <= nodeid ?  'red' : 'blue';});
}

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

    make_line_chart() ;

    $("#maptitle").text("Optimised route: Top " + (parseInt( _g.start_route) + 1) + " most valuable destinations.")
    $("#amount" ).text(  _g.start_route );

    //slider set-up
    $( "#slider-vertical" ).slider({
	orientation: "vertical",
        range: "min",
        min: 1,
        max: 49,
        value: _g.start_route,
        slide: function( event, ui ) {
            $("#amount" ).text( ui.value );
	    $("#maptitle").text("Optimised route: Top " + (parseInt(ui.value) + 1) + " most valuable destinations.")
            change_route(ui.value);
	    highlight_chart_circles(ui.value);
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
		.append("svg:title")
		.text(function(d) { return d.City + ' - Anticipated revenue: $' + d.Value + 'm'; });
                     /*     .each(function(d){
               //Popover content - try tipsy instead http://bl.ocks.org/1373263
               $(this).popover({'title':d.City, 'content': 'Anticipated revenue: $' + d.Value + 'm'})//.popover('show')
             })
*/


       });

       //fetch the routes and display
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


function make_line_chart() {
    var linecolours = {'Revenue':'red','Costs':'green','Profit':'blue'};
    //fetch routes and points in separate ajax calls, then creat chart from globally assigned data
    $.when
    (
	//
	$.getJSON("assets/data/sales-routes-profits.json",function(data) {
	    //console.log(data);
	    var linedata = [];    
	   
	    _g.linetypes.map(function(i){
		linedata.push( data.filter(function(j){return j.key == i;}));		
	    })
	    _g.linedata = linedata;
	}),
	$.getJSON("assets/data/sales-route-cities.json",function(data) {
	    //console.log(data);
	    var pointdata = [];    
	    
	    data.map(function(i){
		pointdata.push({x:i.id,y:i.cumrevenue,Value:i.Value,City:i.City})
	    })
	    _g.pointdata = pointdata;
	})
    )
    .then(function(x,y){
	//make the line chart
	result = {
	    pathdata: _g.linedata,
	    points: _g.pointdata,
	    linetype: _g.linetypes
	}
	
	_g.line_chart_data = result;

	d3.select("#linechart")
	    .datum(result)
	    .call(_g.linechart);

	//update the appearance of the various circles

	chartcircles = d3.selectAll('#linechart circle')
            .style('opacity',0.5)
            .style('fill','red')
            .attr('r',function(d) {
               var val = Math.sqrt((d.Value * _g.circle_scale_factor)/Math.PI);
               return val;})
	    .append("svg:title")
	    .text(function(d) { return d.City + ': $' + d.Value + 'm'; });
/*
            .each(function(d){
               //Popover content - try tipsy instead http://bl.ocks.org/1373263
               $(this).popover({'title':d.City, 'content': 'Anticipated revenue: $' + d.Value + 'm'})//.popover('show')
             })
*/
	   
/*tipsy({ 
            gravity: 'w', 
            html: true, 
            title: '<h1>Hi there!</h1>' 
            }
	)
    })*/

	//add axis labels
	//ToDo add to ggchart function
	var svg = d3.select("#linechart svg")
	svg.append("text")
	    .attr("class", "x label")
	    .attr("text-anchor", "end")	    
	    .attr("x",270)
	    .attr("y", 395)
	    .text("Number of Route Stops");

	svg.append("text")
	    .attr("class", "y label")
	    .attr("text-anchor", "end")
	    .attr("y", 6)
	    .attr("dy", ".75em")
	    .attr("transform", "rotate(-90)")
	    .text("Anticipated Revenue ($m)")
	    .attr('x',-100);

	highlight_chart_circles(_g.start_route);

	svg.append("text")
	    .attr("text-anchor", "end")	    
	    .attr("x",350)
	    .attr("y", 300)
	    .text("Cumulative Profit");

	svg.append("text")
	    .attr("text-anchor", "end")	    
	    .attr("x",350)
	    .attr("y", 80)
	    .text("Cumulative Costs");

	svg.append("text")
	    .attr("text-anchor", "end")	    
	    .attr("x",150)
	    .attr("y", 80)
	    .text("Cumulative Revenue");

	//d3.select(".line[linekey='Profit']")
	svg.append("circle")
	    .attr("cx",134)
	    .attr("cy", 272)
	    .attr("x", 16)
	    .attr("r", 5)
	    .style("fill", 'blue')
	    .attr("opacity",0.5)
	    .each(function(d){
		$(this).popover({trigger:'manual','title':'', 'content': 'Maximum profit occurs after 16 stops','placement':'top'}).popover('show')
	    })



    })
}
  
</script>

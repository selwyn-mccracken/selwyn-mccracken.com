// create a reusable ggplot2 style chart template
// based on the axis-ggplot2.html example provided with the d3 src and
// the reusable chart recommendations at http://bost.ocks.org/mike/chart/
//ToDo - http://jsfiddle.net/christopheviau/YPAYz/

function ggchart()
{
  var width = 200, // default width
  height = 200, // default height
  margin = {top: 10, right: 10, bottom: 20, left: 30};

  var w = width - margin.right - margin.left;
  var h = height - margin.top - margin.bottom;

  var xScale = d3.scale.linear()    // .domain([.05, .95])
    .range([0, w]);

  var yScale = d3.scale.linear()
    .range([h,0]);

  var path_interpolate = "linear";

  var pathline = d3.svg.line()
	.interpolate(path_interpolate)
	.x(function(d) { return xScale(d.x); })
	.y(function(d) { return yScale(d.y); });

  function my(selection)
  { // generate chart here, using `width` and `height`
    selection.each
    (function(data,i)
      {

	if (data.length > 1)
	  var data = data[i];

	var svg = d3.select(this).append("svg")
	  .attr("class", 'ggchart')
	  .attr("width", w + margin.right + margin.left)
	  .attr("height", h + margin.top + margin.bottom)
	  .append("g")
	  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	svg.append("rect")
	  .attr('class','plot_background')
	  .attr("width", w)
	  .attr("height", h);

	//create the grid lines across the chart by inverting the tick marks and making then as wide/tall as the width/height
	svg.append("g")
	  .attr("class", "x grid")
	  .attr("transform", "translate(0," + h + ")")
	  .call(d3.svg.axis().scale(xScale).tickSubdivide(1).tickSize(-h));

	svg.append("g")
	  .attr("class", "y grid")
	// .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	  .call(d3.svg.axis().orient('left').scale(yScale).tickSubdivide(1).tickSize(-w));//-width));

	//create the actual display axes
	svg.append("g")
	  .attr("class", "x axis")
	  .attr("transform", "translate(0," + h + ")")
	  .call(d3.svg.axis().scale(xScale));

	svg.append("g")
	  .attr("class", "y axis")
	//.attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	  .call(d3.svg.axis().scale(yScale).orient('left'));

	//add paths
	var pathgroup = svg.append("g");//.selectAll('path.mypath');
	var pathdata = data.pathdata;

	pathgroup.selectAll(".line")
	  .data(pathdata)
	  .enter().append("path")
	  .attr("class", "line")
	  .attr("d", pathline)
	  .style("stroke-width", 2)
          .style("fill", "none");

	//add points at start of path
	var starting_points = data.starting_points;
	svg.selectAll('.point')
	  .data(starting_points)
	  .enter().append("svg:circle")
	  .attr('class','point')
	  .attr('cx',function(d){return  xScale(d.x);})
	  .attr('cy',function(d){return  yScale(d.y);})
	  .attr("r", 6.5);


    }
  );
}

  my.width = function(value) {
    if (!arguments.length) return width;
    width = value;
    w = width - margin.right - margin.left;
    return my;
  };

  my.height = function(value) {
    if (!arguments.length) return height;
    height = value;
    h = height - margin.top - margin.bottom;
    return my;
  };

   my.margin = function(value) {
    if (!arguments.length) return margin;
    margin = value;
    return my;
  };

   my.xScale = function(value) {
    if (!arguments.length) return xScale;
    xScale = value;
    return my;
  };

   my.yScale = function(value) {
    if (!arguments.length) return yScale;
    yScale = value;
    return my;
  };

  return my;
}

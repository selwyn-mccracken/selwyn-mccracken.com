// create a reusable ggplot2 style chart template
// based on the axis-ggplot2.html example provided with the d3 src and
// the reusable chart recommendations at http://bost.ocks.org/mike/chart/
//ToDo - http://jsfiddle.net/christopheviau/YPAYz/

function ggchart()
{
  var width = 400, // default width
  height = 200, // default height
  margin = {top: 10, right: 10, bottom: 20, left: 30};

  var w = width - margin.right - margin.left;
  var h = height - margin.top - margin.bottom;

  var xScale = d3.scale.linear()    // .domain([.05, .95])
    .range([0, w]);

  var yScale = d3.scale.linear()
    .range([h,0]);

  function my(selection)
  { // generate chart here, using `width` and `height`
    selection.each
    (
      function(data)
      {
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

	console.log(w + ' ' + h);

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
	  .call(d3.svg.axis().scale(x));

	svg.append("g")
	  .attr("class", "y axis")
	//.attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	  .call(d3.svg.axis().scale(y).orient('left'));

      }
    );
  }

  my.width = function(value) {
    if (!arguments.length) return width;
    width = value;
    return my;
  };

  my.height = function(value) {
    if (!arguments.length) return height;
    height = value;
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

// create a reusable ggplot2 style chart template
// based on the axis-ggplot2.html example provided with the d3 src and
// the reusable chart recommendations at http://bost.ocks.org/mike/chart/
//and mainly the example at  - http://jsfiddle.net/christopheviau/YPAYz/

/*
    Demo of the d3.js reusable chart pattern using a function to generate the accessors
    As an answer to this question:
    http://stackoverflow.com/questions/11568751/when-will-this-design-pattern-break
    And following the ideas of this thread:
    https://groups.google.com/d/topic/d3-js/2WVlWrLOfhc/discussion
*/

// Chart module
function ggchart() {
  var opts = {
    width: 200,
    height: 200,
    margin: {top: 10, right: 10, bottom: 20, left: 30},
    gap: 10,
    interpolate:"linear",
    xScale:d3.scale.linear().domain([0, 1]),
    yScale:d3.scale.linear().domain([0, 1])
  };

  function exports(selection) {
   // var n_selected = selection.length; //need to know if we are making one chart or several, so the incoming data gets allocated correctly

    selection.each(function (data,i)
		   {
		     var chartW = opts.width - opts.margin.left - opts.margin.right,
		     chartH = opts.height - opts.margin.top - opts.margin.bottom;

		     var xScale = opts.xScale.range([0, chartW]);

		     var yScale = opts.yScale.range([chartH,0]);

		     var pathline = d3.svg.line()
		       .interpolate(opts.interpolate)
		       .x(function(d) { return xScale(d.x); })
		       .y(function(d) { return yScale(d.y); });


//		     if (n_selected > 1)
//		       var data = data[i];

		     var svg = d3.select(this).append("svg")
		       .attr("class", 'ggchart')
		       .attr("width", opts.width)
		       .attr("height", opts.height)
		       .append("g")
		       .attr("transform", "translate(" + opts.margin.left + "," + opts.margin.top + ")");

		     svg.append("rect")
		       .attr('class','plot_background')
		       .attr("width", chartW)
		       .attr("height", chartH);

		     //create the grid lines across the chart by inverting the tick marks and making then as wide/tall as the width/height
		     svg.append("g")
		       .attr("class", "x grid")
		       .attr("transform", "translate(0," + chartH + ")")
		       .call(d3.svg.axis().scale(xScale).tickSubdivide(1).tickSize(-chartH));

		     svg.append("g")
		       .attr("class", "y grid")
		     // .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
		       .call(d3.svg.axis().orient('left').scale(yScale).tickSubdivide(1).tickSize(-chartW));//-width));

		     //create the actual display axes
		     svg.append("g")
		       .attr("class", "x axis")
		       .attr("transform", "translate(0," + chartH + ")")
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
		     var points = data.points;
		     svg.selectAll('.point')
		       .data(points)
		       .enter().append("svg:circle")
		       .attr('class','point')
		       .attr('cx',function(d){return  xScale(d.x);})
		       .attr('cy',function(d){return  yScale(d.y);})
		       .attr("r", 6.5);

		   });
    }

    exports.opts = opts;
    createAccessors(exports);
    return exports;
}


// Accessors generator
function createAccessors(exports) {
  for (var n in exports.opts) {
    if (!exports.opts.hasOwnProperty(n)) continue;
    exports[n] = (function(n) {
		    return function(v) {
                      return arguments.length ? (exports.opts[n] = v, this) : exports.opts[n];
		    };
		  })(n);
  }
};

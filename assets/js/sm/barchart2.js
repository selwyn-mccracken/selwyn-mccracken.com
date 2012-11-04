// create a reusable ggplot2 style barchart template
// based on the axis-ggplot2.html example provided with the d3 src and
// the reusable chart recommendations at http://bost.ocks.org/mike/chart/
//and the example at  - http://jsfiddle.net/christopheviau/YPAYz/

function ggbarchart() {
  var opts = {
    width: 400,
    height: 400,
    margin: {top: 10, right: 30, bottom: 20, left: 60},
    xScale: d3.scale.linear(),
   // axisFormat: "g",
    axisFormat: ".2s",
    yScale: d3.scale.ordinal(),
    transition_duration: 400
  };

  // Modify SI sbbreviations replacing G for B
  function number_suffix(num){
    sival = d3.format('.2s');
    suffixed = sival(num);
    suffixed = suffixed.replace('G','B');
    return suffixed;
  }

  function exports(selection) {
    selection.each(function (data,i)
		   {
		     console.log(data.length);
		     var chartW = opts.width - opts.margin.left - opts.margin.right,
		     chartH = opts.height - opts.margin.top - opts.margin.bottom;
		     var transitionduration = opts.transition_duration;

		     var xScale = opts.xScale
		       .range([0, chartW])
		       .domain([0, d3.max(data.map(function(x) { return Number(x.value); }))]);

		     var yScale = opts.yScale
		       	.domain(data.map(function(x) { return x.label; }))
			.rangeBands([0, chartH], 0.2);

		     var svg = d3.select(this).selectAll("svg").data([data])
		       .enter().append("svg")
		       .attr("class", 'ggbarchart')
		       .attr("width", opts.width)
		       .attr("height", opts.height)
		       .append("g")
		       .attr("transform", "translate(" + opts.margin.left + "," + opts.margin.top + ")");

		     var plotarea = svg.append("rect")
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
		       .call(d3.svg.axis().orient('left').scale(yScale).tickSubdivide(1).tickSize(-chartW));//-width));


		     //create the actual display axes
		     svg.append("g")
		       .attr("class", "x axis")
		       .attr("transform", "translate(0," + chartH + ")")
		       .call(d3.svg.axis().scale(xScale));

		     svg.append("g")
		       .attr("class", "y axis")
		       .call(d3.svg.axis().scale(yScale).orient('left'));

		// Update the bars.
		     //http://stackoverflow.com/questions/10710327/best-way-to-rebind-data-in-d3-js
/*
		     var gbars = svg.select("g.ggbars").data([data])
		       .enter().append("g")
		       .attr("class", '.ggbars');*/

		     bars = svg.selectAll("rect.ggbar")
		       .data(data, function(d) { return d.key; })
		     // New bars.
		       .enter().append("rect")
		       .attr("class", 'ggbar')
			.transition()
			.duration(transitionduration)
			.attr("x", 0)
			.attr("y", function(d, i) { return yScale(d.label); })
			.attr("width", function(d) { return xScale(d.value); })
			.attr("height", yScale.rangeBand())
			.style('fill',function(d){ return d.fill;})
			.attr("key", function(d) { return d.key; })
			.attr("value", function(d) { return d.value; })
			.attr("label", function(d) { return d.label; });

		     // Adjust existing bars
		     bars
			.transition()
			.duration(transitionduration)
			.attr("x", 0)
			.attr("y", function(d, i) { return yScale(d.label); })
			.attr("width", function(d) { return xScale(d.value); })
			//.attr("height",20);
			.attr("height", yScale.rangeBand()) // rangeBand() returns the band width
			.style('fill',function(d){ return d.fill;});


/*
		     // Remove bars.
		     bars.exit()
		       .transition()
		       .duration(transitionduration)
		       .remove();
*/
		     
		// bar labels
		var barlabels = svg.selectAll("text.barlab")
			.data(data, function(d) { return d.key ; });

		// existing labels
		barlabels
			.transition()
			.duration(transitionduration)
			.attr("x", function(d) { return xScale(d.value); })
			.attr("y", function(d, i) { return yScale(d.label) + yScale.rangeBand() / 2; })
			.attr("dx", 2) // padding-left
			.attr("dy", ".35em") // vertical-align: middle
			.attr("text-anchor", "start") // text-align: right
			.text(function(d){return number_suffix(d.value)});

		// new labels
		barlabels
			.enter().append("text")
			.attr("class", "barlab")
			.attr("x", function(d) { return xScale(d.value); })
			.attr("y", function(d, i) { return yScale(d.label) + yScale.rangeBand() / 2; })
			.attr("dx", 2) // padding-left
			.attr("dy", ".35em") // vertical-align: middle
			.attr("text-anchor", "start") // text-align: right
			.text(function(d){return number_suffix(d.value)});

		// remove old labels
		barlabels.exit()
				.attr("opacity", 0)
				.attr("height", 0)
				.attr("width", 0)
				.remove();


		// Update the x-axis.
				 //Omit for the moment - add value labels to each bar instead
		/*
		g.select(".x.axis")
			.transition()
			.duration(transitionduration)
			.attr("transform", "translate(0," + (height - margin.top - margin.bottom) + ")")
			.call(xAxis);
			*/

		// Update the y-axis
		yAxis = d3.svg.axis().scale(yScale).orient("left");

		svg.select(".y.axis")
			.transition()
			.duration(transitionduration)
			.call(yAxis);

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

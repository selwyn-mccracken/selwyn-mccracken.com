// barchart template code, based largely on the example here: http://bost.ocks.org/mike/chart/
function barChart() {
	var margin = {top: 20, right: 20, bottom: 20, left: 20},
		width = 760,
		height = 200,
		xScale = d3.scale.linear(),
		axisformat = "g",
		xAxis = d3.svg.axis().scale(xScale).orient("bottom").tickSize(6, 0),
		yScale = d3.scale.ordinal(),
		transitionduration = 300;

	// Coerce all values to SI sbbreviations, but swapping G for B
	function abbrev_number(val){
		si = d3.format('.2s'); //
		res = si(val);
		//Replace G (Giga) with B for Billion
		res = res.replace('G','B');
		return res;
		}

	function chart(selection) {
		selection.each(function(data) {

		// Update the x-scale (i.e. bar width) based on the data.
		xScale
			.domain([0, d3.max(data.map(function(x) { return Number(x.value); }))])
			.range([0, width - margin.right - margin.left]);

		// Update the y-scale based on the data.
		yScale
			.domain(data.map(function(x) { return x.label; }))
			.rangeBands([0, height - margin.top - margin.bottom], 0.2);

		// Select the svg element, if it exists.
		var svg = d3.select(this).selectAll("svg").data([data]);

		// Otherwise, create the skeletal chart.
		var gEnter = svg.enter().append("svg").append("g");
		gEnter.append("g").attr("class", "x axis");
		gEnter.append("g").attr("class", "y axis");

		// Update the outer dimensions.
		svg
			.attr("width", width)
			.attr("height", height);

		// Update the inner dimensions.
		var g = svg.select("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		// Update the bars.
		var bars = g.selectAll("rect")
			.data(data, function(d) { return d.key; });

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

		// New bars.
		bars.enter().append("rect")
			.attr("class", "mybar")
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

		// Remove bars.
		bars.exit()
			.transition()
			.duration(transitionduration)
				.attr("opacity", 0)
				.attr("height", 0)
				.attr("width", 0)
				.remove();

		// bar labels
		var barlabels = g.selectAll("text.barlab")
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
			.text(function(d){return abbrev_number(d.value)});

		// new labels
		barlabels
			.enter().append("text")
			.attr("class", "barlab")
			.attr("x", function(d) { return xScale(d.value); })
			.attr("y", function(d, i) { return yScale(d.label) + yScale.rangeBand() / 2; })
			.attr("dx", 2) // padding-left
			.attr("dy", ".35em") // vertical-align: middle
			.attr("text-anchor", "start") // text-align: right
			.text(function(d){return abbrev_number(d.value)});

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

		g.select(".y.axis")
			.transition()
			.duration(transitionduration)
			.call(yAxis);

			       });
	}

	chart.margin = function(_) {
		if (!arguments.length) return margin;
		margin = _;
		return chart;
	};

	chart.width = function(_) {
		if (!arguments.length) return width;
		width = _;
		return chart;
	};

	chart.height = function(_) {
		if (!arguments.length) return height;
		height = _;
		return chart;
	};

	//over-ridden at the moment by abbrev_format - fix later

	chart.axisformat = function(_) {
		if (!arguments.length) return axisformat;
		axisformat = _;
		return chart;
	};
	return chart;

}

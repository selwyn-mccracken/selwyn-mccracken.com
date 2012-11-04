<script src="assets/js/d3.v2.min.js"> </script>
<script src="assets/js/sm/barchart.js"> </script>

<div id="page-title">
  <h1>
    U.S. State comparisons
  </h1>	
	
</div> <!-- /page-title -->


<div class="container">
  <div class="row">
    <div id="mapdiv" class="grid-7">
      <select id="select_combobox">
      </select> 
    </div>
    <div id="bardiv" class="grid-5">
    </div>
  </div>
</div>

<div id="datasources">
    Data Sources:
    <ol>
      <li><a href="http://en.wikipedia.org/wiki/List_of_U.S._states_by_GDP">GDP and Population (Wikipedia)</a>.
      <li><a href="http://en.wikipedia.org/wiki/List_of_U.S._states_and_territories_by_area">Land and water area (Wikipedia)</a>.
      <li><a href="http://www.cdc.gov/obesity/data/adult.html">Obesity (Centers for Disease Control)</a>.
      <li><a href="http://www.gallup.com/poll/152912/Hawaii-No-Wellbeing-West-Virginia-Stuck-Last.aspx">Happiness (Gallup)</a>.
    </ol>
</div>



<style>
svg {
  font: 10px sans-serif;
}

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


<script type="text/javascript">
 
$(function() {
    _g = {
	barchart:barChart(),
	chart_type:"Population (Millions)",
	colour_ramp: d3.scale.linear().domain([0,25,49]).range([  "#832424","lightgrey","#3A3A98"]),
	path_original_colour:null,
	bar_original_colour:null
    };

    //tweak the bar chart settings
    _g.barchart.width(400).height(500).margin({top: 20, right: 50, bottom: 20, left: 100})

    //combobox listener
    $("#select_combobox").change(function(){	
	update_charts()
    })

    d3.xml("assets/img/portfolio/US_Map.svg", "image/svg+xml", function(xml) 
	   {
	       //attach the imported svg node to a specific document element - in this case an existing div
	       var importedNode = document.importNode(xml.documentElement, true);
	       d3.select("div#mapdiv").node().appendChild(importedNode);
	       
	       //resize the map
	       svg = d3.select("div#mapdiv svg")	
		   .attr("viewBox", "25 0 960 593")
		   .attr("width", "550")
		   .attr("preserveAspectRatio", "xMinYMin");
	              
	       //reposition the datasources div
	       $("#datasources").offset({ top: 600, left: 150 });

	       d3.json("assets/data/US_State_data.json",function(jdat)
		       {
			   _g.state_data = jdat;
			   //populate the combo 
			   var combo_options = d3.keys(_g.state_data[1]).filter(function(i){return i != 'State' & i != 'abbrev';})
			   var options = $("#select_combobox");
			   $.each(combo_options, function() {
			       options.append($("<option />").val(this).text(this));
			   });
			   //set the combobox 
			   $("#select_combobox").val(_g.chart_type)	
			   update_charts()
 		       }
		      ); 
	   }
	  );
   
   

    

});


function update_charts()
    {
	var selected = 	$("#select_combobox").val()
	plotdata = _g.state_data.map(function(i){
	    return { key:i.abbrev,value: parseFloat(i[selected]),label:i.State,fill:'red'};
	})
	
	plotdata.sort(function(a, b){
	    return (b.value - a.value) //sort values into descending order
	})

	for (i=0;i < plotdata.length;i++){
	    plotdata[i].fill = 	_g.colour_ramp(i);
	    //colour the map the same colour as the corresponding bar
	    d3.selectAll('svg path#' + plotdata[i].key ).style('fill',_g.colour_ramp(i))
	}

	d3.select('#bardiv').datum(plotdata).call(_g.barchart)	

	//add mouseover highlighting to the map and barchart
	d3.selectAll('svg path')
	    .on('mouseover',function()
		{ 
		    d3.select(this).style('opacity',0.5);
		    //highlight corresponding state bar and save original colour for mouseout event
		    var pathid = d3.select(this).attr('id');
		     _g.path_original_colour = d3.selectAll('#bardiv rect[key="'+pathid+'"]').style('fill');
		    d3.selectAll('#bardiv rect[key="'+pathid+'"]').style('fill','red');
		    
		}
	       );

	d3.selectAll('svg path')
	    .on('mouseout',function(){
		d3.select(this).style('opacity',1);
		//restore original colour to bar
		var pathid = d3.select(this).attr('id');
		d3.selectAll('#bardiv rect[key="'+pathid+'"]').style('fill',_g.path_original_colour);
	    })

	d3.selectAll('#bardiv rect')
	    .on('mouseover',function()
		{ 
		    d3.select(this).style('opacity',0.5);
		    //highlight corresponding state on map and save original colour for mouseout event
		    var barid = d3.select(this).attr('key')
		    _g.path_original_colour = d3.selectAll('svg path#' + barid ).style('fill')
		    d3.selectAll('svg path#' + barid ).style('fill','red')
		}
	       )

	d3.selectAll('#bardiv rect')
	    .on('mouseout',function(){ 
		d3.select(this).style('opacity',1);
		//restore original colour
		var barid = d3.select(this).attr('key')
		d3.selectAll('svg path#' + barid ).style('fill',_g.path_original_colour )
	    })
    }


</script>

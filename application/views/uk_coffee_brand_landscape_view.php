<script type="text/javascript" src="assets/js/jquery.tipsy.js"></script>
<link href="assets/css/tipsy.css" rel="stylesheet" type="text/css" />

 <div id="page-title">

  <h1>UK coffee brand similarity landscape
    <a id="infobutton" class="btn btn-small btn-warning"  style="float: right" href="#">
      <i class="icon-info-sign"></i> Info</a>
  </h1>		
      
</div> <!-- /page-title -->
<p>
This brand similarity landscape was established from the purchasing correlation of coffee brands bought within each household over the course of a year.
<p>

<div class="container">
  <div class="row">
    <div class="grid-6">
      <input type="checkbox" name="chkBox" id="chkBox" checked >Show Contour Lines</input>
      <input type="checkbox" name="kencoChkBox" id="kencoChkBox">Highlight Kenco Core</input>
    </div>
    <div class="grid-6">
    </div>			
  </div>								

  <div id="maparea"></div>

</div>


<script type="text/javascript">


$(function() {
    var _g = {color_kenco:null};

    $('#infobutton').popover({title:"Info",placement:"bottom",content:"Mouse over points to show brand names and market share."})
    
    d3.xml("assets/img/portfolio/coffee_contours.svg", "image/svg+xml", function(xml) {
      //attach the imported svg node to a specific document element - in this case an existing div
	var importedNode = document.importNode(xml.documentElement, true);
	d3.select("div#maparea").node().appendChild(importedNode);

	d3.selectAll('circle').attr({'r':5, opacity:.65} );
  
	//add info labels with tipsy 
	$('svg circle').tipsy({ 
            gravity: 'w', 
            html: true, 
            title: function() {
		return '<h5>' + $(this).attr('brand') + '</h5><p>Market share: ' + $(this).attr('share') + '</p>'; 
            }
	});
		
	//resize the chart
	svg = d3.select("svg")	
	    .attr("viewBox", "0 0 960 672")
	    .attr("width", "800")
	    .attr("height", "500")
	//      .attr("preserveAspectRatio", "none");
	    .attr("preserveAspectRatio", "xMinYMin");
	

	svg.append('circle')
	    .attr('cx',875).attr('cy',400).attr('r',20)
	    .attr('opacity',0)
	    .attr('class','mainchart_comment');


	var chart_text =  'A review of the brand positions on this landscape (by hovering over each point with the mouse), allows us to infer ' +
	    'the two main dimensions that operate within this market. <br><br> ' +
	    'These primary dimensions are 1) flavour intensity ' + 
	    '(spanning dark to light across the x-axis) and 2) perceived quality (y-axis), ' + 
	    'because each household tends to prefer a certain flavour and perceived value. ' +
	    '<br><br>Of particular note, is that these dimensions and brand similarities have emerged naturally from the market itself via purchasing behaviour, ' +
	    'rather than the market positioning assumptions or beliefs about a brand held by the manufacturers, which can at times be erroneous.'
	d3.select('circle.mainchart_comment')
	//comment text box 
	    .each(function(d){
		//Popover content
		$(this).popover({'title':'Coffee market dimensions',html:true, 'content':chart_text,trigger:'manual'}).popover('show')
	    });


//d3.selectAll('g[id^="guide"] rect[stroke="none"]').on("mouseover",function(){d3.select(this).style("fill", "white");});

  });

  //hide/show the contour lines
  $('#chkBox').change(function(){
    if($(this).is(':checked')){
      //show the contour lines
      d3.selectAll('polyline').attr('opacity',1);
    }
    else{
      d3.selectAll('polyline').attr('opacity',0);
    }
  });

  //highlight kenco
	$('#kencoChkBox').change(function(){
	  if($(this).is(':checked')){
	    _g.color_kenco = d3.select('circle[kenco="Y"]').attr('fill');
	    d3.selectAll('circle[kenco="Y"]').attr('fill','black');
	    d3.selectAll('circle[kenco="Y"]').attr('stroke','red');
	    d3.selectAll('circle[kenco="Y"]').attr({'stroke-width':'5','stroke-opacity':'1'});
	  }
	  else{
	    d3.selectAll('circle[kenco="Y"]').attr('fill',_g.color_kenco);
	    d3.selectAll('circle[kenco="Y"]').attr('stroke','none');
	  }
	});
          

});
</script>

<script src="assets/js/d3.v2.min.js"> </script>

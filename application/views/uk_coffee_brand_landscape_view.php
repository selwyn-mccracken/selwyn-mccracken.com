 <div id="page-title">

  <h1>UK coffee brand similarity landscape
    <a id="infobutton" class="btn btn-small btn-warning"  style="float: right" href="#">
      <i class="icon-info-sign"></i> Info</a>
  </h1>		
      
</div> <!-- /page-title -->
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

  d3.xml("<?=base_url()?>assets/img/portfolio/coffee_contours.svg", "image/svg+xml", function(xml) {
    //attach the imported svg node to a specific document element - in this case an existing div
  var importedNode = document.importNode(xml.documentElement, true);
  d3.select("div#maparea").node().appendChild(importedNode);

  d3.selectAll('circle').attr({'r':5, opacity:.65} );
  
  d3.selectAll('circle').each(function(d){
    //Popover content
    $(this).popover({'title':$(this).attr('brand'), 'content': $(this).attr('share')})
  })

d3.select("svg")
      .attr("viewBox", "0 0 960 672")
      .attr("width", "800")
      .attr("height", "500")
//      .attr("preserveAspectRatio", "none");
      .attr("preserveAspectRatio", "xMinYMin");


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

<script src="<?=base_url()?>assets/js/d3.v2.min.js"> </script>
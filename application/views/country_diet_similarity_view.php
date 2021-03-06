<div id="page-title">

  <h1>Country diet similarity
    <a id="infobutton" class="btn btn-small btn-warning"  style="float: right" href="#">
      <i class="icon-info-sign"></i> Info</a>
  </h1>		


  
</div> <!-- /page-title -->
<div class="container">
  <div class="row">
    <div id="barplot" class="grid-6"></div>
    <div id="starplot" class="grid-6"></div>			
  </div>								
</div>
<p>Data Source: <a href="www.oecd.org">OECD</a>.</p>



<script type="text/javascript">
$(function() {

  $('#infobutton').popover({title:"Info",placement:"bottom",content:"Mouse over either chart to highlight a country in the other chart."})

   d3.xml("assets/img/portfolio/starsbar.svg", "image/svg+xml", function(xml) {

    //attach the imported svg node to a specific document element - in this case an existing div
	    var importedNode = document.importNode(xml.documentElement, true);
	    d3.select("div#barplot").node().appendChild(importedNode);

	    d3.select("#barplot svg")
	      .attr("viewBox", "0 0 672 672")
	      .attr("width", "500")
	      .attr("height", "500")
	      .attr("preserveAspectRatio", "none");

	    //highlight corresponding country in star chart when mousing over barchart
	    d3.selectAll("#barplot svg rect")
	      .on('mouseover',function(){
    		    var poly = $('polygon[country="' + $(this).attr('country') + '"]');
		    poly.attr({'fill':'blue'});
	      })


	    //remove star highlight
	    d3.selectAll("#barplot svg rect").on('mouseout',function(){
    						   $('polygon[country="' + $(this).attr('country') + '"]').attr('fill', 'red');
						 });
	    })

    d3.xml("assets/img/portfolio/stars.svg", "image/svg+xml", function(xml) {
	     //attach the imported svg node to a specific document element - in this case an existing div
    var importedNode = document.importNode(xml.documentElement, true);
    d3.select("div#starplot").node().appendChild(importedNode);

    d3.select("#starplot svg")
      .attr("viewBox", "0 0 672 672")
      .attr("width", "480")
      .attr("height", "500")
      .attr("preserveAspectRatio", "none");

    d3.selectAll("#starplot svg polygon").on('mouseover',function(){
      d3.select(this).attr('fill', 'blue')
      var country = $(this).attr('country');
      //grab the first rect of the corresponding bar to obtain xy coordinates for the highlight rect
      var first_country_rect = d3.select('rect[country="' + country + '"]')

     d3.select("#barplot svg").append("rect")
           .attr('class','highlight')
           .attr("x",first_country_rect.attr('x') - 180)
           .attr("y",650 - first_country_rect.attr('y'))
           .attr("fill", 'red')
           .attr("stroke", 'red')
           .attr("fill-opacity", 0)
           .attr("width", 460)
           .attr("height", 22);
    });

    d3.selectAll("#starplot svg polygon").on('mouseout',function(){
      d3.select(this).attr('fill', 'red')
      d3.selectAll('.highlight').remove()
      });
  })
});







</script>


<script src="assets/js/d3.v2.min.js"> </script>







<script src="assets/data/CountryIDsJSON.js"></script>

<script src="assets/js/d3.v2.min.js"> </script>

<div id="page-title">

  <h1>Gapminder animation - Fertility vs life Expectancy </h1>		
      
</div> <!-- /page-title -->

<div class="container">
  <div class="row">
    <div id="chartarea" class="grid-10">
      <!--img id = "chart" src="assets/img/portfolio/gapminderMultiPanel.svg" type="image/svg+xml" width="700px" > </img-->
    </div>
    <div class="grid-2">
      <button id = "reset_button" type="button" class="btn btn-small btn-warning" >Reset animation</button>
      <p id="countrytext"> </p></div>			
  </div>								
</div>



<script type="text/javascript">
    function resetAnimation(){
	$('#chartarea img').remove();
	//force full reload ignoring cache by adding random noise to src string
	randomised_src = "assets/img/portfolio/gapminderMultiPanel.svg" + '?'+Math.random()*Math.random();
	$('#chartarea').append('<img id = "chart" src=' + randomised_src + ' type="image/svg+xml" width="700px" > </img>');
    }


$(function(){
    $('#reset_button').bind('click',function(event){resetAnimation();});
    resetAnimation()
});
/*
function resetAnimation(){
	var svgdoc = $('#chartarea')[0].firstChild
		svgdoc.setCurrentTime(0);
		svgdoc.unpauseAnimations();
	}
        

$(function() {
  d3.xml("assets/img/portfolio/gapminderMultiPanel.svg", "image/svg+xml", function(xml) {

    //attach the imported svg node to a specific document element - in this case an existing div
	    var importedNode = document.importNode(xml.documentElement, true);
	    d3.select("div#chartarea").node().appendChild(importedNode);

	    d3.select("#chartarea svg")
	      .attr("viewBox", "0 0 960 672")
	      .attr("width", "800")
	      .attr("height", "500")
              .attr("preserveAspectRatio", "xMinYMin");
	      //.attr("preserveAspectRatio", "none");

              d3.selectAll('circle').each(function(d){
              //Popover content
              $(this).popover({'title':countryids[$(this).attr('id')]})
              });

        
              $('#reset_button').bind('click',function(event){resetAnimation();})

            $('circle').on('mouseover', function(){
              $(this).attr({"stroke":'red',
	                   "stroke-opacity":1,
                           "stroke-width":5});
              
              $('#countrytext').text(countryids[$(this).attr('id')]);

            })

	   

            $('circle').on('mouseout', function(){
              $(this).attr("stroke-opacity",0);

              $('#countrytext').text('');
	    });         
                         

   });
})


*/
</script>

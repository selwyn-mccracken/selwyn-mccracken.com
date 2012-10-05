<script src="<?=base_url()?>assets/js/CountryIDsJSON.js"></script>

<script src="<?=base_url()?>assets/js/d3.v2.min.js"> </script>

<div id="page-title">

  <h1>Gapminder animation - Fertility vs life Expectancy </h1>		
      
</div> <!-- /page-title -->

<div id="explorer_warning" class="alert alert-error hidden">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Internet Explorer Warning!</strong>  Please note that the interactive features of this page will only work with
modern browsers such <a href="www.google.com/chrome">Chrome</a> or <a href="http://www.mozilla.org/">Firefox</a>. Please try again with one of those browsers if at all possible. 
</div>


<div class="container">
  <div class="row">
    <div id="chartarea" class="grid-10"></div>
    <div class="grid-2">
      <button id = "reset_button" type="button" class="btn btn-small btn-warning" >Reset animation</button>
      <p id="countrytext"> </p></div>			
  </div>								
</div>



<script type="text/javascript">

function resetAnimation(){
	var svgdoc = $('#chartarea')[0].firstChild
		svgdoc.setCurrentTime(0);
		svgdoc.unpauseAnimations();
	}
        

$(function() {
  //raise an alert if explorer detected and use alt image
  if (BrowserDetect.browser == "Explorer"){
    $('#explorer_warning').removeClass('hidden')
  }
  
d3.xml("<?=base_url()?>assets/img/portfolio/gapminderMultiPanel.svg", "image/svg+xml", function(xml) {

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


</script>

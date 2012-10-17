<style>
.popover.right .arrow{top:50%;left:0;margin-top:-60px;border-top:5px solid transparent;border-bottom:5px solid transparent;border-right:5px solid #000000;}
.popover-title {
    margin-bottom:0em
}

</style>
<div id="page-title">

  <h1>Heating Oil Price Seasonality </h1>		
      
</div> <!-- /page-title -->


<img id='figure1' src="assets/img/portfolio/heating_oil_price_seasonality.png" alt="" />
<p>Data Source: U.S. <a href="www.eia.gov">Energy Information Administration</a>.</p>

<script>
$(window).load(function(){
$('#figure1').popover({trigger:'manual',position:'right',title:'Comment:',content:'The seasonal component of the heating oil price spans only 3 cents per year, a negligible amount when the current spot price is more than $3 / gallon'}).popover('show')
});
</script>


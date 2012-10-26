<link href="assets/css/nv.d3.css" rel="stylesheet"/>


<div id="page-title">

  <h1>
      UK TV Channels  
  </h1>		

</div> <!-- /page-title -->

<div class="container">
  <div class="row">
    <div id="chart" class="grid-12">
        <svg style='height:500px' />
    </div>
  </div>
   <div class="row">
    <div id="linechart" class="grid-12">
        <svg style='height:500px' />
    </div>
  </div>  								
</div>


<script type="text/javascript">
xx = null;

function zip(arrays) {
    return arrays[0].map(function(_,i){
        return arrays.map(function(array){return array[i]})
    });
}

$(function() {


  d3.json("assets/data/channel_shares_20121022.json", function(data) 
  {
    //generate a series of dates to combine with the incoming data
    var start_date = new Date(Date.UTC(2012, 9,7)); //last date of data is October 7 2012 (js month is zero indexed for some reason...)
    var week_ending_dates = [];
    var milli_per_wk = (7 * 24 * 60 * 60 * 1000);

    var nweeks = data[0].values.length
    var dayofweek_total = 0; //variable to double-check that all days should be Sunday

    for (i =0; i<nweeks;i++)
    {
      var newdate =  new Date(start_date.getTime() - (milli_per_wk * i) )
      dayofweek_total += newdate.getDay();
      week_ending_dates.push(
        newdate.getTime()
        );
    }
    
    //console.log(dayofweek_total)
    week_ending_dates = week_ending_dates.reverse();

    //c4 and c4+S4 trends need to be merged
    c4s4 = data[4].values
    c4 = data[3].values
    c5 = data[5].values

    for(i =0; i<nweeks;i++)
    {
      if (c4[i] == null)
        c4[i] = c4s4[i]
      
      if (c5[i] == null)
        c5[i] = 0

    }


    nulls   = c5.filter(function(c){return c == null;})
    console.log(nulls.length)

    data = [data[6],data[0],data[1],data[2],{key:'Channel 4',values:c4},data[5]];
    //data = [data[0],data[1],data[2],{key:'Channel 4',values:c4},data[6]];


    plot_data = data.map(function(d)
    {

      zipped_dates_and_values = [];
      for(i =0; i<nweeks;i++)
      {
        zipped_dates_and_values.push([week_ending_dates[i],parseFloat(d.values[i])]);
      }

      return {
        key:d.key,
        values: zipped_dates_and_values
      };
    });
 
  nv.addGraph(function() {
     var chart = nv.models.stackedAreaChart()
                   .x(function(d) { return d[0] })
                   .y(function(d) { return d[1] })
                   .clipEdge(true);
 
     chart.xAxis
         .tickFormat(function(d) { return d3.time.format('%x')(new Date(d)) });
 
     chart.yAxis
         .tickFormat(d3.format(',.2f'));
 
     d3.select('#chart svg')
       .datum(plot_data)
         .transition().duration(500).call(chart);
 
     nv.utils.windowResize(chart.update);
 
     return chart;
   });

/*
nv.addGraph(function() {
   var chart = nv.models.lineWithFocusChart();
 
   chart.xAxis
         .tickFormat(function(d) { return d3.time.format('%x')(new Date(d)) });
 
     chart.yAxis
         .tickFormat(d3.format(',.2f'));
 
   chart.y2Axis
       .tickFormat(d3.format(',.2f'));
 
   d3.select('#linechart svg')
       .datum(plot_data)
     .transition().duration(500)
       .call(chart);
 
   nv.utils.windowResize(chart.update);
 
   return chart;
 });
*/

  })
}); 

</script>


<script src="assets/js/d3.v2.min.js"> </script>
<script src="assets/js/nv.d3.js"></script>







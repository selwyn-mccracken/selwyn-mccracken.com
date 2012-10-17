<style>
/*.popover-title {
    margin-bottom:0em
}
*/
</style>

 <div id="page-title">

  <h1>Hadoop Benchmarks on Amazon's EC2 </h1>		
      
</div> <!-- /page-title -->
<p>One of the purported advantages of using Hadoop is that hardware costs scale linearly as you add more processing nodes of commodity servers. However, the rate of processing throughput does not improve at the same rate as nodes being added to the cluster, because of the increased communication overhead as the cluster grows in size. That is, a 16-node cluster is not 8x faster 
than a 2-node cluster, but is a proportion smaller than the optimal 1(node)&nbsp&nbsp:&nbsp&nbsp1(unit of throughput) scaling ratio.</p>

<p>
The results below show the node:throughput scaling ratios found for two common Hadoop processing tasks, word-counting and text index creation, performed on the <a href="http://aws.amazon.com/datasets/2345">Wikipedia extract hosted on Amazon's AWS</a>,  comprising of 4.2 Million Wikipedia records (~66GB compressed).
</p>


	
<h4>Figure 1. Wikipedia word count benchmark with 2, 4 and 16 worker nodes.</h4>
<img id="wordcount_chart" src="assets/img/portfolio/hadoop_wordcount_benchmark.png" alt="" />
<p><i>*Hadoop jobs can never finish instantly as there is always a significant initialisation lead time.</i></p>

<h4>Figure 2. Wikipedia inverted text index creation with 4 and 16 worker nodes.</h4>
<img id="index_chart" src="assets/img/portfolio/hadoop_index_benchmark.png" alt="" />


<script>
$(window).load(function(){
 var word_count_text = "Based on the performance found across the 3 different cluster sizes, each additional node reduced the completion time by around 3 minutes, and that it would require approximately 18 nodes for the task to finish 'instantly'*. The 16-node cluster was 6.9x faster than the 2-node cluster. In order words the 16-node cluster had a node : throughput scaling ratio of 87% relative to the expected 8x performance gain relative to the 2-node cluster.";
 $('#wordcount_chart').popover({trigger:'manual',position:'right',title:'Results',content:word_count_text}).popover('show')

 var index_text = "Each additional node reduced the time to complete the index creation by 8.25 minutes, meaning that 22 nodes would finish the task 'instantly'*. The 16-node cluster was 3x faster than the 4-node cluster, meaning it only had a node : throughput scaling ratio of 76% relative to the 4-node cluster.";
 $('#index_chart').popover({trigger:'manual',position:'right',title:'Results',content:index_text}).popover('show')
 });
</script>

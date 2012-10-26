<style>
.popover.right .arrow{top:50%;left:0;margin-top:-60px;border-top:5px solid transparent;border-bottom:5px solid transparent;border-right:5px solid #000000;}
</style>
<div id="page-title">

  <h1>Ensemble document classification </h1>		
      
</div> <!-- /page-title -->
<p><a href="http://en.wikipedia.org/wiki/Ensemble_learning">Ensemble methods</a> are a powerful technique for improving predictive accuracy by combining the results of several statistical models. 
<br><br>

The document classification example below demonstrates how a simple ensemble of two common models (i.e. Logistic Regression and Random Forest) can outperform the predictions made by either alone, and how the ensemble can be tuned to provide the best possible set of predictions by adjusting the weights assigned to each model.<br><br>

The task at hand was to classify newswire articles into one of two topic categories relating to companies, Earnings or Acquistions. The data used was a subset of the <a href="http://modnlp.berlios.de/reuters21578.html"> Reuters-21578 corpus</a>, a dataset where each document is tagged with its topic, and is popular for text classification research. 
<br><br>

Each model was trained on 50% of the available data that had been pre-processed using the steps <a href="ensemble_document_classification/#processing_steps">described below</a>, with the remaining 50% used for model validation testing. 


<h4>Figure 1. Logistic Regression model classifying training documents into the Earnings or Acquisition category.</h4>
<img id='figure1' src="assets/img/portfolio/doc_classification_logistic_regression_training_model.png" alt="" />
<h4>Figure 2. Random Forest model classifying training documents into the Earnings or Acquisition category.</h4>.</h4>
<img id='figure2' src="assets/img/portfolio/doc_classification_random_forest_training_model.png" alt="" />
<h4>Figure 3. Simple ensemble Model model classifying training documents into the Earnings or Acquisition category (50% weighting for Logistic Regression and Random Forest models respectively).</h4>
<img id='figure3' src="assets/img/portfolio/doc_classification_ensemble_training_model.png" alt="" />

<h4>Figure 4. Ensemble classification accuracy by Logistic Regression model weight.</h4>
<img id='figure4' src="assets/img/portfolio/doc_classification_ensemble_results_by_weight.png" alt="" />


<p>
 Data Source: <a href="http://modnlp.berlios.de/reuters21578.html"> Reuters-21578 xml corpus</a>. Credit: This example inspired by <a href="http://www.overkillanalytics.net/more-is-always-better-the-power-of-simple-ensembles">Overkill Analytics</a>
</p>

<h4 id="processing_steps">Data preprocessing steps:</h4>

<ul class='caretlist'> 				
   <li>Convert XML to plain text</li>
   <li>Extract the document topics and retain onlu Acquistion or Earnings documents</li>
   <li>Convert to lower case</li>
   <li>Remove noise/stop words</li>
   <li>Remove word suffixes (i.e. stemming)</li>
   <li>Remove numbers </li>
   <li>Remove additional whitespace</li>
   <li>Create a term by document matrix</li>
   <li>Calculate the Cosine similarity of all documents against each other</li>
   <li>Collapse the dataset down to 2 dimensions using classical multi-dimensional scaling  </li>
 </ul>




<script>
$(window).load(function(){

    $('ul.caretlist li').addClass("icon-caret-right")	
    var f1_heading = 'The logistic model extracts the broad "theme" of the data'
    var f1_text = 'The classification threshold for the logistic regression model is a simple linear boundary that maximally separates ' + 
	"the two document types. As such, the logistic model is good at indentifying the major 'theme' within the data, without being too distracted by any 'noise'.";
    $('#figure1').popover({trigger:'manual',position:'right',title:f1_heading,content:f1_text}).popover('show')

    var f2_text = "The random forest model is better at extracting the detailed features of the data than logistic regression, but it is so finely tuned to the training data that it is prone to 'over-fitting', meaning that its predictions could generalise poorly on unseen data."
    var f2_heading = "The random forest is more precise, but can 'overfit'"
    $('#figure2').popover({trigger:'manual',position:'right',title:f2_heading,content:f2_text}).popover('show')

    $('#figure3').popover({trigger:'manual',position:'right',title:'The best of both worlds',content:"Blending the predictions of both models together allows for the strengths of each to be retained. The major 'theme' from logistic model is still apparant, however the random forest softens the hard boundary when imporant variations occur. The question then becomes, what weights should be applied to each model?"}).popover('show')

    $('#figure4').popover({trigger:'manual',position:'right',title:'Ensemble performance tuning',content:'Maximum classification performance on the test/validation data occurred when a ~75% weighting was assigned to the logistic model'}).popover('show')



});


</script>


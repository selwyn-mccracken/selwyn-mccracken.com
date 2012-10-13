<script src="assets/js/browser_detect.js"> </script>

<script>

var explorer_warning_html = '<div id="explorer_warning" class="alert alert-error">' +
  '<button type="button" class="close" data-dismiss="alert">×</button>' +
  '<strong>Internet Explorer Warning!</strong>  Please note that the interactive features of this page will only work with '+
  'modern browsers such <a href="www.google.com/chrome">Chrome</a> or <a href="http://www.mozilla.org/">Firefox</a>.' +
  ' Please try again with one of those browsers if at all possible. </div>';
  

  //raise an alert if explorer detected and use alt image
  if (BrowserDetect.browser == "Explorer"){
    //$('#explorer_warning').removeClass('hidden')
    $('div#page-title').after(explorer_warning_html)
  }


</script>

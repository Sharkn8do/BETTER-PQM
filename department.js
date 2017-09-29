	$(function() {
		  $("#affiliation").change(function() {
		    if ($(".school").is(":selected")) {
		      $("#department").show();
		    } 
        else {
          $("#department").hide();
        }
		  }).trigger('change');
		});

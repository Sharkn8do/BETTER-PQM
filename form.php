<?php
require_once "functions/dbconnect.php";
$query = "SELECT * FROM prints";
echo $query;
$result = $conn->query($query);
while($row = $result->fetch_assoc()) {
         echo $row['first_name'];
     }
?>
<!DOCTYPE html>
<head>
  <title>Submit a 3D Print Request</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="verimail.js"></script>
  <script type="text/javascript" src="phonenumber.js"></script>
  <script type="text/javascript" src="department.js"></script>
  
   <script>
  var array = ["2013-03-14","2016-11-30","2013-03-16"]
  $( function() {
  function getNext7WorkingDays(){
  var d = new Date();
    var day = d.getDay();
    if(day>=0 && day<=3) return 6;
    else if(day!=6) return 7;
    else return 8;
    }
    
    $( "#datepicker" ).datepicker({
    constrainInput: true,
    minDate: "+2D",
    dateFormat: "yy-mm-dd"
    });
  } );
  
  </script>
  <script>
          $('#newRequest').change(function() {
    if (!$("input[name='custom']:checked").val()) {
        $('#customDimensions').show();
    } else {
        $('#customDimensions').hide();
    }
});
      </script>
</head>
<body>
  <form id="newRequest">
    Your Name
    </br>
  <input type="text" width="100px">
  
  </br>
  Email Address
  </br>
  <input type="text" width="100px" id="email"> 
<script>
    $("input#email").verimail({
    messageElement: "#email-status"
});
  </script>
<span id="email-status"></span>
</br>
  Phone Number
</br>
<input class="phone" width="100px">
</br>
Affiliation:
</br>
<select id="affiliation">
  <optgroup id="school">
  <option class="school">
      NAU Student
  </option>
  <option class="school">
      NAU Graduate Student
  </option>
  <option class="school">
      NAU Faculty/Staff
  </option>
  <option class="school">
      CCC Student
  </option>
  <option class="school">
      CCC Faculty/Staff
  </option>
</optgroup>
  <option>
      Other/Visitor
  </option>
</select>  

<div id="department">
  Department/College:
 </br>
<input type="text">
</div>

<div>
  <button class="addRow">Add Another File</button>
	
	<button class="deleteRow">Delete Last File</button>
  
  
  <h1>
  Upload your 3D Files
  </h1>
	
	<table class="3Dmodels">
		
		<tr>
			<td>
				<input  type="text" name="3Dfile0" />
			</td>
        
      <td>
         <input type="radio" name="original0" id="original">
        Use Default Size in File:
        
        <input type="radio" name="custom0" id="custom">
        Specify Dimensions
        <div id='customDimensions' style='display:none'>Hello</div>
        
      </td>
			
			<td>
			Number of Prints
				<input type="number" name="quantity0" step="1" min="1" style="width:50px; text-align:center;">
			</td>
						<td>
							<script>
						$.getJSON("colorEcho.php",function(data){

    $.each(data,function(index,item) 
    {
			var colorID = JSON.stringify(item.ColorID);
			var colorID = colorID.replace(/\"/g, "");
			var ColorDescription = JSON.stringify(item.ColorDescription);
			var ColorDescription = ColorDescription.replace(/\"/g, "");
			
      items+="<option value='"+colorID+"'>"+ColorDescription+"</option>";
    });
    $("#color0").html(items); 
		alert(items);
							});
					</script>
			Color:
				<select name="color0">
					
				</select>
			</td>
			
		</tr>
	</table>
</div>

<script>
	var counter = 1;
	if (counter >= 1) {
	jQuery('button.addRow').click(function(event){
		event.preventDefault();
		
		$(function(){

  var items="";
  $.getJSON("colorEncode.php",function(data){

    $.each(data,function(index,item) 
    {
			var colorID = JSON.stringify(item.ColorID);
			var colorID = colorID.replace(/\"/g, "");
			var ColorDescription = JSON.stringify(item.ColorDescription);
			var ColorDescription = ColorDescription.replace(/\"/g, "");
			
      items+="<option value='"+colorID+"'>"+ColorDescription+"</option>";
    });

		var newRow = jQuery('<tr><td><input type="text" name="3Dfile' + 
				counter + '"/></td><td><input type="radio" name="original' + 
				counter + '" id="original"> Use Default Size in File: <input type="radio" name="custom' + 
				counter + '" id="custom"> Specify Dimensions <div id="customDimensions" style="display:none">Hello</div></td><td>Number of Prints<input type="number" name="quantity' +
				counter + '" step="1" min="1" style="width:50px; text-align:center;"></td><td>Color:<select name="color' + 
				counter + '<select id="color' + 
				counter + '">' +
				items + '</select></tr>');
		jQuery('table.3Dmodels').append(newRow);
    counter++;
	});
			  });

});
	jQuery('button.deleteRow').click(function(event){
		event.preventDefault();
		$('.3Dmodels tr:last').remove();
    if (counter>0) {
		counter--;
    }
	});
	}
</script>

Date Needed: <input id="datepicker" name="date" readonly="true">
  
 </form>
</body>
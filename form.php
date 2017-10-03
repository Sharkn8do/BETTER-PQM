<?php
require_once "functions/dbconnect.php";

   if(isset($_FILES['3DFile'])){
      $errors= array();
      $file_name = $_FILES['3DFile']['name'];
      $file_size =$_FILES['3DFile']['size'];
      $file_tmp =$_FILES['3DFile']['tmp_name'];
      $file_type=$_FILES['3DFile']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['3DFile']['name'])));
      
      $extensions= array("stl");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors = "Extension not allowed, please choose a STL file.";
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"RequestFiles/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
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
	<link rel="stylesheet" href="form.css">
  
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
</head>
<body>
  <form id="newRequest" action="" method="POST" enctype="multipart/form-data">
	<div id="aboutYou">
		<h2>
			About You
		</h2>
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
<?php
	$query = "SELECT * FROM Affiliation";
	$result = $conn->query($query);
	while($row = $result->fetch_assoc()) {
         echo "<option id='" . $row['AffiliationID'] . "'>" . $row['AffiliationDescription'] . "</option>";
     }
	?>
</select>  

</br>
  Department/College:
 </br>
<input type="text">

</div>

<div>
	<h2>
		Your Print
	</h2>
	
Date Needed: 
	</br>
	<input id="datepicker" name="date" readonly="true">
</br>
File Upload:
</br>
<input type="file" name="3DFile" accept=".stl"/>
</br>
Number of Prints:
</br>
<input type="number" step="1" min="1" value="1">
</br>
Object Size:
</br>
  <input type="radio" name="custom" id="original0">
        Use Default Size in File:
        
        <input type="radio" name="custom" id="custom0">
        Specify Dimensions
        <div id='customDimensions' style='display:none'>
					<table id="customSize">
						<tr>
							<th>
								Height:
							</th>
							
							<th>
								Width:
							</th>
							
							<th>
								Length:
							</th>
						</tr>
						
						<tr>
							<td>
								<input type="number" id="fileHeight" step="0.01" max="457.00" min="1.00" style="text-align:center; width:100%;" placeholder="Height (mm)">
							</td>
							
							<td>
								<input type="number" id="fileWidth" step="0.01" max="305.00" min="1.00" style="text-align:center; width:100%;" placeholder="Width (mm)">
							</td>
							
							<td>
								<input type="number" id="fileLength" step="0.01" max="300.00" min="1.00" style="text-align:center; width:100%;" placeholder="Length (mm)">
							</td>
						</tr>
						
						<tr>
							<td>
								Max Height is 457 mm
							</td>
							
							<td>
								Max Width is 305 mm
							</td>
							
							<td>
								Max Length is 300 mm
							</td>
						</tr>
					</table>
				</div>
</br>
Filament Color:
</br>
<select>
	<?php include "colorEcho.php"?>
</select>
</div>

<div>
	<h2>
		Additional Notes:
	</h2>
	Custom Instructions? <input type="checkbox" id="instructions">
<div id="CustomInstructions" style="display:none;">
	<table id="customizedInstructions">
						<tr>
							<th class="tooltip">
								<span class="tooltiptext">Layer Height is how coarse or fine the vertical axis, 0.1 being the finest and 0.3 being the coarsest.</span>
								Layer Height:
							</th>
							
							<th class="tooltip">
								<span class="tooltiptext">Shells are the exterior wall of a print, the higher the shells, the thicker the wall.</span>
								Shells:
							</th>
							
							<th class="tooltip">
								<span class="tooltiptext">Infill is how much of the print inbetween the exterior walls is filled in.<br>100% is the highest, 10% is the lowest.</span>
								Infill:
							</th>
						</tr>
						
						<tr>
							<td>
								<input class="instructionsInput" type="number" id="layerHeight" step="0.1" max="0.3" min="0.1" placeholder="Layer Height (mm)">
							</td>
							
							<td>
								<input class="instructionsInput" type="number" id="shells" step="1" max="30" min="1.00" placeholder="Number of Shells">
							</td>
							
							<td>
								<input class="instructionsInput"  type="number" id="infill" step="10" max="100" min="10" placeholder="Infill (%)">
							</td>
						</tr>
					</table>
		
</div>
	<br>
	If print settings for 3D model need to include other instructions, please specify here:
		<br>
		<textarea id="comments" maxlength="1024" rows="4" cols="50"></textarea>
	<br>
	<em>Unless specified otherwise above, all 3D print requests will be printed at MakerBot's standard print settings <br> (10% infill, 200 micron/0.20mm resolution/layer height, 2 shells, with raft).</em>
</div>
	
</br>
  <input type="submit"/>
 </form>


<script>
	$('#instructions').change(function(){
  if($(this).prop("checked")) {
    $('#CustomInstructions').show();
  } else {
    $('#CustomInstructions').hide();
  }
});
</script>
<script>
          $('#newRequest').change(function() {
    if ($("input[id='custom0']:checked").val()) {
        $('#customDimensions').show();
    } else {
        $('#customDimensions').hide();
    }
});
      </script>

</body>
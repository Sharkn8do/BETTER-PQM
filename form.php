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
		<div id="top">
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

<div id="yourPrint">
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
        Use Default Size in File
        <br>
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
</div>

<div id="additionalNotes">
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
	<h4>
		More about your print:
	</h4>
	Is this an original design?
	<br>
	<input type="radio" name="design" id="designYes"> Yes
	<input type="radio" name="design" id="designNo"> No
	<br>
	Is this for a class?
	<br>
	<input type="radio" name="class" id="classYes"> Yes
	<input type="radio" name="class" id="classNo"> No
	
	<div id="classDetails" style="display:none;">
		Class Number:
		<input id="classNumber" placeholder="Art 100, CEME 121, MAT 121" maxlength="10">
		<br>
		Class Title:
		<input id="classTitle" placeholder="Intro to Mechanical Engineering" maxlength="50">
		<br>
		Class Insturctor:
		<input id="classInstructor" placeholder="Dr. Knowital" maxlength="30">
	</div>
</div>

<div id="agreement">
	<h4>
		Payment and turnaround time:
	</h4>
	<?php
	$query = "SELECT * FROM ContactPreference";
	$result = $conn->query($query);
	while($row = $result->fetch_assoc()) {
										 echo "<input type='radio' name='contact' id='contact" . $row['ContactPreferenceID'] . "' value='" . $row['ContactPreferenceID'] . "'>" . $row['ContactDescription'] ."<br>";
								 }
	?>
	<h4>
		Use Agreement:
	</h4>
	<select id="intellectualRights">
		<option>
			Select One
		</option>
		<option id="ir0">
			No
		</option>
		<option id="ir0">
			Yes
		</option>
	</select>
	I have read and agree to <a href="http://library.nau.edu/services/makerlab/makerlabpolicies.html">Cline Library's 3D printing policies</a> and certify that I have the intellectual property rights to authorize reproduction.
	<br>
	<select id="clinePictures">
		<option>
			Select One
		</option>
		<option id="clinePics0">
			No
		</option>
		<option id="clinePics0">
			Yes
		</option>
	</select>
	May we take photos of your object or archive the file for use in marketing, publications, or sharing with others?
</div>

<div class="copyrightnotice">
	<h3>Notice concerning copyright and other intellectual property restrictions</h3>
	<p>The copyright law of the United States (<a href="http://www.copyright.gov/title17/" target="_blank">Title 17, United States Code</a>) governs the making of photocopies or other reproductions of copyrighted material.</p>
	<p>Under certain conditions specified in the law, libraries and archives are authorized to furnish a photocopy or other reproduction. One of these specific conditions is that the photocopy or reproduction is not to be "used for any purpose other than private study, scholarship, or research." If a user makes a request for, or later uses, a photocopy or reproduction for purposes in excess of "fair use," that user may be liable for copyright infringement. </p>
	<p>This institution reserves the right to refuse to accept a copying order/scanning services if, in its judgment, fulfillment of the order would involve violation of copyright or other intellectual property laws.</p>
	<p>By submitting this print request, I acknowledge, represent and warrant as follows:</p>
	<ul>
		<li>I have read, understand, and will comply with the copyright notice posted above. </li>
		<li>This request complies with the <a href="/services/makerlab/makerlabpolicies.html">Cline Library MakerLab Use Policy</a> and all other applicable laws, regulations, and policies.</li>
		<li>I will use the printed object(s) only for personal use, private study, scholarship, or research.</li>
		<li>I will not use them for any commercial purpose or allow any third party to do so.</li>
	</ul>
  <input type="submit" id="submit" value="I Have Read These Terms and Conditions and Agree"/>
</div>
	

 </form>

<script>
	$('#newRequest').change(function(){
   if ($("input[id='designNo']:checked").val()) {
   	var result = confirm("Is this file clear of logos, design copyrights, or other form of copyright infringments?");
if (result) {
    $("#designNo").prop("checked", true);
} else {
    $("#designNo").prop("checked", false);
}
  }
});
</script>
<script>
	$('#newRequest').change(function(){
   if ($("input[id='classYes']:checked").val()) {
    $('#classDetails').show();
  } else {
    $('#classDetails').hide();
  }
});
</script>
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
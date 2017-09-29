<?php
require_once "dbconnect.php";

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
  <script type="text/javascript" src="phonenumber.js"></script>
  <script type="text/javascript" src="department.js"></script>
</head>
<body>
  <form>
    Your Name
    </br>
  <input type="text" width="100px">
  </br>
  Email Address
  </br>
  <input type="text" width="100px">
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
  
 </form>
</body>
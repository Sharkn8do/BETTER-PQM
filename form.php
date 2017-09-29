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
  <script type="text/javascript" src="phonenumber.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
<input id="phone" width="100px">

  
  
  </form>
</body>
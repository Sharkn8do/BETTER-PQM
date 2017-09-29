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
</head>
<body>
  <form>
    Your Name
    </br>
  <input type="text" width="100px">
  
  </form>
</body>
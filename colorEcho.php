<?php
require_once "functions/dbconnect.php";
					$query = "SELECT ColorDescription,ColorID FROM Colors ORDER BY ColorGroup";
						echo $query;
						$result = $conn->query($query);
						while($row = $result->fetch_assoc()) {
										 $colorData[] = $row;
								 }
echo json_encode($colorData);
              
					?>
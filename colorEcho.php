<?php
require_once "functions/dbconnect.php";
					$query = "SELECT ColorDescription,ColorID FROM Colors ORDER BY ColorGroup";
						$result = $conn->query($query);
						while($row = $result->fetch_assoc()) {
										 echo "<option id='" . $row['ColorID'] . "'>" . $row['ColorDescription'] . "</option>";
								 }
					?>
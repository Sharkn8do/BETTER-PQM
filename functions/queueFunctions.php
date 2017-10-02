<?php
//determine based on status what records to output
function drawRecords($con,$status) {
	//echo $status;
	
	//if status is empty, return all elements
	if(empty($status)){$query="SELECT * FROM `prints`";}
	
	//else, return all records matching status
	else {$query="SELECT * FROM prints WHERE status = '$status'";}
	
	$result = mysqli_query($con,$query);
	
	while($row = mysqli_fetch_assoc($result)) {
		$id = $row['request_id'];
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$filename = $row['filename'];
		//function to write out the status in readable format
		$stat = writeStatus($row['status']);
		//echo out one record at a time, diving between them
		echo "_______________________________________________________";
		echo"<div id='request_$id'>
			<p id='id'>Request: $id</p>
			<p id='user_info'>Name: $first_name $last_name</p>
			<p id='print_details'>Filename: $filename </br> Status: $stat</p>
			</div>";
	}
}
//take the raw status from the 
function writeStatus($raw_status) {
	switch($raw_status) {
			case "new":
				$status = "New";
				break;
			case "ac":
				$status = "Awaiting Confirmation";
				break;
			case "p":
				$status = "Printing";
				break;
			case "h":
				$status = "Harvesting";
				break;
			case "c":
				$status = "Completed";
				break;
	}
	return $status;
}
?>
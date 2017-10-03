<?php
function drawAllRecords($con) {
	//query selecting ALL records that have been Authorized
	$q = "SELECT * FROM `pqm`.`Requests` WHERE `Authorized` = '1'";
	$result = mysqli_query($con,$q);
	//break down into their own functions for easier testing
		while($row = mysqli_fetch_assoc($result)) {
			//print details are stored in an array
				//see getPrintProperties() for indexing
			$printDet = getPrintProperties($con,$row['RequestID']);
			
			//print details stored in variables
			//REQUIRED
			$request_id = $printDet[0];
			$user_id = $printDet[1];
			$reqDate = $printDet[2];
			$contactPref = $printDet[4];
			
			//OPTIONAL
				//if date needed is not empty, assign it to the variable.
					//else, don't bother.  won't need to print it
			if(!empty($printDet[3])){$dateNeeded = $printDet[3];}
			
			//getUserDetails to get contact details
			//getPrintFormDetails to get quantity, color, customsize,custominstructions,forclass,originaldesign,clineuse
			
			//possibly split the custom instructions, size, color, and class into own functions to grab
			
		}
}

//get the print properties for displaying
/*
	Indexing Guide:
	0 - RequestID
	1 - UserID
	2 - Date Requested
	3 - Date Needed (still have to check if it's empty)
	4 - Contact Preference
	
	TODO:
		change to associative array 
		https://www.w3schools.com/PhP/php_arrays.asp
*/
function getPrintProperties($con,$printID) {
	$q = "SELECT * FROM `pqm`.`Requests` WHERE `RequestID` = '$printID' AND `Authorized` = '1'";
	$result = mysqli_query($con,$q);
	while($row = mysqli_fetch_assoc($result)) {
		$request_id = $row['RequestID'];
		$user_id = $row['UserID'];
		$reqDate = $row['DateRequested'];
		$dateNeed = $row['DateNeeded'];
		$contactPref = $row['ContactPreferenceID'];
	}
	$printProp = array($request_id, $user_id, $reqDate, $dateNeed, $contactPref);
	return $printProp;
}

//get the user's details for displaying
function getUserDetails($con,$userID) {

}

//get users print details entered via form
function getPrintFormDetails($con,$printID) {

}

//gets print details that staff enter
function getPrintStaffDetails($con,$printID) {

}













/* OLD DO NOT USE
function oldDrawRecords($con,$status) {
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
*/


?>
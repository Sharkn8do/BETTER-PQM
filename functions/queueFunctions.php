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
			$request_id = $printDet["RequestID"];
			$user_id = $printDet["UserID"];
			
			//OPTIONAL
				//if date needed is not empty, assign it to the variable.
					//else, don't bother.  won't need to print it
			if(!empty($printDet["DateNeeded"])){$dateNeeded = $printDet["DateNeeded"];}
			
			//user details array
			$userDets = getUserDetails($con,$user_id);
			//getPrintFormDetails to get quantity, color, customsize,custominstructions,forclass,originaldesign,clineuse
			
			//getPrintStaffDetails to get the weight,cost,print time, comments, and paid
			$staffDets = (getPrintStaffDetails($con,$request_id));
			
			echo $staffDets['Cost'];
			
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
	$printProp = array("RequestID" =>$request_id, "UserID"=>$user_id, "RequestDate" => $reqDate, "DateNeeded" => $dateNeed, "ContactPreferenceID" => $contactPref);
	return $printProp;
}

//get the user's details for displaying
function getUserDetails($con,$userID) {
	$q = "SELECT * FROM `pqm`.`Users` WHERE `UserID` = '$userID'";
	$result = mysqli_query($con,$q);
	
	while($row = mysqli_fetch_assoc($result)) {
		$firstName = $row['FirstName'];
		$lastName = $row['LastName'];
		$userEmail = $row['Email'];
		$userPhone = $row['PhoneNumber'];
		$userAffiliation = $row['AffiliationID'];
	}
	$userDet = array("FirstName"=>$firstName, "LastName"=>$lastName, "Email"=>$userEmail, "Phone"=>$userPhone, "nauAffiliation"=>$userAffiliation);
	return $userDet;
}

//get users print details entered via form
function getPrintFormDetails($con,$printID) {
	$q = "SELECT * FROM `pqm`.`3DFiles` WHERE `RequestID` = '$printID'";
	$result = mysqli_query($con,$q);
	
	while($row = mysqli_fetch_assoc($result)) {
		$fileID = $row['FileID'];
		$fileName = $row['FileName'];
		$quantity = $row['Quantity'];
		$colorID = $row['ColorID'];
		$customSizeBool = $row['CustomSize'];
		$customInstrBool = $row['CustomInstructions'];
		$forClassBool = $row['ForClass'];
		$originalDesignBool = $row['OriginalDesign'];
		$clineUseBool = $row['ClineUse'];
	}
	
	if(empty($customInstrBool)){$customInstrReturn ='Standard';}
	else {$customInstrReturn = getInstructions($con,$fileID);}
	
}

//gets print details that staff enter
function getPrintStaffDetails($con,$printID) {
	$q = "SELECT * FROM `pqm`.`specifications` WHERE `RequestID` = '$printID'";
	$result = mysqli_query($con,$q);
	
	while($row = mysqli_fetch_assoc($result)) {
		$printWeight = $row['Weight'];
		$printCost = $row['Cost'];
		$printHours = $row['PrintHours'];
		$printMinutes = $row['PrintMinutes'];
		$comments = $row['Comments'];
		$ICMPID = $row['ICMPID'];
		$paidYN = $row['Paid'];
	}
	$staffDet = array("Weight" => $printWeight, "Cost" => $printCost, "Hours" => $printHours,
		"Minutes" => $printMinutes, "Comments" => $comments, "ICMPID" => $ICMPID, "PaidStatus" => $paidYN);
	return $staffDet;
}

function getInstructions($con,$fileID) {
	$q = "SELECT * FROM `pqm`.`custominstructions` WHERE `FileID` = '$printID'";
	$result = mysqli_query($con,$q);
	
	while($row = mysqli_fetch_assoc($result)) {
		$layerHeight = $row['LayerHeight'];
		$infillAmt = $row['Infill'];
		$shellAmt = $row['Shells'];
	}
	$instructions = array("LayerHeight" => $layerHeight, "InfillAmount" => $infillAmt, "Shells" => $shellAmt);
	return $instructions;
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
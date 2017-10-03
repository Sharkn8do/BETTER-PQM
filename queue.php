<?php
require_once 'functions/dbconnect.php';
require 'functions/queueFunctions.php';
//Default sorting method, pull up all items in the queue
if(empty($_GET['sort'])){drawAllRecords($conn);}
else {
	$status = $_GET['sort'];
	//drawRecordStatus($conn,$status);
}
?>
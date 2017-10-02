<?php
require_once 'functions/dbConnect.php';
require 'functions/functions.php';
/*Default sorting method, pull up all items in the queue*/
if(empty($_GET['sort'])){$status = '';}
else {$status = $_GET['sort'];}
drawRecords($conn,$status);
?>
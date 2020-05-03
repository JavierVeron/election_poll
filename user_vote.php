<?php
include("classes/class.db.mysql.php");

if (!isset($_POST["user_state"])) {
	die("Error! The State value doesn´t exist!");
} else {
	$user_state = trim($_POST["user_state"]);	
}

if (!isset($_POST["user_candidate"])) {
	die("Error! The Candidate value doesn´t exist!");
} else {
	$user_candidate = trim($_POST["user_candidate"]);
}

$db = new db;
$query = "INSERT INTO poll (state_id, candidate_id, ip, timestamp) VALUES (" .$user_state .", " .$user_candidate .", '" .$_SERVER['REMOTE_ADDR'] ."', '" .date("Y-m-d H:i:s") ."')";

if ($db->query($query)) {
	echo json_encode(array("status" => "ok"));
} else {
	echo json_encode(array("status" => "error"));
}

$db->close();
?>
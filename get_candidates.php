<?php
include("classes/class.db.mysql.php");

$db = new db;
$query = "SELECT * FROM candidates ORDER BY 1";
$results = $db->query($query);

while ($row = $db->onerow($results)) {
	$output[] = array("id" => $row["candidate_id"], "name" => $row["candidate_name"], "image" => $row["candidate_image"]);
}

echo json_encode($output);
$db->close();
?>
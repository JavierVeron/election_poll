<?php
include("classes/class.db.mysql.php");

$db = new db;
$query = "SELECT * FROM states ORDER BY 1";
$results = $db->query($query);

while ($row = $db->onerow($results)) {
	$output[] = array("id" => $row["state_id"], "name" => $row["state_name"]);
}

echo json_encode($output);
$db->close();
?>
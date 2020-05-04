<?php
include("classes/class.db.mysql.php");

$db = new db;
$query = "SELECT count(*) AS total_votes FROM poll";
$results = $db->query($query);
$row = $db->onerow($results);
$total_votes = $row["total_votes"];

if ($total_votes > 0) {
	$output["status"] = "ok";
	$query = "SELECT p.candidate_id, c.candidate_name, c.candidate_image, count(*) as total FROM poll p, candidates c WHERE (p.candidate_id = c.candidate_id) GROUP BY p.candidate_id ORDER BY total DESC";
	$results = $db->query($query);

	while ($row = $db->onerow($results)) {
		$output["national"][] = array("id" => $row["candidate_id"], "name" => $row["candidate_name"], "image" => $row["candidate_image"], "total" => round(($row["total"] * 100) / $total_votes), "votes" => $row["total"]);
	}

	$query = "SELECT * FROM states ORDER BY 1";
	$results = $db->query($query);

	while ($row = $db->onerow($results)) {
		$query2 = "SELECT count(*) AS total_votes FROM poll WHERE (state_id = " .$row["state_id"] .")";
		$results2 = $db->query($query2);
		$row2 = $db->onerow($results2);
		$total_votes_states = $row2["total_votes"];

		if ($total_votes_states > 0) {
			$query3 = "SELECT p.candidate_id, c.candidate_name, c.candidate_image, count(*) as total FROM poll p, candidates c WHERE (p.candidate_id = c.candidate_id) AND (p.state_id = " .$row["state_id"] .") GROUP BY p.candidate_id ORDER BY total DESC";
			$results3 = $db->query($query3);
			$output2 = array();

			while ($row3 = $db->onerow($results3)) {
				$output2[] = array("id" => $row3["candidate_id"], "name" => $row3["candidate_name"], "image" => $row3["candidate_image"], "total" => round(($row3["total"] * 100) / $total_votes_states), "votes" => $row3["total"]);
			}

			$output["states"][] = array("state_id" => $row["state_id"], "state_name" => $row["state_name"], "results" => $output2);
		}
	}
} else {
	$output["status"] = "error";
}

echo json_encode($output);
$db->close();
?>
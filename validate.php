<?php
if (file_exists("config.php")) {
	echo json_encode(array("status" => "ok"));
} else {
	echo json_encode(array("status" => "error"));
}
?>
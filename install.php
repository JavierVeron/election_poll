<?php
if (!isset($_POST["name"])) {
	die("Error! You must enter the 'Name' of Data Base!");
} else {
	$name = trim($_POST["name"]);	
}

if (!isset($_POST["user"])) {
	die("Error! You must enter the 'User' of Data Base!");
} else {
	$user = trim($_POST["user"]);	
}

if (isset($_POST["password"])) {
	$password = trim($_POST["password"]);
} else {
	$password = "";
}

if (!isset($_POST["server"])) {
	die("Error! You must enter the 'Server' of Data Base!");
} else {
	$server = trim($_POST["server"]);	
}

if (isset($_POST["votes"])) {
	$votes = trim($_POST["votes"]);
} else {
	$votes = 0;
}

$filename = "config.php";
$content = "<?php\n";
$content.= "DEFINE('DB_NAME', '$name');\n";
$content.= "DEFINE('DB_USER', '$user');\n";
$content.= "DEFINE('DB_PASS', '$password');\n";
$content.= "DEFINE('DB_SERVER', '$server');\n";
$content.= "?>";
$file = fopen($filename, "w");
fputs($file, $content);
fclose($file);

include("classes/class.db.mysql.php");

if ($db = new db) {
	$sql_script = file("scripts/election_poll.sql");
	$query = "";
	$error = false;
	
	foreach ($sql_script as $num_line => $line) {
		$startWith = substr(trim($line), 0, 2);
		$endWith = substr(trim($line), -1 , 1);

		if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
			continue;
		}

		$query.= $line;

		if ($endWith == ";") {
			if ($db->query($query)) {
				$query = "";
			} else {
        		$error = true;
        		break;
        	}
    	}
    }

	$db->close();

	if ($votes == 1) {
		$db2 = new db;

    	for ($i=0; $i<1000; $i++) {
    		$query = "INSERT INTO poll (state_id, candidate_id, ip, timestamp) VALUES (" .rand(1, 50) .", " .rand(1, 3) .", '" .$_SERVER['REMOTE_ADDR'] ."', '" .date("Y-m-d H:i:s") ."');";

    		if (!$db2->query($query)) {
    			$error = true;
    			break;
    		}
    	}

    	$db2->close();
    }

    if ($error) {
    	echo json_encode(array("status" => "error"));
    } else {
    	echo json_encode(array("status" => "ok"));
    }
} else {
	echo json_encode(array("status" => "error"));
}
?>
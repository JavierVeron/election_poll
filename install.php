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

$password = trim($_POST["password"]);

if (!isset($_POST["server"])) {
	die("Error! You must enter the 'Server' of Data Base!");
} else {
	$server = trim($_POST["server"]);	
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

    if ($error) {
    	echo json_encode(array("status" => "error"));
    } else {
    	echo json_encode(array("status" => "ok"));
    }

	$db->close();
} else {
	echo json_encode(array("status" => "error"));
}
?>
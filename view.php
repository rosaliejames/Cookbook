<?php
	$table = trim($_POST["table"]);
	$title = trim($_POST["title"]);
	
	$db = new mysqli('localhost', 'root', "", 'PLWA');
	if ($db->connect_error): 
	 die ("Could not connect to db " . $db->connect_error); 
	endif;

	$result = $db->query("select * from $table where $table.title = '$title'") or die ("Invalid: " . $db->error);
	$rows = $result->num_rows; 
	$arr = $result->fetch_array();
	//Array();
	// for ($i = 0; $i < $rows; $i++) { 
	// 	array_push($arr, $result->fetch_array());
	// }
	$returndata = json_encode($arr);
	echo $returndata;
?>
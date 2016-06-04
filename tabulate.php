<?php
	if (isset($_POST["table"])) :
		$whichTable = $_POST["table"];
	// else : 
	// 	$whichTable = "FavoritesMenu";
	endif;
	
	$db = new mysqli('localhost', 'root', "", 'PLWA');
	if ($db->connect_error): 
	 die ("Could not connect to db " . $db->connect_error); 
	endif;

	$result = $db->query("select * from $whichTable") or die ("Invalid: " . $db->error);
	$rows = $result->num_rows; 
	$arr = Array();
	for ($i = 0; $i < $rows; $i++) { 
		array_push($arr, $result->fetch_array());
	}
	$returndata = json_encode($arr);
	echo $returndata;
?>
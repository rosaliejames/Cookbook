<?php
	$table = trim($_POST["table"]);	
	$title = trim($_POST["title"]); 
	
	$db = new mysqli('localhost', 'root', "", 'PLWA');
	if ($db->connect_error): 
	 die ("Could not connect to db " . $db->connect_error); 
	endif;

	$query = "delete from $table where $table.title='$title'";
	$db->query($query) or die ("Invalid: " . $db->error);
?>


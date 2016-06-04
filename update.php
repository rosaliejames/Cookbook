<?php
	$table = trim($_POST["table"]);
	$title = trim($_POST["title"]);
	$ingredients = trim($_POST["ingredients"]);
	$directions = trim($_POST["directions"]); 
	$rating = trim($_POST["rating"]);
	
	// $table = "BreakfastMenu";
	// $title = trim("Pancakes");
	// $ingredients = "Ing100#Ing200";
	// $directions = "Dir10#Dir19"; 
	// $rating = 99;

	$db = new mysqli('localhost', 'root', "", 'PLWA');
	if ($db->connect_error): 
	 die ("Could not connect to db " . $db->connect_error); 
	endif;
	
	$query = "select * from $table where $table.title='$title'";
	$result = $db->query($query) or die ("Invalid: " . $db->error);
	$rows = $result->num_rows;

	if ($rows < 1 ) :
		$query = "insert into $table values (NULL, '$title', '$ingredients', '$directions', '$rating')";
		$result = $db->query($query) or die ("Invalid: " . $db->error);
	else : 
		$query = "update $table set $table.ingredients = '$ingredients', $table.directions= '$directions', $table.rating = $rating where $table.title='$title'";
		$result = $db->query($query) or die ("Invalid: " . $db->error);	
	endif;
?>
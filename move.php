<?php

	$table = trim($_POST["table"]);	
	$dest = trim($_POST["dest"]);
	$title = trim($_POST["title"]); 
	
	$db = new mysqli('localhost', 'root', "", 'PLWA');
	if ($db->connect_error): 
	 die ("Could not connect to db " . $db->connect_error); 
	endif;

	$query = "select * from $table where $table.title='$title'";
	//echo $query;
	$result = $db->query($query) or die ("Invalid: " . $db->error);
	// print_r($result);
	$recipe = $result->fetch_array();
	// print_r($recipe);

	$title = $recipe["title"];
	$ingredients = $recipe["ingredients"];
	$directions = $recipe["directions"];
	$rating = $recipe["rating"];
	
	$query = "delete from $table where $table.title='$title'";
	$db->query($query) or die ("Invalid: " . $db->error);

	$query = "insert into $dest values (NULL, '$title', '$ingredients', '$directions', '$rating')";
	$db->query($query) or die ("Invalid: " . $db->error);


?>
<?php
//sets up DB
$db = new mysqli('localhost', 'root', "", 'PLWA');
if ($db->connect_error): 
 die ("Could not connect to db " . $db->connect_error); 
endif;

//drops existing tables
$db->query("drop table BreakfastMenu"); 
$db->query("drop table DessertMenu"); 
$db->query("drop table FavoritesMenu"); 

//makes new tables
$result = $db->query("create table BreakfastMenu (id int primary key not null auto_increment, title varchar(30), ingredients varchar(150), directions varchar(150), rating int)") or die ("Invalid: " . $db->error);

$result = $db->query("create table DessertMenu (id int primary key not null auto_increment, title varchar(30), ingredients varchar(150), directions varchar(150), rating int)") or die ("Invalid: " . $db->error);

$result = $db->query("create table FavoritesMenu (id int primary key not null auto_increment, title varchar(30), ingredients varchar(150), directions varchar(150), rating int)") or die ("Invalid: " . $db->error);

//reads in XML
$xml=simplexml_load_file("cookbook.xml") or die("Error: Cannot create object");
$json = json_encode($xml);
$array = json_decode($json,TRUE);
$breakfastmenu = $array["categories"]["BreakfastMenu"];
foreach($breakfastmenu["recipe"] as $recipeobj) { 
	$title = trim($recipeobj["title"]);
	$ingredients = trim($recipeobj["ingredients"]);
	$directions = trim($recipeobj["directions"]);
	$rating = trim($recipeobj["rating"]);
	$query = "insert into BreakfastMenu values (NULL, '$title', '$ingredients', '$directions', '$rating')"; 
	$db->query($query) or die ("Invalid insert " . $db->error);
}
$dessertmenu = $array["categories"]["DessertMenu"];
foreach($dessertmenu["recipe"] as $recipeobj) { 
	$title = trim($recipeobj["title"]);
	$ingredients = trim($recipeobj["ingredients"]);
	$directions = trim($recipeobj["directions"]);
	$rating = trim($recipeobj["rating"]);
	$query = "insert into DessertMenu values (NULL, '$title', '$ingredients', '$directions', '$rating')"; 
	$db->query($query) or die ("Invalid insert " . $db->error);
}
$favoritesmenu = $array["categories"]["FavoritesMenu"];
foreach($favoritesmenu["recipe"] as $recipeobj) { 
	$title = trim($recipeobj["title"]);
	$ingredients = trim($recipeobj["ingredients"]);
	$directions = trim($recipeobj["directions"]);
	$rating = trim($recipeobj["rating"]);
	$query = "insert into FavoritesMenu values (NULL, '$title', '$ingredients', '$directions', '$rating')"; 
	$db->query($query) or die ("Invalid insert " . $db->error);
}


// foreach ($array["Breakfast_menu"] as $breakfastobj) {
//     foreach($breafastobj["recipe"] as $recipeobj) { 
// 		$title = $recipeobj["title"];
// 		$ingedients = $recipeobj["ingredients"];
// 		$directions = $recipeobj["directions"];
// 		$rating = $recipeobj["rating"];
// 		$query = "insert into BreakfastMenu values (NULL, '$title', '$ingredients', '$directions', '$rating')"; 
// 		$db->query($query) or die ("Invalid insert " . $db->error);
// 	}
// }
// foreach ($array["Dessert_menu"] as $dessertobj) {
//     foreach($dessertobj["recipe"] as $recipeobj) { 
// 		$title = $recipeobj["title"];
// 		$ingedients = $recipeobj["ingredients"];
// 		$directions = $recipeobj["directions"];
// 		$rating = $recipeobj["rating"];
// 		$query = "insert into DessertMenu values (NULL, '$title', '$ingredients', '$directions', '$rating')"; 
// 		$db->query($query) or die ("Invalid insert " . $db->error);
// 	}
// }
// foreach ($array["Favorites_menu"] as $favoritesobj) {
//     foreach($favoritesobj["recipe"] as $recipeobj) { 
// 		$title = $recipeobj["title"];
// 		$ingedients = $recipeobj["ingredients"];
// 		$directions = $recipeobj["directions"];
// 		$rating = $recipeobj["rating"];
// 		$query = "insert into FavoritesMenu values (NULL, '$title', '$ingredients', '$directions', '$rating')"; 
// 		$db->query($query) or die ("Invalid insert " . $db->error);
// 	}
// }    
 
echo "Successfully initialized!"
?>
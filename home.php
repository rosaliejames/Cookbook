<head> 
<link rel="stylesheet" type="text/css" href="style.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type = "text/javascript"> 
$(document).ready(function() { 
	// display categories
	//opens cookbood, removes image and shows categories
	$(document).on('click', '#open', function() {	
		var newForm = "<form id='selectMenu'>"
		newForm += '<input type="radio" name="radioName" value="BreakfastMenu">Breakfast';
		newForm += '<input type="radio" name="radioName" value="DessertMenu">Dessert '; 
		newForm += '<input type="radio" name="radioName" value="FavoritesMenu">Favorites';
		$("form").replaceWith(newForm); 
		$("#open").remove();
		$("#buttons").append('<button id="return3">Return</button>');
		$("h3").text("Categories");
		$("img").remove();
	});

	//shows recipes for selected category
	$(document).on('change', '#selectMenu', function() {
	   var whichTable = ($('input[name=radioName]:checked', '#selectMenu').val()); 
	   $.post("tabulate.php", {"table" : whichTable}, function(data) { 
			var recipes = JSON.parse(data);
			var selectMenu = document.getElementById("selectMenu");
			// var myForm = "<form id=" + whichTable + " action=''>";
			myTable = "<table id='theTable'>";
			myTable += "<th>Actions</th><th>Title</th><th>Rating</th>"
			mySelect = "<select id='movdel'><option disabled selected value> -- select an option -- </option></option><option value='movebreakfast'>Move to Breakfast</option><option value='movedessert'>Move to Dessert</option><option value='movefavorites'>Move to Favorites</option><option value='delete'>Delete</option></select>"
			for (var i = 0; i < recipes.length; i++) { 
				//newTable += "<tr>";
				//myForm += "<input type='radio' name='radioName' value=" + i + ">" + recipes[i][1] + "<br/>";
				myTable += "<tr><td>" + mySelect + "</td><td><a href='#' id='view'>" + recipes[i][1] + "</a></td><td>"+ recipes[i][4]+ "</td>";
			}
			// myForm += "</form>";
			myTable += "</table>"
			$("table").replaceWith(myTable);
			//$("#selectMenu").replaceWith(myForm);
			$("h3").text(whichTable);
			currtable = whichTable;
			$("#buttons").empty();
			$("#buttons").append("<button id='return1'>Return</button>");
			$("#selectMenu").empty();
			$("#buttons").append("<button id='sort'>Sort</button>");
			$("#buttons").append("<button id='addrecipe'>Add Recipe</button>");
		});
	   });
	//sorts recipes by rating 
	$(document).on('click', '#sort', function() {	
		var items = new Array();
		$("tr").not(":first").each( function(i, obj) { 
			var title = $(this).find("td:eq(1)").text();
			var rating = $(this).find("td:eq(2)").text();
			var item = {title:title, rating:rating};
			items.push(item);
		});

		items.sort(function(a,b) { 
			return (b.rating - a.rating);
		});

		myTable = "<table id='theTable'>";
		myTable += "<th>Actions</th><th>Title</th><th>Rating</th>"
		mySelect = "<select id='movdel'><option disabled selected value> -- select an option -- </option></option><option value='movebreakfast'>Move to Breakfast</option><option value='movedessert'>Move to Dessert</option><option value='movefavorites'>Move to Favorites</option><option value='delete'>Delete</option></select>"
		for (var i = 0; i < items.length; i++) { 
			myTable += "<tr><td>" + mySelect + "</td><td><a href='#' id='view'>" + items[i].title + "</a></td><td>"+ items[i].rating + "</td>";
		}
		myTable += "</table>"
		$("table").replaceWith(myTable);



	});  
	
	//returns
	$(document).on('click', '#return1', function() {	
		var newForm = "<form id='selectMenu'>"
		newForm += '<input type="radio" name="radioName" value="BreakfastMenu">Breakfast';
		newForm += '<input type="radio" name="radioName" value="DessertMenu">Dessert '; 
		newForm += '<input type="radio" name="radioName" value="FavoritesMenu">Favorites';
		$("form").replaceWith(newForm); 
		$("table").empty();
		currtable = null;
		var myButton = "<button id='return3'>Return</button>";
		$("#return1").replaceWith(myButton);
		$("#addrecipe").remove();
	});
	//returns
	$(document).on('click', '#return3', function() {	
		$("form").empty(); 
		$("table").empty();
		currtable = null;
		var openbutton = "<button id='open'>Open</button>";
		$("#buttons").empty();
		$("#buttons").append(openbutton);
		$("h3").empty();
		$("h1").after("<img src='baking.jpg' width=500px>");
	});
	//returns
	$(document).on('click', '#return2', function() {	
		$.post("tabulate.php", {"table" : currtable}, function(data) { 
			var recipes = JSON.parse(data);
			//var newTable = "<table id='theTable' border='1' style='border-collapse:collapse'>";
			var selectMenu = document.getElementById("selectMenu");
			//var myForm = "<form id=" + currtable + " action=''>";
			myTable = "<table id='theTable'>";
			myTable += "<th>Actions</th><th>Title</th><th>Rating</th>"
			mySelect = "<select id='movdel'><option disabled selected value> -- select an option -- </option></option><option value='movebreakfast'>Move to Breakfast</option><option value='movedessert'>Move to Dessert</option><option value='movefavorites'>Move to Favorites</option><option value='delete'>Delete</option></select>"
			for (var i = 0; i < recipes.length; i++) { 
				//newTable += "<tr>";
				//myForm += "<input type='radio' name='radioName' value=" + i + ">" + recipes[i][1] + "<br/>";
				myTable += "<tr><td>" + mySelect + "</td><td><a href='#' id='view'>" + recipes[i][1] + "</a></td><td>"+ recipes[i][4]+ "</td>";
			}
			//myForm += "</form>";
			myTable += "</table>"
			$("table").replaceWith(myTable);
			//$("#selectMenu").replaceWith(myForm);
			$("h3").text(currtable);
			$("#save").remove();
			$("#buttons").empty();
			$("#buttons").append("<button id='return1'>Return</button>");
			$("#buttons").append("<button id='sort'>Sort</button>");
			$("#buttons").append("<button id='addrecipe'>Add Recipe</button>");
		});
	});

	//removes from table
	$(document).on('click', '#delete', function() {	
		$(this).closest("tr").remove();
	});

	//saves changes
	$(document).on('click', '#save', function() {	
		//alert("here");
		var title = $("th:contains('Title')").closest("tr").find("td:eq(0)").text();//find("input").val();
		if (title === "") { 
			title = $("th:contains('Title')").closest("tr").find("td:eq(0)").find("input").val().trim();
			//alert("this happened");

		}
		//alert(title);
		var ingredients = ""; 
		var length = $(".ingredients").length;
		$(".ingredients").each( function(i, obj) { 
			ingredients += $(this).find("td:eq(0)").find("input").val().trim(); 
			if (i < length-1) { 
				ingredients += "#";
			}
		});
		//alert(ingredients);
		var directions = ""
		length = $(".directions").length;
		$(".directions").each( function(i, obj) { 	
			directions += $(this).find("td:eq(0)").find("input").val().trim(); 
			if (i < length-1) { 
				directions += "#";
			} 
		});
		//alert(directions);
		var rating = $(".rating td:eq(0)").find("input").val().trim();
		var request = $.post("update.php", {"table" : currtable, "title" : title, "ingredients" : ingredients, "directions" : directions, "rating" : rating}, function(data) {
		});
		request.done(function() {
			//alert("here");
		$.post("tabulate.php", {"table" : currtable}, function(data) { 
			var recipes = JSON.parse(data);
			//var newTable = "<table id='theTable' border='1' style='border-collapse:collapse'>";
			var selectMenu = document.getElementById("selectMenu");
			//var myForm = "<form id=" + currtable + " action=''>";
			myTable = "<table id='theTable'>";
			myTable += "<th>Actions</th><th>Title</th><th>Rating</th>"
			mySelect = "<select id='movdel'><option disabled selected value> -- select an option -- </option></option><option value='movebreakfast'>Move to Breakfast</option><option value='movedessert'>Move to Dessert</option><option value='movefavorites'>Move to Favorites</option><option value='delete'>Delete</option></select>"
			for (var i = 0; i < recipes.length; i++) { 
				//newTable += "<tr>";
				//myForm += "<input type='radio' name='radioName' value=" + i + ">" + recipes[i][1] + "<br/>";
				myTable += "<tr><td>" + mySelect + "</td><td><a href='#' id='view'>" + recipes[i][1] + "</a></td><td>"+ recipes[i][4]+ "</td>";
			}
			//myForm += "</form>";
			myTable += "</table>"
			$("table").replaceWith(myTable);
			//$("#selectMenu").replaceWith(myForm);
			$("h3").text(currtable);
			$("#save").remove();
			$("#return2").replaceWith("<button id='return1'>Return</button>");
			$("#buttons").append("<button id='sort'>Sort</button>");
			$("#buttons").append("<button id='addrecipe'>Add Recipe</button>");
		});
		});

	});
	//adds ingredient or direction
	$(document).on('click', '#add', function() {	
		if ($(this).val() === "ingredient") { 
			//var newval = prompt("Ingredent to add", "");
			var newval = $(this).closest("tr").find("td:eq(0)").find("input").val().trim();
			//alert(newval);
			$(this).closest("tr").find("td:eq(0)").find("input").val("");
			var newrow = "<tr class='ingredients'><th></th><td><input type='text' value='" + newval + "'></td><td>";
			newrow += "<button id = 'delete'>Delete</button>";
			newrow += "</td></tr>";
			var length = $(".ingredients").length;
			$("table tr:eq(" + length + ")").after(newrow);
		} else if ($(this).val() === "direction"){ 
			//var newval = prompt("Instruction: ", "");
			//var num = prompt("Instruction number: ", "");
			var newval = $(this).closest("tr").find("td:eq(0)").find("input").val().trim();
			$(this).closest("tr").find("td:eq(0)").find("input").val("");
			var newrow = "<tr class='directions'><th></th><td><input type='text' value= '" + newval + "'></td><td>";
			newrow += "<button id = 'delete'>Delete</button>";
			newrow += "</td></tr>";
			$(".directions:last").after(newrow);
		}
	});

	//adds new field
	$(document).on('click', '#addfield', function() {	
		var type = $(this).closest("tr").attr("class");
		var newrow = "<tr class = " + type + "><th></th><td><input type='text' value=''></td><td><button id='addfield'>Add</button></td></tr>";
		$(this).closest("tr").after(newrow);
		$(this).closest("tr").find("td:eq(1)").empty();
		
		//alert(newrow);
		//find("td:eq(1)").find("input").attr("class");
		// alert(type);
		// $(this).closest("tr").after("");
		// row.after()
		// newrow.find("td:eq(1)").find("input").val("");
		// $(this).closest("tr").after(newrow);
	});

	//moves or deletes selected recipe
	$(document).on('change', '#movdel', function() {
		var title = $(this).closest("td").siblings(":first").text();
		var request;
		if ($(this).val() === "delete") { 
			request = $.post("delete.php", {"table" : currtable, "title" : title}, function(data) {
			});
		} else if ($(this).val() === "movebreakfast"){ 
			var dest = "BreakfastMenu";
			request = $.post("move.php", {"table" : currtable, "title" : title, "dest" : dest}, function(data) {
			});
		} else if ($(this).val() === "movedessert") { 
			var dest = "DessertMenu";
			request = $.post("move.php", {"table" : currtable, "title" : title, "dest" : dest}, function(data) {
			});
		} else if ($(this).val() === "movefavorites") { 
			var dest = "FavoritesMenu";
			request = $.post("move.php", {"table" : currtable, "title" : title, "dest" : dest}, function(data) {
			});
		}
		request.done(function() {	
		$.post("tabulate.php", {"table" : currtable}, function(data) { 
			var recipes = JSON.parse(data);
			//var newTable = "<table id='theTable' border='1' style='border-collapse:collapse'>";
			var selectMenu = document.getElementById("selectMenu");
			//var myForm = "<form id=" + currtable + " action=''>";
			myTable = "<table id='theTable'>";
			myTable += "<th>Actions</th><th>Title</th><th>Rating</th>"
			mySelect = "<select id='movdel'><option disabled selected value> -- select an option -- </option></option><option value='movebreakfast'>Move to Breakfast</option><option value='movedessert'>Move to Dessert</option><option value='movefavorites'>Move to Favorites</option><option value='delete'>Delete</option></select>"
			for (var i = 0; i < recipes.length; i++) { 
				//newTable += "<tr>";
				//myForm += "<input type='radio' name='radioName' value=" + i + ">" + recipes[i][1] + "<br/>";
				myTable += "<tr><td>" + mySelect + "</td><td><a href='#' id='view'>" + recipes[i][1] + "</a></td><td>"+ recipes[i][4]+ "</td>";
			}
			//myForm += "</form>";
			myTable += "</table>"
			$("table").replaceWith(myTable);
			//$("#selectMenu").replaceWith(myForm);
			$("h3").text(currtable);
		});
		});
	});

	//adds new recipe
	$(document).on('click', '#addrecipe', function() {	
		var newTable = "<table id='theTable'>";
			newTable += "<tr><th>Title: </th><td><input type='text'></input></td><td></td></tr>";
			newTable += "<tr class='ingredients'><th> Ingredients: </th><td><input type = 'text' value=''></td><td></td></tr>";
			newTable += "<tr class='ingredients'><th></th><td><input type='text' value=''></td><td><button id='addfield' value='ingredient'>Add</button>"	
			newTable += "<tr class='directions'><th>Directions: </th><td><input type='text' value=''></td><td></td></tr>";
			newTable += "<tr class='directions'><th></th><td><input type='text' value=''></td><td><button id='addfield' value='direction'>Add</button>"
			newTable += "<tr class = 'rating'><th>Rating: </th><td><input type='text' value=''</td><td></td></tr>";
			newTable += "</table>";
			$("#theTable").replaceWith(newTable);
			$("h3").text("Add Recipe");
			var returnbutton = "<button id='return2'>Return</button>";
			var savebutton = "<button id='save'>Save & Return</button>";
			$("#buttons").empty();
			$("#buttons").append(returnbutton);
			$("#buttons").append(savebutton);
	});

	//selects recipe to view
	$(document).on('click', '#view', function() { 
		var recipe = $(this).text();
		 $.post("view.php", {"table" : currtable, "title" : recipe}, function(data) { 
			var recipe = JSON.parse(data);
			var newTable = "<table id='theTable'>";
			//var oldMenu = document.getElementById("BreakfastMenu");
			newTable += "<tr><th>Title: </th><td>" + recipe[1] + "</td><td></td></tr>";
			var ingredients = recipe[2].split("#");
			var del = "<button id = 'delete'>Delete</button>";
			newTable += "<tr class='ingredients'><th> Ingredients: </th><td><input type = 'text' value='" + ingredients[0] + "'></td><td>"+ del +"</td></tr>";
			for (var i = 1; i < ingredients.length; i++) { 
				newTable += "<tr class='ingredients'><th></th><td><input type = 'text' value='" + ingredients[i] + "'></td><td>"+ del +"</td></tr>";
			}
			newTable += "<tr><th></th><td><input type='text' value=''></td><td><button id='add' value='ingredient'>Add</button>"	
			var directions = recipe[3].split("#");
			newTable += "<tr class='directions'><th>Directions: </th><td><input type='text' value=" + directions[0] + "></td><td>"+ del +"</td></tr>";
			for (var i = 1; i < directions.length; i++) { 
				newTable += "<tr class='directions'><th></th><td><input type='text' value='" + directions[i] + "'></td><td>"+ del +"</td></tr>";
			}
			newTable += "<tr><th></th><td><input type='text' value=''></td><td><button id='add' value='direction'>Add</button>"
			newTable += "<tr class = 'rating'><th>Rating: </th><td><input type='text' value=" + recipe[4] + "></td><td>"+ del +"</td></tr>";
			newTable += "</table>";
			$("#theTable").replaceWith(newTable);
			$("h3").text(recipe[1]);
			var returnbutton = "<button id='return2'>Return</button>";
			var savebutton = "<button id='save'>Save & Return</button>";
			$("#buttons").empty();
			$("#buttons").append(returnbutton);
			$("#buttons").append(savebutton);
		});
		});
	});
	

</script>
</head>
<body> 
<div id="page" align="center">
	<h1>Rosalie's Cookbook</h1>
	<img src="baking.jpg" width=500px>
	<h3></h3>
	<form id="selectMenu" action=""> 
	</form>

	<table id = "theTable"> </table>
	<div id="buttons">
		<button id="open">Open</button>
	</div>
</div>
</body>
<script> 
var currtable;
</script>
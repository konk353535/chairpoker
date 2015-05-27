




<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Townsville Community Music Centre</title>
	<link href="mainstyle.css" rel="stylesheet" type="text/css">

	<!-- Google Fonts Open Sans -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

	<!-- Date Picker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript">
		// use this to keep track of how many selects are in the form and what ids to assign them
		var numberSelects = 1;
		function addNewCategoryField(){
			numberSelects++;
			document.getElementById("NumberOfCategories").value = numberSelects;
			// create a new collection of <option>s to put in the new select
			var options = $(document.getElementById("ArtistCategory1").options).clone();
			var newSelect = document.createElement('select');
			for(var i = 0; i < options.length; ++i){
				newSelect.appendChild(options[i]);
			}
			newSelect.id = "ArtistCategory" + numberSelects;
			newSelect.name = "ArtistCategory" + numberSelects;
			newSelect.className = "block";
			document.getElementById("categorySelectsContainer").appendChild(newSelect);
		}
	</script>
</head>

<body>

<!-- Logo + Login Form + Text Title -->
<?php include('template/header.php'); ?>
<!-- End of header (Logo/LoginForm/TextTitle) -->

<!-- Nav Bar -->
<?php include('template/inc_nav.php'); ?>

<!-- All Content -->
<div class="allContent bgPrimary">
    <div class="mainContent">
		<?php
			if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] == 1){
				echo "<div class='error_message'>You need to be logged in with administrator rights to access this resource</div>";
			}
			else if(isset($_GET['artist_id'])){
				include('db_connect.php');
				$artistStatement = $dbh->prepare('SELECT * FROM Artist WHERE Artist_Id = ?');
				$artistStatement->execute(array($_GET['artist_id']));
				$artist = $artistStatement->fetch();
		?>
			<form id='editArtistForm' method='post' action='artists.php?action=edit_artist&artist_id=<?php echo $artist['Artist_Id']?>' onsubmit="return input_validate_update_artist()">
				<label class='label' for='Artist_Fnames'>First name:</label>
				<input class='block' type='text' id='Artist_Fnames' name='Artist_Fnames' value='<?php echo $artist['Artist_Fnames'] ?>'>
				<label class='label' for='Artist_Sname'>Surname:</label>
				<input class='block' type='text' id='Artist_Sname' name='Artist_Sname' value='<?php echo $artist['Artist_Sname'] ?>'>
				<label class='label' for='Artist_Email'>Email:</label>
				<input class='block' type='text' id='Artist_Email' name='Artist_Email' value='<?php echo $artist['Artist_Email'] ?>'>
				<label class='label' for='Artist_PhoneDay'>Daytime Phone:</label>
				<input class='block' type='text' id='Artist_PhoneDay' name='Artist_PhoneDay' value='<?php echo $artist['Artist_PhoneDay'] ?>'>
				<label class='label' for='Artist_Mobile'>Mobile Phone:</label>
				<input class='block' type='text' id='Artist_Mobile' name='Artist_Mobile' value='<?php echo $artist['Artist_Mobile'] ?>'>
				<div id='categorySelectsContainer'>
					<select class='block' id='ArtistCategory1' name='ArtistCategory1'>
						<?php 
							$categories = $dbh->query("SELECT * FROM Category");
							while($row = $categories->fetch()){
								echo "<option value='" . $row['Category_Id'] . "'>" . $row['Category_Name'] . "</option>\n";
							}
						?>
					</select>
				</div>
				<input type='text' name='Artist_Id' value='<?php echo $_GET['artist_id']; ?>' hidden>
				<input type='text' name='NumberOfCategories' id='NumberOfCategories' value='1' hidden>
				<input type='button' id='addNewCategory' value='additional category'>
				<input type='submit' name='editArtistForm' value='Confirm Changes'>
			</form>
			<div id='errorOutput' class='error_message' hidden></div>
		<?php
				
			}
		?>
	</div>
</div>
<script type='text/javascript'>
function input_validate_update_artist(){
	var messages = "";
	if(document.getElementById("Artist_Fnames").value.trim() === ""){
		messages += "Please enter a First name.<br/>";
	}
	if(document.getElementById("Artist_Sname").value.trim() === ""){
		messages += "Please enter a Surnname.<br/>";
	}
	if(document.getElementById("Artist_Email").value.trim() === ""){
		messages += "Please enter an Email address.<br/>";
	}
	if(document.getElementById("Artist_PhoneDay").value.trim() === ""){
		messages += "Please enter a Daytime phone contact.<br/>";
	}
	if(document.getElementById("Artist_Mobile").value.trim() === ""){
		messages += "Please enter a Mobile Phone Number.<br/>";
	}
	var categories = {};
	var hasMatches = false;
	for(var i = 1; i <= numberSelects; ++i){
		categories[i] = document.getElementById("ArtistCategory" + i).value;
		for(var j = 1; j < Object.keys(categories).length; ++j){
			if(categories[i] === categories[j]){
				hasMatches = true;
			}
		}
	}
	if(hasMatches){
		messages += "Please do not submit duplicate categories.<br/>";
	}
	if(messages !== ""){
		document.getElementById("errorOutput").hidden = false;
		document.getElementById("errorOutput").innerHTML = messages.trim();
		return false;
	}
	return true;
}
document.getElementById("addNewCategory").addEventListener('click', addNewCategoryField);
</script>
</body>
</html>
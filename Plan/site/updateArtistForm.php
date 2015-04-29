<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Update Artist</title>
    <script type='text/javascript'>
    	var currentDropDownCount = 1;
    	function create_new_category_dropdown(categoriesFields, categoriesValues, dropDownNo)
    	{
    		currentDropDownCount++;
    		var stringToConcatenate = "";
    		stringToConcatenate += "<select name='C_Id[" + dropDownNo + "]'>\n";
    		for(var i = 0; i < categoriesFields.length; i++)
    		{
    			stringToConcatenate += "<option value='"  + categoriesFields[i] + "'>" + categoriesValues[i];
    		}
    		stringToConcatenate += "</select><br/>";
    		categoryContainer.innerHTML += stringToConcatenate;
    	}
    </script>
</head>
<body>

<form name="artistEdit" method="post" action="updateArtistProcess.php">
<?php
	$artist_id = $_GET["artist_id"];
	$artist_row = $dbh->query("SELECT * FROM Artist WHERE A_Id = " . $artist_id)->fetch(PDO::FETCH_ASSOC);
	// pass $artist_id to the next page
	echo "<input type='hidden' name='A_Id' value ='" . $artist_id . "'>";
	echo "<p>\n<label for='A_Title'>Artist Title: </label>\n" .
		 "<input type='text' name='A_Title' value='" . $artist_row["A_Title"] . "'>\n</p>\n";
	echo "<div id='categoryContainer'>";
	$number_of_categories = $dbh->query("SELECT COUNT(*) FROM ArtistCategory WHERE A_Id = " . $artist_id)->fetch()[0];
	$artist_categories = $dbh->query("SELECT C_Id FROM ArtistCategory WHERE A_Id = " . $artist_id);
	$i = 0;
	foreach($artist_categories as $iRow)
	{


		echo "<select name='C_Id[" . $i . "]'>\n";
		$categories = $dbh->query("SELECT * FROM Category");
		//construct arrays to pass to javascript 
		$category_fields = array();
		$category_values = array();
		foreach($categories as $jRow)
		{
			if($jRow["C_Id"] == $iRow["C_Id"])
				echo "<option value='" . $jRow["C_Id"] ."' selected>" . $jRow["C_Name"] . "</option>\n";
			else
				echo "<option value='" . $jRow["C_Id"] ."'>" . $jRow["C_Name"] . "</option>\n";
			array_push($category_fields, $jRow["C_Id"]);
			array_push($category_values, $jRow["C_Name"]);
		}
		echo "</select><br/>";
		echo "</div>";
		$i++;
	}
	?>
	<script type='text/javascript'>
		var categoriesFields = <?php echo json_encode($category_fields); ?>;
		var categoriesValues = <?php echo json_encode($category_values); ?>;
	</script>
	<?php
	echo "<input type='button' value='Add new Category' onClick='create_new_category_dropdown(categoriesFields, categoriesValues, currentDropDownCount)'>";  
	echo "<p>\n<label for='A_Email'>Email: </label>\n" .
		 "<input type='text' name='A_Email' value='" . $artist_row["A_Email"] . "'>\n</p>\n" .
		 "<p>\n<label for='A_PhoneDay'>Phone (Daytime): </label>\n" .
		 "<input type='text' name='A_PhoneDay' value='" . $artist_row["A_PhoneDay"] . "'>\n</p>\n" .
		 "<p>\n<label for='A_PhoneAfter'>Phone (After hours): </label>\n" .
		 "<input type='text' name='A_PhoneAfter' value='" . $artist_row["A_PhoneAfter"] . "'>\n</p>\n" .
		 "<p>\n<label for='A_Mobile'>Phone (Mobile): </label>\n" .
		 "<input type='text' name='A_Mobile' value='" . $artist_row["A_Mobile"] . "'>\n</p>\n" .
		 "<input type='submit' name='submit' value='confirm changes'>\n";
		 

?>

<a href='updateArtist.php'>Return to List without saving</a>

</form>
</body>
</html>
<?php include("db_connect.php") ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Insert new artist</title>
</head>
<body>
<h1>Insert new Artist:</h1>
<!-- currently no implementation for uploading multiple images -->
<form name="insertForm" enctype="multipart/form-data" method="post" action="newArtistProcess.php">
	<p>
		<label for="A_Title">Artist Title: </label>
		<input type="text" name="A_Title">
	</p>
	<p>
		<div id="categoryDropDownsContainer">
			<label for="C_Id">Artist Category: </label>
			<select name="C_Id">
			<!-- grab all categories currently in the database -->
			<?php
				$categories = $dbh->query("SELECT * FROM Category");
				foreach($categories as $row)
				{
					echo "<option value='" . $row["C_Id"] ."'>" . $row["C_Name"] . "</option>\n";
				}
			?>
			</select>
		</div>
	</p>
	<p>
		<label for="A_Email">Email: </label>
		<input type="text" name="A_Email">
	</p>
	<p>
		<label for="A_PhoneDay">Phone number (Day hours): </label>
		<input type="text" name="A_PhoneDay">
	</p>
	<p>
		<label for="A_PhoneAfter">Phone number (After hours): </label>
		<input type="text" name="A_PhoneAfter">
	</p>
	<p>
		<label for="A_Mobile">Mobile Phone number: </label>
		<input type="text" name="A_Mobile">
	</p>
	<p>
		<label for="ArtistImage">Artist Photo File: </label>
		<input type="file" name="ArtistImage" />
	</p>
	<p>
		<input type="submit" name="submit" value="Insert New Artist">
	</p>

</form>

<h2>Current records in database: </h2>

<?php
	$artists = $dbh->query("SELECT * FROM Artist");
	echo "<table border='1'>\n";
	echo "<tr><th>A_Id</th><th>A_Title</th><th>A_Email</th><th>A_PhoneDay</th><th>A_PhoneAfter</th><th>A_Mobile</th></tr>\n";
	foreach($artists as $row)
	{
		echo "<tr>\n";
		echo "<td>" . $row["A_Id"] . "</td>" . 
				"<td>" . $row["A_Title"] . "</td>" . 
				"<td>" . $row["A_Email"] . "</td>" . 
				"<td>" . $row["A_PhoneDay"] . "</td>" . 
				"<td>" . $row["A_PhoneAfter"] . "</td>" . 
				"<td>" . $row["A_Mobile"] . "</td>\n";
		echo "</tr>\n";
	}
	echo "</table>"
?>

<a href='index.html'>Return to Home</a>
</body>
</html>
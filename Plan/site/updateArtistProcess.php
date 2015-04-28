<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Update Artist</title>
</head>
<body>
<?php
	$sql_artist_update = "UPDATE Artist SET" . 
					" A_Title = " . $_POST["A_Title"] . 
					", A_Email = " . $_POST["A_Email"] . 
					", A_PhoneDay = " . $_POST["A_PhoneDay"] . 
					", A_PhoneAfter = " . $_POST["A_PhoneAfter"] . 
					", A_Mobile = " . $_POST["A_Mobile"] .
					" WHERE A_Id = " . $_POST["A_Id"];
	try 
	{

		$dbh->beginTransaction();
		$dbh->exec($sql_artist_update);

		foreach($_POST["C_Id"] as $id)
		{
			$sql_artist_category_update = "INSERT INTO ArtistCategory (A_Id, C_Id) VALUES (" . 
											$_POST["A_Id"] . 
											", " . $id . 
											")";
			$dbh->exec($sql_artist_category_update);
		}

		$dbh->commit();
		echo "<h1>Update Successful!</h1>";
		echo "<table border='1'>\n";
		echo "<tr>";
				echo "<th>A_Title</th><th>A_Email</th><th>A_PhoneDay</th><th>A_PhoneAfter</th><th>A_Mobile</th>";
		echo "</tr>\n";
		echo "<tr>";
			echo "<td>" . $_POST["A_Title"] . "</td>" . "<td>" . $_POST["A_Email"] . "</td>" . "<td>" . $_POST["A_PhoneDay"] . "</td>" . 
					"<td>" . $_POST["A_PhoneAfter"] . "</td>" . "<td>" . $_POST["A_Mobile"] . "</td>";
		echo "</tr>\n";
		echo "</table>\n";

		echo "<h2>Categories:</h2>\n<ul>";
		foreach($_POST["C_Id"] as $category_id)
		{
			$category_name = $dbh->query("SELECT C_Name FROM Category WHERE C_Id = " . $category_id)->fetch(PDO::FETCH_ASSOC)["C_Name"];
			echo "<li>" . $category_name . "</li>";
		}
		echo "</ul>";
	}
	catch(Exception $e)
	{
		$dbh->rollback();
		echo "Failed to update artist: " . $e->getMessage();
	}

?>


<a href='updateArtist.php'>Return to Form</a>
</form>
</body>
</html>
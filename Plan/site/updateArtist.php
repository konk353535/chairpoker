<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Update Artist</title>
</head>
<body>
<h1>Choose an Artist to edit here:</h1>
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
				"<td>" . $row["A_Mobile"] . "</td>\n" . 
				"<td><a href='updateArtistProcess.php?artist_id='" . $row["A_Id"] . "'>Edit</a></td>";
		echo "</tr>\n";
	}
	echo "</table>"
?>
</body>
</html>
<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
	$artists = $dbh->query("SELECT * FROM Artist");

	echo "<table border='1'>\n";
	echo "<tr><th>Artist Id</th><th>Title</th><th>Email</th><th>Phone Daytime</th><th>Phone After Hours</th><th>Mobile</th></tr>\n";
	foreach($artists as $row)
	{
		echo "<tr>\n";
		echo "<td>" . $row["A_Id"] . "</td>" . 
				"<td>" . $row["A_Title"] . "</td>" . 
				"<td>" . $row["A_Email"] . "</td>" . 
				"<td>" . $row["A_PhoneDay"] . "</td>" . 
				"<td>" . $row["A_PhoneAfter"] . "</td>" . 
				"<td>" . $row["A_Mobile"] . "</td>\n" . 
				"<td><a href='deleteArtistProcess.php?artist_id=" . $row["A_Id"] . "'>Delete</a></td>";
		echo "</tr>\n";
	}
	echo "</table>";
	echo "<a href='index.html'>Return to Home</a>";
?>
</body>
</html>
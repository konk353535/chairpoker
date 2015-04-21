<?php
	try 
	{
		$dbh = new PDO('sqlite:../db/TownsvilleMusicCentre.sqlite');
	}
	catch(PDOException $e)
	{
		echo "Failed to load db: " . $e->getMessage();
	}
?>
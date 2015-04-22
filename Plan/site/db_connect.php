<?php
	try 
	{	
		$dbh = new PDO('sqlite:../db/TownsvilleMusicCentre.sqlite');
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
?>
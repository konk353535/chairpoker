<?php
	try 
	{	
		$dbh = new PDO('../db/sqlite:TownsvilleMusicCentre.sqlite');
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
?>
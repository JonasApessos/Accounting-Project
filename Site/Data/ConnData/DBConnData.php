<?php

function InitSession() : void
{
	if(!isset($_SESSION['AccessID'],
	$_SESSION['ServerDNS'],
	$_SESSION['DBName'],
	$_SESSION['DBUsername'],
	$_SESSION['DBPassword'],
	$_SESSION['Login']))
	{
		if($GLOBALS['DEBUG'])
		{
			$_SESSION['Login'] = TRUE;

			$_SESSION['AccessID'] = $GLOBALS['ACCESS']['ADMIN'];

			//The Host server name for establishing the desired connection to the database.
			$_SESSION['ServerDNS'] = "localhost";

			//The database name to connect and execute querys in.
			$_SESSION['DBName'] = "CompanyAccountDB";
			$_SESSION['DBPrefix'] = "AT4553_";

			//The User name and password to the host to be able to access the database.
			$_SESSION['DBUsername'] = "root";
			$_SESSION['DBPassword'] = "";
		}
		else
		{
			$_SESSION['Login'] = FALSE;

			$_SESSION['AccessID'] = $GLOBALS['ACCESS']["GUEST"];

			//The Host server name for establishing the desired connection to the database.
			$_SESSION['ServerDNS'] = "localhost";

			//The database name to connect and execute querys in.
			$_SESSION['DBName'] = "CompanyAccountDB";
			$_SESSION['DBPrefix'] = "AT4553_";

			//The User name and password to the host to be able to access the database.
			$_SESSION['DBUsername'] = "root";
			$_SESSION['DBPassword'] = "";
		}
	}
}
?>

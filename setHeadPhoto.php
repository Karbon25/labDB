<?php
	session_start();
	if(array_key_exists("UId", $_SESSION) and array_key_exists("id", $_GET)){
		settype($_GET['id'], 'integer');
		include("src/config.php");
		$connectDB = mysqli_connect($DBLocation, $DBUser, $DBPassword, $DBTables);
		$query = mysqli_query($connectDB, sprintf('SELECT `DId` FROM `documents` WHERE `DId` = "%s" and `DAuthor`="%s"',$_GET["id"], $_SESSION["UId"]));
		if(mysqli_num_rows($query)){
			mysqli_query($connectDB, sprintf("UPDATE `users` SET `UHead`='%s' WHERE `UId`='%s'", $_GET["id"], $_SESSION["UId"]));
			header(sprintf("Location:profile.php?id=%s", $_SESSION["UId"]));
		}else{
			header("Location:index.php");
		}

	}else{
		header("Location:index.php");
	}


?>
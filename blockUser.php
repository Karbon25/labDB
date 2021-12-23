<?php
	session_start();
	if(array_key_exists("UId", $_SESSION) and array_key_exists("id", $_GET) and array_key_exists("typeAccount", $_SESSION)){
		if($_SESSION['typeAccount'] == "admin"){
		settype($_GET['id'], 'integer');

		include("src/config.php");
		$connectDB = mysqli_connect($DBLocation, $DBUser, $DBPassword, $DBTables);
		$query = mysqli_query($connectDB, sprintf('UPDATE `users` SET `UActive`="0"  WHERE `UId` = "%s"',$_GET["id"]));
		if(mysqli_num_rows($query)){
			header(sprintf("Location:profile.php?id=%s", $_GET["id"]]));
		}else{
			header("Location:index.php");
		}
	}else{
		header("Location:index.php");
	}
}else{
		header("Location:index.php");
	}

?>
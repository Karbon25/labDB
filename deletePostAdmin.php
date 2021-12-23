<?php
	session_start();
	if(array_key_exists("UId", $_SESSION) and array_key_exists("id", $_GET) and array_key_exists("typeAccount", $_SESSION)){
		if($_SESSION['typeAccount'] == "admin"){
		settype($_GET['id'], 'integer');

		include("src/config.php");
		$connectDB = mysqli_connect($DBLocation, $DBUser, $DBPassword, $DBTables);
		$query = mysqli_query($connectDB, sprintf('SELECT `DId` FROM `documents` WHERE `DId` = "%s"',$_GET["id"]));
		if(mysqli_num_rows($query)){
			mysqli_query($connectDB, sprintf("DELETE FROM `documents` WHERE `DId` = '%s'", $_GET["id"]));
			echo("<script>history.back()</script>");
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

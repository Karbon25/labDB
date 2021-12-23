<?php
	session_start();
	include("src/config.php");
	$connectDB = mysqli_connect($DBLocation, $DBUser, $DBPassword, $DBTables);
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?echo $ConfigSiteTitle;?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
		<style type="text/css">

			#loginForm{
				position: absolute;
				top: 30%;
				width: 100%;
				
			}
		</style>
	</head>
	<body>
		<div class="container" style="position: relative; height: 50vh">
			<div class="row" id="loginForm">
				<div class="col-md-4 col-12"></div>
				<div class="col-md-4 col-12">
					<form action="" method="post">
						<center><h2>Авторизація адміністратора</h2></center>
					  <div class="mb-3">
					    <label for="Login" class="form-label">Логин</label>
					    <input type="text" class="form-control" id="Login" required name="login">
					    
					  </div>
					  <div class="mb-3">
					    <label for="Password" class="form-label">Пароль</label>
					    <input type="password" class="form-control" id="Password" required name="password">
					  </div>
					  <center><button type="submit" class="btn btn-primary" name="submitLogin">Авторизуватися</button></center>
					</form>
				</div>
				<div class="col-md-4 col-12"></div>
			</div>
		</div>
	</body>
</html>

<?php
	if(isset($_POST["submitLogin"])){
		if(array_key_exists("login", $_POST) and array_key_exists("password", $_POST)){
			$_POST['login'] = mysqli_real_escape_string($connectDB, $_POST['login']);
			$_POST['password'] = mysqli_real_escape_string($connectDB, $_POST['password']);
			$query = mysqli_query($connectDB, sprintf('SELECT `AId` FROM `admins` WHERE `ALogin` = "%s" and `APassword` = md5("%s")', $_POST["login"], $_POST["password"]));
			if(mysqli_num_rows($query)){
				$row = mysqli_fetch_assoc($query);
				
					$_SESSION["UId"] = $row["AId"];
					$_SESSION["ULogin"] = $_POST["login"];
					// $_SESSION["UEmail"] = $_POST["email"];
					$_SESSION["typeAccount"] = "admin";
					mysqli_close($connectDB);
					header("Location:index.php");
	

			}else{
				printf('<div class="alert alert-danger" role="alert">
				  Логин чи пароль невірні
				</div>');

			}

		}else{
			printf('<div class="alert alert-danger" role="alert">
			  Авторизаційні дані не введені!
			</div>');
		}

	}

	mysqli_close($connectDB);

?>
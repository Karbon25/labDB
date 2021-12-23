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
						<center><h2>Реєстрація</h2></center>
					  <div class="mb-3">
					    <label for="Email" class="form-label">Елкетронна адреса</label>
					    <input type="email" class="form-control" id="Email" required name="email">
					    
					  </div>
					  <div class="mb-3">
					    <label for="Login" class="form-label">Логин</label>
					    <input type="text" class="form-control" id="Login" required name="login">
					  </div>

					  <div class="mb-3">
					    <label for="Password" class="form-label">Пароль</label>
					    <input type="password" class="form-control" id="Password" required name="password">
					  </div>
					  <div class="mb-3">
					    <label for="Name" class="form-label">Ім'я</label>
					    <input type="text" class="form-control" id="Name" required name="name">
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
		if(array_key_exists("login", $_POST) and array_key_exists("email", $_POST)){
			$_POST['email'] = mysqli_real_escape_string($connectDB, $_POST['email']);
			$_POST['login'] = mysqli_real_escape_string($connectDB, $_POST['login']);
			$_POST['password'] = mysqli_real_escape_string($connectDB, $_POST['password']);
			$_POST['name'] = mysqli_real_escape_string($connectDB, $_POST['name']);
			$query = mysqli_query($connectDB, sprintf('SELECT `UId`, `ULogin`, `UActive` FROM `users` WHERE `UEmail` = "%s" or `ULogin` = "%s"', $_POST["email"], $_POST["login"]));
			if(!mysqli_num_rows($query)){
				mysqli_query($connectDB, sprintf('INSERT INTO `users`(`UFullName`, `UEmail`, `ULogin`, `UPassword`, `UActive`, `UAbout`, `UHead`) VALUES ("%s", "%s", "%s", MD5("%s"), 1, "", NULL)', $_POST['name'], $_POST['email'], $_POST["login"], $_POST['password']));
				header("Location:login.php");

			}else{
				printf('<div class="alert alert-danger" role="alert">
				  Електронна адреса чи логин вже існують в системі
				</div>');

			}

		}else{
			printf('<div class="alert alert-danger" role="alert">
			 Дані не введені!
			</div>');
		}

	}

	mysqli_close($connectDB);

?>
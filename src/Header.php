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
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#">PhotoLab</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	        <li class="nav-item">
	          <a class="nav-link active" aria-current="page" href="index.php">Головна</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="category.php">Категорії</a>
	        </li>
	        <!-- Для авторизований корисувачів -->
	        <?php
	        	if(array_key_exists("typeAccount", $_SESSION)){
	        		if($_SESSION["typeAccount"] == "user"){
	        ?>
	        <li class="nav-item">
	          <a class="nav-link" href="profile.php?id=<?echo $_SESSION["UId"]?>">Мій кабінет</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="addPost.php">Опублікувати фото</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="exit.php">Вийти</a>
	        </li>
	        <?php

	    		}
	    		if($_SESSION["typeAccount"] == "admin"){
	    	?>
	        <!-- Admins -->
	        <li class="nav-item">
	          <a class="nav-link" href="exit.php">Вийти</a>
	        </li>
	        <?php
	        	}
	        }else{
	        ?>
	        <!-- Для неавторизованих -->
	        <li class="nav-item">
	          <a class="nav-link" href="login.php">Увійти</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="registration.php">Зареєструватися</a>
	        </li>
	        <?}?>
	      </ul>
	      <form class="d-flex" action="search.php" method="get">
	        <input class="form-control me-2" type="search" name="Name" placeholder="Найти користувача" aria-label="Search">
	        <button class="btn btn-outline-success" type="submit">Search</button>
	      </form>
	    </div>
	  </div>
	</nav>
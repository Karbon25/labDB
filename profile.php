<?php
	include("src/Header.php");
?>
<?php
if(isset($_GET["id"])){	
	settype($_GET['id'], 'integer');
	$query = mysqli_query($connectDB, sprintf("SELECT `UId`, `UFullName`, `UEmail`, `ULogin`, `UAbout`, `UHead` FROM `users` WHERE `UId` = '%s'", $_GET["id"]));
	$query_photo = mysqli_query($connectDB, sprintf("SELECT `documents`.`DId` as `DId`, `documents`.`DFileName` as `DFileName` FROM `documents` INNER JOIN `users` ON `users`.`UHead` = `documents`.`DId` WHERE `users`.`UId` = '%s'", $_GET["id"]));
	$textSrcIng = '<img src="src/definePhotoProfile.jpg" class="img-fluid">';
	if(mysqli_num_rows($query_photo)){
		$photoRow = mysqli_fetch_assoc($query_photo);
		$textSrcIng = sprintf('<img src="photo/%s_%s" class="img-fluid">', $photoRow["DId"],$photoRow["DFileName"]);
	}
	if(!mysqli_num_rows($query)){
		header("Location:index.php");
	}else{
		$row = mysqli_fetch_assoc($query);
		$post = mysqli_query($connectDB, sprintf("SELECT `DId`, `DTitle`, `DFileName` FROM `documents` WHERE `DAuthor` = '%s' ORDER BY `DId` DESC", $_GET["id"]));
		?>
		<div class="container">
			
			<div class="row" style="margin-top: 50px">
				<div class="col-md-4 col-12">

					<center><h3>Автор</h3></center>
					<?php
					if(array_key_exists("typeAccount", $_SESSION)){
						if($_SESSION['typeAccount'] == "admin"){


					?>
						<a href="blockUser.php?id=<?echo($_GET['id'])?>" class="btn btn-danger">Заблокувати користувача</a>
					<?}}?>
					<br>
					<?echo($textSrcIng)?>
					<br>
		        	<center><h5 class="card-title"><?echo $row["UFullName"];?></h5><p>@<?echo $row["ULogin"];?></p></a></center>

		        
		      	</div>
				<div class="col-md-8 col-12">
					<center><h3>Публікації</h3></center>
					<br>
					<div class="row row-cols-1 row-cols-md-2 g-4">
						<?php
							if(mysqli_num_rows($post)){
								while($rowPost = mysqli_fetch_assoc($post)){
									$buttonText = "";
									if(array_key_exists("UId", $_SESSION) and array_key_exists("typeAccount", $_SESSION)){
										if($_SESSION["UId"] == $_GET["id"]){
											$buttonText = sprintf('<a href="deletePost.php?id=%s" class="btn btn-danger">Видалити пост</a><a href="setHeadPhoto.php?id=%s" class="btn btn-success" style="margin-left:10px;">Встановити як фото профіля</a>', $rowPost["DId"], $rowPost["DId"]);
										}
										if($_SESSION["typeAccount"] == "admin"){
											$buttonText = sprintf('<a href="deletePostAdmin.php?id=%s" class="btn btn-danger">Видалити пост</a>', $rowPost["DId"], $rowPost["DId"]);

										}
									}
									printf('
										<div class="col">
									     <div class="card">
									      <img src="photo/%s_%s" class="card-img-top" alt="%s">
									      <div class="card-body" style="text-align: center;">
									        <h5 class="card-title"><a href="post.php?id=%s" style="text-decoration: none; color: black">%s</a></h5>
									        %s
									      </div>
									    </div>
									  </div>', $rowPost["DId"],$rowPost["DFileName"],$rowPost["DTitle"],$rowPost["DId"],$rowPost["DTitle"], $buttonText);
			
								}
							}

						?>

					</div>
				</div>
			</div>
		</div>




		<?php	

	}

}else{
	header("Location:index.php");
}



?>







<?php
	include("src/Footer.php");
?>
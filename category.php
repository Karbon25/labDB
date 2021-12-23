<?php
	include("src/Header.php");
?>
<?php
if(!array_key_exists("category", $_GET)){
?>
<div class="container" style="margin-top: 30px;">
	<h1 style="margin-bottom: 20px;"><center>Категорії</center></h1>
	<div class="row row-cols-1 row-cols-md-1 g-4">
		
		<?php
		$query = mysqli_query($connectDB, "SELECT `CId`, `CTitle`, `CAbout`, IFNULL(`documents`.`DId`, '') AS `DId`, IFNULL(`documents`.`DFileName`, 'default.jpg') AS `DFileName` FROM `category` LEFT JOIN `documents` ON `category`.`CPhoto` = `documents`.`DId`");
		if(mysqli_num_rows($query)){
			while($row = mysqli_fetch_assoc($query)){
				printf('
					<div class="col">
						<div class="card">
						  <div class="row">
						    <div class="col-md-4">
						      <img src="photo/%s_%s" class="img-fluid rounded-start">
						    </div>
						    <div class="col-md-8">
						      <div class="card-body">
						        <h5 class="card-title">%s</h5>
						        <p class="card-text">%s</p>
						        <a href="category.php?category=%s" class="btn btn-primary">Перейти</a>
						      </div>
						    </div>
						  </div>
						</div>
					</div>
				 ', $row["DId"], $row["DFileName"], $row["CTitle"], $row["CAbout"], $row["CId"]);
			}
		}else{

			printf('
				<center><h1>Категорії не додані до бази</h1></center>
			 ');
		}
	
?>
	</div>
</div>

<?php
}else{
	settype($_GET['category'], 'integer');
?>



<center style="margin-top: 25px;font-size: 3em"><h1>Допити в категорії</h1></center>
<div class="container" style="margin-top: 25px;">
	<div class="row row-cols-1 row-cols-md-2 g-4">
		<?php
		if(!array_key_exists("page", $_GET)){
		$query = mysqli_query($connectDB, sprintf("SELECT `DId`, `DTitle`, `DFileName` FROM `documents` WHERE `DCategory` = '%d' ORDER BY `DId` DESC LIMIT %d", $_GET["category"], $ConfigCountPhoto));
	}else{
		settype($_GET['page'], 'integer');
		$query = mysqli_query($connectDB, sprintf("SELECT `DId`, `DTitle`, `DFileName` FROM `documents` WHERE `DCategory` = '%d' ORDER BY `DId` DESC LIMIT %d %d", $_GET["category"], $_GET["page"]*$ConfigCountPhoto, $ConfigCountPhoto));

	}
		if(mysqli_num_rows($query)){
			while ($row = mysqli_fetch_assoc($query)) {
				printf('
					<div class="col">
				     <div class="card">
				      <img src="photo/%s_%s" class="card-img-top" alt="%s">
				      <div class="card-body" style="text-align: center;">
				        <h5 class="card-title"><a href="post.php?id=%s" style="text-decoration: none; color: black">%s</a></h5>
				      </div>
				    </div>
				  </div>', $row["DId"],$row["DFileName"],$row["DTitle"],$row["DId"],$row["DTitle"]);
			}
		}else{
	?>

	<center style="margin-top: 25px;font-size: 3em"><h1>Допитів ще не додано</h1></center>

	<?php
		}
	?>
	</div>
</div>
<div class="d-grid gap-2 col-6 mx-auto">
<?php
	if(!array_key_exists("page", $_GET)){
		$page = 1;
	}
	else{
		$page = $_GET["page"];
		if($page > 1){
			printf('
			  <a class="btn btn-primary" href="index.php?page=%s">Попередня сторінка</a>
			 ', $page-1);
		}
	}
	settype($_GET['category'], 'integer');
	$query = mysqli_query($connectDB, sprintf("SELECT COUNT(`DId`) AS `NumPost` FROM `documents` WHERE `DCategory` = '%d'", $_GET["category"]));
	$row = mysqli_fetch_assoc($query);
	if($page*$ConfigCountPhoto < $row["NumPost"]){
		printf('
		  <a class="btn btn-primary" href="index.php?page=%s">Наступна сторінка</a>
		 ', $page+1);


	}

?>
</div>




<?php
}
?>




<?php
	include("src/Footer.php");
?>
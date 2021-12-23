<?php
	include("src/Header.php");
?>

<div style="width: 100%; position: relative;">
	<img src="src/headImage.jpg" width="100%">
	<div style="position: absolute;top: 50%;width: 100%;text-align: center;color: white;font-family: cursive;">
		<h1 style="font-size: 4em">PhotoLab</h1>
		<h3>Проект створений для лабораторних робіт з БД</h3>
	</div>
</div>

<center style="margin-top: 25px;font-size: 3em"><h1>Останні дописи</h1></center>
<div class="container" style="margin-top: 25px;">
	<div class="row row-cols-1 row-cols-md-2 g-4">
		<?php
		if(!array_key_exists("page", $_GET)){
		$query = mysqli_query($connectDB, sprintf("SELECT `DId`, `DTitle`, `DFileName` FROM `documents` ORDER BY `DId` DESC LIMIT %d", $ConfigCountPhoto));
	}else{
		settype($_GET['page'], 'integer');
		$query = mysqli_query($connectDB, sprintf("SELECT `DId`, `DTitle`, `DFileName` FROM `documents` ORDER BY `DId` DESC LIMIT %d %d", $_GET["page"]*$ConfigCountPhoto, $ConfigCountPhoto));

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
		settype($_GET['id'], 'page');
		$page = $_GET["page"];
		if($page > 1){
			printf('
			  <a class="btn btn-primary" href="index.php?page=%s">Попередня сторінка</a>
			 ', $page-1);
		}
	}
	$query = mysqli_query($connectDB, "SELECT COUNT(`DId`) AS `NumPost` FROM `documents`");
	$row = mysqli_fetch_assoc($query);
	if($page*$ConfigCountPhoto < $row["NumPost"]){
		printf('
		  <a class="btn btn-primary" href="index.php?page=%s">Наступна сторінка</a>
		 ', $page+1);


	}

?>
</div>


<?php
	include("src/Footer.php");
?>
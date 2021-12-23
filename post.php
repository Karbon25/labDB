<?php
	include("src/Header.php");
	function printRating($rating){
		$res = '<div class="rating-result">';

		for($i=0; $i < $rating; $i+=1){
			$res = $res.'<span class="active"></span>';
		}
		for($i=5-$rating; $i > 0; $i-=1){
			$res = $res.'<span></span>';
		}
		$res = $res.'</div>';
		return($res);
	}
?>

<?php
if(!array_key_exists("id",$_GET)){
	echo "<script type='text/javascript'>history.back()</script>";
}else{
settype($_GET['id'], 'integer');

	$query = mysqli_query($connectDB, sprintf('SELECT `DId`, `DTitle`, `DFileName`, `DDate`, `DAuthor`, `category`.`CTitle` as `CTitle`, IFNULL(ROUND(AVG(`comments`.`CRating`)), 5) AS `DRating`, `users`.`UFullName` as `UFullName`, `users`.`ULogin` AS `ULogin`,`DSave` FROM `documents` LEFT JOIN `comments` ON `comments`.`CPhoto` = `documents`.`DId` INNER JOIN `users` ON `users`.`UId` = `documents`.`DAuthor` LEFT JOIN `category` ON `category`.`CId` = `documents`.`DCategory` WHERE `DId` = "%s"',$_GET["id"]));
	if(!mysqli_num_rows($query)){
		echo "<script type='text/javascript'>history.back()</script>";
	}else{
		$row = mysqli_fetch_assoc($query);
		$query = mysqli_query($connectDB, sprintf('SELECT `CId`, `users`.`UFullName`as `UFullName`, `users`.`UId` as `UId`, `users`.`ULogin` AS `ULogin`, `CRating`, `CText`, `CDate` FROM `comments` INNER JOIN `users` ON `users`.`UId` = `comments`.`CUser` WHERE `CPhoto` = "%s" ORDER BY `CId` DESC', $_GET["id"]));
	


?>
	<style type="text/css">
		.rating-result {
			width: 265px;
			
		}
		.rating-result span {
			padding: 0;
			font-size: 32px;
			margin: 0 3px;
			line-height: 1;
			color: lightgrey;
			text-shadow: 1px 1px #bbb;
		}
		.rating-result > span:before {
			content: '★';
		}
		.rating-result > span.active {
			color: gold;
			text-shadow: 1px 1px #c60;
		}



	</style>
	<div class="container" style="margin-top: 40px;">
		<div class="card" style="width: 100%">
		  <div class="row g-0">
		    <div class="col-md-4">
		      

		      <div class="card-body">
		        <center>
		        	<h5 class="card-title"><?echo $row["DTitle"];?></h5>
		        	<p class="card-text">Категорія <?echo $row["CTitle"];?></p>
		        	<p class="card-text"><small class="text-muted">Last updated <?echo $row["DDate"];?></small></p>
		        	<p>
	        			<?php
	        				echo printRating($row["DRating"]);
	        				
	        			?>
					</p>
					<a class="btn btn-outline-success" download href="photo/<?printf('%s_%s',$row["DId"], $row["DFileName"]);?>">Завантажити фото</a>
					<br>
					<br>
		        </center>
		      	<center><h3>Автор</h3></center>
		        <center><a href="profile.php?id=<?echo $row["DAuthor"];?>"><h5 class="card-title"><?echo $row["UFullName"];?></h5><p>@<?echo $row["ULogin"];?></p></a></center>
		        
		      </div>
		    </div>
		    <div class="col-md-8 align-self-center">
		    		
		    			<img src="photo/<?printf('%s_%s',$row["DId"], $row["DFileName"]);?>" class="img-fluid rounded-start" alt="<?echo $row["DTitle"];?>">

		    </div>
		  </div>
		</div>
		<br>
		<center><h1>Коментарі</h1></center>
		<br>
		<?php
			if(array_key_exists("typeAccount",$_SESSION)){
				echo '<div class="d-grid gap-2"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#ModalAddComment">Додати коментар</button></div>';
			}
			if(!mysqli_num_rows($query)){
				echo '<center style="margin-top: 25px;font-size: 3em"><h1>Допитів ще не додано</h1></center>';
			}else{
				while($row = mysqli_fetch_assoc($query)){
					printf('

						<div class="card" style="margin-bottom:20px;">
						  <div class="card-header">
						    <a href="profile.php?id=%s">%s(%s)</a>
						  </div>
						  <div class="card-body">
						    <blockquote class="blockquote mb-0">
						      <p>%s</p>
						      <p>%s</p>
						      <footer class="blockquote-footer">Date publication %s</footer>
						    </blockquote>
						  </div>
						</div>


					 ', $row["UId"],$row["UFullName"],$row["ULogin"],$row["CText"],printRating($row["CRating"]),$row["CDate"]);
				}
			}
		?>
	</div>


<?php
}
}
?>

<?php
	if(array_key_exists("typeAccount",$_SESSION)){
		if($_SESSION["typeAccount"] == "user"){

?>
<style type="text/css">
	.rating-area {
	overflow: hidden;
	width: 265px;
	margin: 0 auto;
}
.rating-area:not(:checked) > input {
	display: none;
}
.rating-area:not(:checked) > label {
	float: right;
	width: 42px;
	padding: 0;
	cursor: pointer;
	font-size: 32px;
	line-height: 32px;
	color: lightgrey;
	text-shadow: 1px 1px #bbb;
}
.rating-area:not(:checked) > label:before {
	content: '★';
}
.rating-area > input:checked ~ label {
	color: gold;
	text-shadow: 1px 1px #c60;
}
.rating-area:not(:checked) > label:hover,
.rating-area:not(:checked) > label:hover ~ label {
	color: gold;
}
.rating-area > input:checked + label:hover,
.rating-area > input:checked + label:hover ~ label,
.rating-area > input:checked ~ label:hover,
.rating-area > input:checked ~ label:hover ~ label,
.rating-area > label:hover ~ input:checked ~ label {
	color: gold;
	text-shadow: 1px 1px goldenrod;
}
.rate-area > label:active {
	position: relative;
}

</style>
<div class="modal fade" id="ModalAddComment" tabindex="-1" aria-labelledby="ModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel1">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<form action="" method="post">
      		<input type="hidden" name="DId" required value="<?echo $_GET['id'];?>">
      		<div class="form-floating">
				<textarea class="form-control" placeholder="" id="Textarea" style="height: 100px" name="TextComment" required></textarea>
				<label for="Textarea">Коментар</label>
			</div>
			<label class="form-label">Оцінка</label>
			  <div class="rating-area">
			  	
				<input type="radio" id="star-5" name="rating" value="5">
				<label for="star-5" title="Оценка «5»"></label>	
				<input type="radio" id="star-4" name="rating" value="4">
				<label for="star-4" title="Оценка «4»"></label>    
				<input type="radio" id="star-3" name="rating" value="3">
				<label for="star-3" title="Оценка «3»"></label>  
				<input type="radio" id="star-2" name="rating" value="2">
				<label for="star-2" title="Оценка «2»"></label>    
				<input type="radio" id="star-1" name="rating" value="1">
				<label for="star-1" title="Оценка «1»"></label>
			</div>
		  <button type="submit" class="btn btn-primary" name="addComment">Додати</button>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
	if(isset($_POST["addComment"])){
		$_POST["TextComment"] = mysqli_real_escape_string($connectDB, $_POST["TextComment"]);
		
		settype($_POST['DId'], 'integer');
		settype($_POST['rating'], 'float');
		mysqli_query($connectDB, sprintf("INSERT INTO `comments`(`CUser`, `CPhoto`, `CRating`, `CText`, `CDate`) VALUES ('%s','%s','%s','%s',NOW());",$_SESSION["UId"],$_POST["DId"],$_POST["rating"], str_replace("'", '"', $_POST["TextComment"])));
		@header("Location:post.php?id=".$_POST["DId"]);
	}

	}
}

?>




<?php


	include("src/Footer.php");
?>
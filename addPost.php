<?php

	include("src/Header.php");
	if(!array_key_exists("typeAccount",$_SESSION)){
		header("Location:index.php");
	}else{
		if($_SESSION["typeAccount"] != "user"){
			header("Location:index.php");
		}else{


?>

<div class="container">
	<center><h1>Опублікувати фото</h1></center>
	<div class="row justify-content-center">
		<form class="col-md-8 col-12" action="" method="post" enctype="multipart/form-data">
			<div class="mb-3">
				<label for="formText" class="form-label">Назва статі</label>
				<input type="text" class="form-control" id="formText" required name="Title">

			</div>
			<div class="mb-3">
				<label for="formCategory" class="form-label">Категорія</label>
				<select class="form-select" id="formCategory" required name="idCategory">
					<option disabled selected value></option>
					<?php
						$query = mysqli_query($connectDB, "SELECT `CId`, `CTitle` FROM `category`");
						while($row = mysqli_fetch_assoc($query)){
							printf('<option value="%s">%s</option>', $row["CId"], $row["CTitle"]);
						}
					?>
				</select>
			</div>
			<div class="mb-3">
			  <label for="formFile" class="form-label">Виберіть файл</label>
			  <input class="form-control" type="file" id="formFile" name="photoFile" accept="image/*" required>
			</div>
		  <center><button type="submit" class="btn btn-primary" name="addPhoto">Submit</button></center>
		</form>
	</div>
</div>






<?php

	if(isset($_POST["addPhoto"])){
		if(is_uploaded_file($_FILES['photoFile']['tmp_name'])){
			$fileName = str_replace('"', "_", $_FILES['photoFile']['name']);
			$_POST['Title'] = mysqli_real_escape_string($connectDB, $_POST['Title']);
			$title = str_replace("'", '"', $_POST["Title"]);
			$_POST['idCategory'] = mysqli_real_escape_string($connectDB, $_POST['idCategory']);
			$query = mysqli_query($connectDB, sprintf("INSERT INTO `documents`(`DTitle`, `DFileName`, `DDate`, `DAuthor`, `DCategory`, `DSave`) VALUES ('%s','%s',NOW(),'%s','%s',0)", $title, $fileName, $_SESSION["UId"], $_POST["idCategory"]));
			$idDocument = mysqli_insert_id($connectDB);
			if($idDocument){
				move_uploaded_file($_FILES['photoFile']['tmp_name'], sprintf("photo/%s_%s", $idDocument, $fileName));
				header("Location:post.php?id=".$idDocument);
			}else{
				?>
				<script type="text/javascript">alert("Помилка при публікації");</script>
				<?php	
				header("Location:addPost.php");
			}

		}else{
			?>
			<script type="text/javascript">alert("Файл не завантажено");</script>
			<?php
			header("Location:addPost.php");
		}
	}

		} 
	}
	include("src/Footer.php");
?>
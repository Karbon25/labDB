<?php
	include("src/Header.php");
?>
<?php
if(isset($_GET["Name"])){
	$_GET["Name"] = mysqli_real_escape_string($connectDB, $_GET["Name"]);	
	$query = mysqli_query($connectDB, "SELECT `UId`, `UFullName`, `ULogin` FROM `users` WHERE `UFullName` LIKE '".$_GET['Name']."' or `ULogin` LIKE '". $_GET["Name"]."'");
	if(!mysqli_num_rows($query)){
		?>
		<br>
		<center><h1>Користувачів не знайдено</h1></center>
		<?php
	}else{
		?>
		<br>
		<div class="container">
			<div class="row">
				<?php
					while($row = mysqli_fetch_assoc($query)){
						printf('
								<div class="col-sm-4">
								    <div class="card">
								      <div class="card-body">
								        <h5 class="card-title">%s(@%s)</h5>
								        <a href="profile.php?id=%s" class="btn btn-primary">Відкрити сторінку</a>
								      </div>
								    </div>
								  </div>



							
							', $row["UFullName"], $row["ULogin"], $row["UId"]);



					}
				}
			}
			?>
		</div>
	</div>




<?php
	include("src/Footer.php");
?>
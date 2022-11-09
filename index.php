<?php
session_start();
include('connection.php');
include('AutoID_Functions.php');
// include('head.php');

// if (!isset($_SESSION['CustomerID'])) {
// 	echo "<script>window.alert('Please Login first to continue.')</script>";
// 	echo "<script>window.location='Customer_Login.php'</script>";
// }
if (isset($_POST['btnSearch'])) {
	$rdoSearchType = $_POST['rdoSearchType'];

	if ($rdoSearchType == 1) {
		$cboRestaurantID = $_POST['cboRestaurantID'];

		$query = "SELECT m.*,r.RestaurantName FROM menu m, restaurants r WHERE r.RestaurantID=m.RestaurantID AND r.RestaurantID='$cboRestaurantID'";
		$ret = mysqli_query($connection, $query);
		$count = mysqli_num_rows($ret);
	} elseif ($rdoSearchType == 2) {
		$cbomenutypeID = $_POST['cbomenutypeID'];

		$query = "SELECT m.*, mt.*, r.RestaurantName FROM menu m, menutype mt, restaurants r WHERE m.MenuTypeID=mt.MenuTypeID AND m.RestaurantID=r.RestaurantID AND mt.MenuTypeID='$cbomenutypeID'";
		$ret = mysqli_query($connection, $query);
		$count = mysqli_num_rows($ret);
	} elseif ($rdoSearchType == 3) {
		$cbolocation = $_POST['cbolocation'];

		$query = "SELECT m.*,r.RestaurantName,r.Location FROM menu m, restaurants r	WHERE m.RestaurantID=r.RestaurantID	AND r.Location='$cbolocation'";
		$ret = mysqli_query($connection, $query);
		$count = mysqli_num_rows($ret);
	} else {
		$query = "SELECT m.*,r.RestaurantName,r.Location,mt.*
					FROM menu m, restaurants r, menutype mt 
					WHERE m.RestaurantID=r.RestaurantID
					AND m.MenuTypeID=mt.MenuTypeID";
		$ret = mysqli_query($connection, $query);
		$count = mysqli_num_rows($ret);
	}
} elseif (isset($_POST['btnShowAll'])) {
	$query = "SELECT m.*,r.RestaurantName,r.Location,mt.*
					FROM menu m, restaurants r, menutype mt 
					WHERE m.RestaurantID=r.RestaurantID
					AND m.MenuTypeID=mt.MenuTypeID";
	$ret = mysqli_query($connection, $query);
	$count = mysqli_num_rows($ret);
} else {
	$query = "SELECT m.*,r.RestaurantName,r.Location,mt.*
					FROM menu m, restaurants r, menutype mt 
					WHERE m.RestaurantID=r.RestaurantID
					AND m.MenuTypeID=mt.MenuTypeID";
	$ret = mysqli_query($connection, $query);
	$count = mysqli_num_rows($ret);
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Menu Display</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<style>
		.menu-name {
			font-size: 25px;
			font-weight: bold;
		}
		.menu-button {
			color: #f4511e !important;
			font-weight: bold !important;
		}
	</style>
</head>

<body>
	<?php
	include('header.php');
	?>
	<div class="container-fluid bg-info p-0">
		<img class="w-100 img-fluid" src="image/cuisine-banner.png">
	</div>
	<div class="container p-5">
		<form action="index.php" method='POST'>
			<div class="menus mb-5">
				<div class="card">
					<div class="card-body">
						<h3 class="text-center">Search</h3>
						<div class="row p-3">
							<div class="col-4">
								<input class="mb-2" type="radio" name="rdoSearchType" value="1" checked /> By restaurant name <br />
								<select class="form-control" class="form-control" name="cboRestaurantID">
									<option>Choose Restaurants</option>
									<?php
									$restaurants_Query = "SELECT * FROM restaurants";
									$restaurants_ret = mysqli_query($connection, $restaurants_Query);
									$restaurants_count = mysqli_num_rows($restaurants_ret);

									for ($i = 0; $i < $restaurants_count; $i++) {
										$restaurants_arr = mysqli_fetch_array($restaurants_ret);
										$RestaurantID = $restaurants_arr['RestaurantID'];
										$RestaurantName = $restaurants_arr['RestaurantName'];

										echo "<option value='$RestaurantID'>$RestaurantName</option>";
									}
									?>
								</select>
							</div>
							<div class="col-4">
								<input class="mb-2" type="radio" name="rdoSearchType" value="2" /> By menu type <br />
								<select class="form-control" name="cbomenutypeID">
									<option>Choose MenuTypeName</option>
									<?php
									$menutype_Query = "SELECT * FROM menutype";
									$menutype_ret = mysqli_query($connection, $menutype_Query);
									$menutype_count = mysqli_num_rows($menutype_ret);

									for ($i = 0; $i < $menutype_count; $i++) {
										$menutype_arr = mysqli_fetch_array($menutype_ret);
										$MenuTypeID = $menutype_arr['MenuTypeID'];
										$MenuTypeName = $menutype_arr['MenuTypeName'];

										echo "<option value='$MenuTypeID'>$MenuTypeName</option>";
									}
									?>
								</select>
							</div>
							<div class="col-4">
								<input class="mb-2" type="radio" name="rdoSearchType" value="3" /> By location <br />
								<select class="form-control" name="cbolocation">
									<option>Choose Location</option>
									<?php
									$Location_Query = "SELECT DISTINCT Location FROM restaurants";
									$Location_ret = mysqli_query($connection, $Location_Query);
									$Location_count = mysqli_num_rows($Location_ret);

									for ($i = 0; $i < $Location_count; $i++) {
										$Location_arr = mysqli_fetch_array($Location_ret);
										$Location = $Location_arr['Location'];

										echo "<option value='$Location'>$Location</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="row pr-3">
							<div class="col-4 offset-8 d-flex justify-content-end">
								<input class="btn menu-button mr-2" type="submit" name="btnSearch" value="Search" />
								<input class="btn menu-button mr-2" type="reset" value="Clear" />
								<input class="btn menu-button" type="submit" name="btnShowAll" value="Show all">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="menu-items">
				<h3 class="text-center">Menu Items</h3>
				<div class="row mt-4">
					<?php
					// for ($i = 0; $i < $count; $i++) {
						// $query = "SELECT * FROM menu
						// 	 ORDER BY MenuID DESC";
						// $ret = mysqli_query($connection, $query);
						// $new = mysqli_num_rows($ret);
						for ($i = 0; $i < $count; $i++) {
							$row = mysqli_fetch_array($ret);
							$image1 = $row['Image'];
							$MenuName = $row['MenuName'];
							$price = $row['Price'];
							$MenuID = $row['MenuID'];
							$RestName = $row['RestaurantName'];

							echo "<div class='col-3 mb-4'>";
							echo "<div class='card'>";
							echo "<img src='$image1' class='img-fluid'>";
							echo "<div class='card-body'>";
							echo "<p class='menu-name'><i class='fas fa-utensils'></i> $MenuName</p>";
							echo "<p class='rest-name'><i class='fas fa-home fa-lg'></i> $RestName</p>";
							echo "<p class='menu-price'><i class='fas fa-dollar-sign fa-lg'></i> $price MMK</p>";
							echo "<a class='btn menu-button' href='Menu_Detail.php?MenuID=$MenuID'>Detail</a>";
							echo "</div>";
							echo "</div>";
							echo "</div>";
						}
					// }
					?>
				</div>
			</div>
		</form>
	</div>
	<?php
	include('footer.php');
	?>
</body>

</html>
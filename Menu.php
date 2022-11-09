<?php
session_start();
include('connection.php');

if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Staff_Login.php'
		</script>";
}

$name = "";
$typeID = "";
$restaurantID = "";
$description = "";
$promotion = "";
$image = "";
$price = "";

if (isset($_GET['MenuID'])) {
	$id = $_GET['MenuID'];

	$query = "SELECT * FROM menu WHERE MenuID='$id'";
	$ret = mysqli_query($connection, $query);
	$data = mysqli_fetch_array($ret);

	$name = $data['MenuName'];
	$typeID = $data['MenuTypeID'];
	$description = $data['ShortDescription'];
	$promotion = $data['Promotion'];
	$image = $data['Image'];
	$price = $data['Price'];
	$restaurantID = $data['RestaurantID'];
}

if (isset($_POST['btnCreate'])) {
	$txtMenuName = $_POST['txtMenuName'];
	$txtprice = $_POST['txtprice'];
	$txtMenuTypeID = $_POST['txtMenuTypeID'];
	$txtRestaurantID = $_POST['txtRestaurantID'];
	$txtShortDescription = $_POST['txtShortDescription'];
	$txtpromotion = $_POST['txtpromotion'];
	$image1 = $_FILES['menuimage']['name'];
	$folder = 'image/';


	if ($image1) {
		$filename = $folder . "_" . $image1;
		$copied = copy($_FILES['menuimage']['tmp_name'], $filename);

		if (!$copied) {
			exit("Problem occured.Cannot Upload Event Image.");
		}
	}

	$insert_data = "INSERT INTO menu
				  (MenuName,Price,MenuTypeID,ShortDescription,Promotion,Image, RestaurantID)
				  VALUES
				  ('$txtMenuName','$txtprice','$txtMenuTypeID','$txtShortDescription','$txtpromotion','$filename', '$txtRestaurantID')
				  ";
	$result = mysqli_query($connection,$insert_data);

	if ($result) //True
	{
		echo "<script>window.alert('New Menu Successfully Created!')</script>";
		echo "<script>window.location='Menu.php'</script>";
	} else {
		echo "<p>Something went wrong in Menu Entry" . mysqli_error($connection) . "</p>";
	}
}

if (isset($_POST['btnUpdate'])) {
	$id = $_POST['txtMenuID'];
	$txtMenuName = $_POST['txtMenuName'];
	$txtprice = $_POST['txtprice'];
	$txtMenuTypeID = $_POST['txtMenuTypeID'];
	$txtShortDescription = $_POST['txtShortDescription'];
	$txtpromotion = $_POST['txtpromotion'];
	$txtRestaurantID = $_POST['txtRestaurantID'];
	$txtImage = $_POST['txtImage'];
	$image1 = $_FILES['menuimage']['name'];
	$folder = 'image/';

	if ($image1) {
		$filename = $folder . "_" . $image1;
		$copied = copy($_FILES['menuimage']['tmp_name'], $filename);

		if (!$copied) {
			exit("Problem occured.Cannot Upload Event Image.");
		}
	} else {
		$filename = $txtImage;
	}

	$update_data = "UPDATE menu SET MenuName='$txtMenuName', MenuTypeID='$txtMenuTypeID', ShortDescription='$txtShortDescription', promotion='$txtpromotion', Price='$txtprice', RestaurantID='$txtRestaurantID', Image='$filename' WHERE MenuID='$id'";
	$result = mysqli_query($connection, $update_data);

	if ($result) {
		echo "<script>window.alert('Menu Account Successfully Updated!')</script>";
	} else {
		echo "<p>Something went wrong in Menu Update" . mysqli_error($connection) . "</p>";
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Menus Entry</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<style>
		label {
			margin: 0 !important;
		}

		input {
			margin-bottom: 5px !important;
		}

		form {
			border: 1px solid gray;
			padding: 15px;
		}
	</style>
</head>

<body>
	<?php
	include('header.php');
	?>
	<div class="container-fluid">
		<p class="display-4">Menus</p>
		<div class="row">
			<div class="col-9 p-3">
				<table id="table" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Type ID</th>
							<th>Restaurant ID</th>
							<th>Description</th>
							<th>Promotion</th>
							<th>Image</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$menu_select = "SELECT * FROM menu";
						$menu_ret = mysqli_query($connection, $menu_select);
						$menu_count = mysqli_num_rows($menu_ret);
						for ($i = 0; $i < $menu_count; $i++) {
							$rows = mysqli_fetch_array($menu_ret);
							$MenuID = $rows['MenuID'];
							$image1 = $rows['Image'];
							echo "<tr>";
							echo "<td>" . $rows['MenuID'] . "</td>";
							echo "<td>" . $rows['MenuName'] . "</td>";
							echo "<td>" . $rows['MenuTypeID'] . "</td>";
							echo "<td>" . $rows['RestaurantID'] . "</td>";
							echo "<td>" . $rows['ShortDescription'] . "</td>";
							echo "<td>" . $rows['Promotion'] . "</td>";
							echo "<th><img src='$image1' width='60px' height='60px'/></th>";
							echo "<td>
				    				<a class='btn btn-warning btn-sm' href='Menu.php?MenuID=$MenuID'>Edit</a>
				    				<a class='btn btn-danger btn-sm' href='menuDelete.php?MenuID=$MenuID'>Delete</a>
				    			</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-3 p-3">
				<form action="Menu.php" method="post" enctype='multipart/form-data'>
					<h4 style="font-weight: 400;" class="mb-3">Enter Menu Information</h4>
					<label>Name</label>
					<input class="form-control" value="<?php echo $name ?>" type="text" name="txtMenuName" required />
					<label>Price</label>
					<input class="form-control" value="<?php echo $price ?>" type="text" name="txtprice" required />
					<label>Type</label>
					<!-- <input class="form-control" value="<?php echo $typeID ?>" type="text" name="txtMenuTypeID" required /> -->
					<select class="form-control" name="txtMenuTypeID" required>
						<?php
							if (isset($typeID)) {
								$query2 = "SELECT * FROM menutype WHERE MenuTypeID='$typeID'";
								$res2 = mysqli_query($connection, $query2);
								$arr2 = mysqli_fetch_array($res2);
								$typeName = $arr2['MenuTypeName'];
								echo "<option value='$typeID'>$typeName</option>";
							}
						?>
						<option>-Choose Type-</option>
						<?php
						$P_query = "SELECT * FROM menutype";
						$ret = mysqli_query($connection, $P_query);
						$count = mysqli_num_rows($ret);

						for ($i = 0; $i < $count; $i++) {
							$rows = mysqli_fetch_array($ret);
							$typeName2 = $rows['MenuTypeName'];
							$typeID = $rows['MenuTypeID'];

							echo "<option value='$typeID'>$typeName2</option>";
						}
						?>
					</select>
					<label>Description</label>
					<input class="form-control" value="<?php echo $description ?>" type="text" name="txtShortDescription" required />
					<label>Promotion</label>
					<input class="form-control" value="<?php echo $promotion ?>" type="text" name="txtpromotion" required />
					<label>Restaurant</label>
					<select class="form-control" name="txtRestaurantID" required>
						<?php
							if (isset($restaurantID)) {
								$query = "SELECT * FROM restaurants WHERE RestaurantID='$restaurantID'";
								$res = mysqli_query($connection, $query);
								$arr = mysqli_fetch_array($res);
								$restName = $arr['RestaurantName'];
								echo "<option value='$restaurantID'>$restName</option>";
							}
						?>
						<option>-Choose Restaurant-</option>
						<?php
						$P_query = "SELECT * FROM restaurants";
						$ret = mysqli_query($connection, $P_query);
						$count = mysqli_num_rows($ret);

						for ($i = 0; $i < $count; $i++) {
							$rows = mysqli_fetch_array($ret);
							$RestaurantName = $rows['RestaurantName'];
							$RestaurantID2 = $rows['RestaurantID'];

							echo "<option value='$RestaurantID2'>$RestaurantName</option>";
						}
						?>
					</select>
					<label>Image</label>
					<?php if ($image) : ?>
						<div>
							<img src="<?php echo $image ?>" width="100" height="100">
						</div>
					<?php endif; ?>
					<input class="form-control-file mt-1" name="menuimage" type="file" />
					<input type="hidden" name="txtMenuID" value="<?php echo $id ?>" />
					<input type="hidden" name="txtImage" value="<?php echo $image ?>" />
					<div class="mt-3 justify-content-end d-flex">
						<input class="btn btn-secondary mr-2" type="submit" value="Create" name="btnCreate" />
						<input class="btn btn-secondary mr-2" type="submit" value="Update" name="btnUpdate" />
						<input class="btn btn-secondary" type="reset" value="Clear" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#table').DataTable();

		});
	</script>
	<?php
	include('footer.php');
	?>
</body>

</html>
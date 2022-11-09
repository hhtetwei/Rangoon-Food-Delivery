<?php
session_start();
include('connection.php');

if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Staff_Login.php'
		</script>";
}

$name = "";
$mobile = "";
$location = "";
$email = "";

if (isset($_GET['RestaurantID'])) {
	$id = $_GET['RestaurantID'];

	$query = "SELECT * FROM restaurants WHERE RestaurantID='$id'";
	$ret = mysqli_query($connection, $query);
	$data = mysqli_fetch_array($ret);

	$name = $data['RestaurantName'];
	$mobile = $data['Phone'];
	$location = $data['Location'];
	$email = $data['Email'];
}

if (isset($_POST['btnCreate'])) {
	$txtRestaurantName = $_POST['txtRestaurantName'];
	$txtLocation = $_POST['txtLocation'];
	$txtPhone = $_POST['txtPhone'];
	$txtEmail = $_POST['txtEmail'];

	$insert_data = "INSERT INTO restaurants
				  (RestaurantName,Location,Phone,Email)
				  VALUES
				  ('$txtRestaurantName','$txtLocation','$txtPhone','$txtEmail')
				  ";
	$result = mysqli_query($connection, $insert_data);

	if ($result) {
		echo "<script>window.alert('Restaurants Adding Successfully Created!')</script>";
		echo "<script>window.location='Restaurants.php'</script>";
	} else {
		echo "<p>Something went wrong in Restaurant Entry" . mysqli_error($connection) . "</p>";
	}
}

if (isset($_POST['btnUpdate'])) {
	$id = $_POST['txtRestaurantID'];
	$txtRestaurantName = $_POST['txtRestaurantName'];
	$txtPhone = $_POST['txtPhone'];
	$txtLocation = $_POST['txtLocation'];
	$txtEmail = $_POST['txtEmail'];

	$update_data = "UPDATE restaurants SET RestaurantName='$txtRestaurantName', Location='$txtLocation', Phone='$txtPhone', Email='$txtEmail' WHERE RestaurantID='$id'";
	$result = mysqli_query($connection, $update_data);

	if ($result) {
		echo "<script>window.alert('Restaurant Successfully Updated!')</script>";
	} else {
		echo "<p>Something went wrong in Restaurant Update" . mysqli_error($connection) . "</p>";
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Restaurants Entry</title>
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
		<p class="display-4">Restaurants</p>
		<div class="row">
			<div class="col-9 p-3">
				<table id="table" style="width:100%">
					<thead>
						<tr>
							<th>RestaurantID</th>
							<th>RestaurantName</th>
							<th>Location</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$restaurants_select = "SELECT * FROM restaurants";
						$restaurants_ret = mysqli_query($connection, $restaurants_select);
						$restaurants_count = mysqli_num_rows($restaurants_ret);
						for ($i = 0; $i < $restaurants_count; $i++) {
							$rows = mysqli_fetch_array($restaurants_ret);
							$RestaurantID = $rows['RestaurantID'];
							echo "<tr>";
							echo "<td>" . $rows['RestaurantID'] . "</td>";
							echo "<td>" . $rows['RestaurantName'] . "</td>";
							echo "<td>" . $rows['Location'] . "</td>";
							echo "<td>" . $rows['Phone'] . "</td>";
							echo "<td>" . $rows['Email'] . "</td>";
							echo "<td>
									<a class='btn btn-warning btn-sm' href='Restaurants.php?RestaurantID=$RestaurantID'>Edit</a>
									<a class='btn btn-danger btn-sm' href='Restaurants_Delete.php?RestaurantID=$RestaurantID'>Delete</a>
				    			</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-3 p-3">
				<form action="Restaurants.php" method="post">
					<h4 style="font-weight: 400;" class="mb-3">Enter Restaurant Information</h4>
					<label>Name</label>
					<input class="form-control" value="<?php echo $name ?>" type="text" name="txtRestaurantName" required />
					<label>Location</label>
					<select class="form-control mb-1" name="txtLocation" required>
						<option><?php echo $location ?></option>
						<option>---</option>
						<option>Sanchaung</option>
						<option>Insein</option>
						<option>Latha</option>
						<option>Lanmadaw</option>
						<option>Hlaing</option>
						<option>Botahtaung</option>
						<option>Kamayut</option>
						<option>Kyauktada</option>
						<option>Ahlone</option>
					</select>
					<label>Phone</label>
					<input class="form-control" value="<?php echo $mobile ?>" type="text" name="txtPhone" required />
					<label>Email</label>
					<input class="form-control" value="<?php echo $email ?>" type="text" name="txtEmail" required />
					<input type="hidden" name="txtRestaurantID" value="<?php echo $id ?>" />
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
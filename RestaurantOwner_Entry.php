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
$address = "";
$email = "";

if (isset($_GET['id'])) {
	$ownerID = $_GET['id'];

	$query = "SELECT * FROM restaurant_owner WHERE restaurantowner_ID='$ownerID'";
	$ret = mysqli_query($connection, $query);
	$data = mysqli_fetch_array($ret);

	$name = $data['Name'];
	$mobile = $data['Phone'];
	$address = $data['Address'];
	$email = $data['Email'];
}

if (isset($_POST['btnCreate'])) {
	$txtName = $_POST['txtName'];
	$txtPhone = $_POST['txtPhone'];
	$txtAddress = $_POST['txtAddress'];
	$txtEmail = $_POST['txtEmail'];

	$check_email = "SELECT * FROM restaurant_owner WHERE Email='$txtEmail'";
	$result = mysqli_query($connection, $check_email);
	$count = mysqli_num_rows($result);

	if ($count > 0) {
		echo "<script>window.alert('Owner Email $txtEmail already exist!')</script>";
		echo "<script>window.location='RestaurantOwner_Entry.php'</script>";
		exit();
	}


	$insert_data = "INSERT INTO restaurant_owner
				  (Name,Phone,Address,Email)
				  VALUES
				  ('$txtName','$txtPhone','$txtAddress','$txtEmail')
				  ";
	$result = mysqli_query($connection, $insert_data);

	if ($result) //True
	{
		echo "<script>window.alert('Restaurant Owner Successfully Created!')</script>";
	} else {
		echo "<p>Something went wrong in Restaurant Owner Entry" . mysqli_error($connection) . "</p>";
	}
}

if (isset($_POST['btnUpdate'])) {
	$ownerID = $_POST['txtOwnerID'];
	$txtName = $_POST['txtName'];
	$txtPhone = $_POST['txtPhone'];
	$txtAddress = $_POST['txtAddress'];
	$txtEmail = $_POST['txtEmail'];

	$update_data = "UPDATE restaurant_owner SET Name='$txtName', Address='$txtAddress', Phone='$txtPhone', Email='$txtEmail' WHERE restaurantowner_ID='$ownerID'";
	$result = mysqli_query($connection, $update_data);

	if ($result) {
		echo "<script>window.alert('Restaurant Owner Successfully Updated!')</script>";
	} else {
		echo "<p>Something went wrong in Restaurant Owner Update" . mysqli_error($connection) . "</p>";
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Restaurant Owner Entry</title>

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
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
</head>

<body>
	<?php
	include('header.php');
	?>
	<div class="container-fluid">
		<p class="display-4">Restaurant Owners</p>
		<div class="row">
			<div class="col-9 p-3">
				<table id="table" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Email</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = "SELECT * FROM restaurant_owner";
						$ret = mysqli_query($connection, $query);
						$count = mysqli_num_rows($ret);

						for ($i = 0; $i < $count; $i++) {
							$rows = mysqli_fetch_array($ret);
							$id = $rows['restaurantowner_ID'];

							echo "<tr>";
							echo "<td>" . $rows['restaurantowner_ID'] . "</td>";
							echo "<td>" . $rows['Name'] . "</td>";
							echo "<td>" . $rows['Phone'] . "</td>";
							echo "<td>" . $rows['Address'] . "</td>";
							echo "<td>" . $rows['Email'] . "</td>";
							echo "<td>
									<a class='btn btn-warning btn-sm' href='RestaurantOwner_Entry.php?id=$id'>Edit</a>
									<a class='btn btn-danger btn-sm' href='restaurantOwnerDelete.php?id=$id'>Delete</a>
								</td>";
							echo "</tr>";
						}

						?>
					</tbody>
				</table>
			</div>
			<div class="col-3 p-3">
				<form action="RestaurantOwner_Entry.php" method="post">
					<h4 style="font-weight: 400;" class="mb-3">Enter Restaurant Owner Information</h4>
					<label>Name</label>
					<input class="form-control" value="<?php echo $name ?>" type="text" name="txtName" required />
					<label>Phone</label>
					<input class="form-control" value="<?php echo $mobile ?>" type="text" name="txtPhone" required />
					<label>Email</label>
					<input class="form-control" value="<?php echo $email ?>" type="text" name="txtEmail" required />
					<label>Address</label>
					<textarea class="form-control" name="txtAddress"><?php echo $address ?></textarea>
					<input type="hidden" name="txtOwnerID" value="<?php echo $ownerID ?>" />
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

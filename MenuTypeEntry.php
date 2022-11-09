<?php
session_start();
include('connection.php');

$type = "";
$description = "";

if (isset($_GET['MenuTypeID'])) {
	$id = $_GET['MenuTypeID'];

	$query = "SELECT * FROM menutype WHERE MenuTypeID='$id'";
	$ret = mysqli_query($connection, $query);
	$data = mysqli_fetch_array($ret);

	$type = $data['MenuTypeName'];
	$description = $data['ShortDescription'];
}

if (isset($_POST['btnCreate'])) {
	$txtMenuTypeName = $_POST['txtMenuTypeName'];
	$txtShortDescription = $_POST['txtshortdescription'];

	$insert_data = "INSERT INTO menutype
				  (MenuTypeName,ShortDescription)
				  VALUES
				  ('$txtMenuTypeName','$txtShortDescription')
				  ";
	$result = mysqli_query($connection, $insert_data);

	if ($result) {
		echo "<script>window.alert('Menu Type Successfully Created!')</script>";
		echo "<script>window.location='MenuTypeEntry.php'</script>";
	} else {
		echo "<p>Something went wrong in Menu Type Entry" . mysqli_error($connection) . "</p>";
	}
}

if (isset($_POST['btnUpdate'])) {
	$id = $_POST['txtMenuTypeID'];
	$txtMenuTypeName = $_POST['txtMenuTypeName'];
	$txtShortDescription = $_POST['txtshortdescription'];

	$update_data = "UPDATE menutype SET MenuTypeName='$txtMenuTypeName', ShortDescription='$txtShortDescription' WHERE MenuTypeID='$id'";
	$result = mysqli_query($connection, $update_data);

	if ($result) {
		echo "<script>window.alert('Menu Type Successfully Updated!')</script>";
	} else {
		echo "<p>Something went wrong in Menu Type Update" . mysqli_error($connection) . "</p>";
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Menu Type Entry</title>
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
		<p class="display-4">Menu types</p>
		<div class="row">
			<div class="col-9 p-3">
				<table id="table" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Type</th>
							<th>Description</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = "SELECT * FROM menutype";
						$ret = mysqli_query($connection, $query);
						$count = mysqli_num_rows($ret);
						for ($i = 0; $i < $count; $i++) {
							$rows = mysqli_fetch_array($ret);
							$MenuTypeID = $rows['MenuTypeID'];
							echo "<tr>";
							echo "<td>" . $rows['MenuTypeID'] . "</td>";
							echo "<td>" . $rows['MenuTypeName'] . "</td>";
							echo "<td>" . $rows['ShortDescription'] . "</td>";
							echo "<td>
									<a class='btn btn-warning btn-sm' href='MenuTypeEntry.php?MenuTypeID=$MenuTypeID'>Edit</a>
									<a class='btn btn-danger btn-sm' href='menuTypeDelete.php?MenuTypeID=$MenuTypeID'>Delete</a>
				    			</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-3 p-3">
				<form action="MenuTypeEntry.php" method="post">
					<h4 style="font-weight: 400;" class="mb-3">Enter Menu Type</h4>
					<label>Type</label>
					<input class="form-control" value="<?php echo $type ?>" type="text" name="txtMenuTypeName" required />
					<label>Description</label>
					<input class="form-control" value="<?php echo $description ?>" type="text" name="txtshortdescription" required />
					<input type="hidden" name="txtMenuTypeID" value="<?php echo $id ?>" />
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
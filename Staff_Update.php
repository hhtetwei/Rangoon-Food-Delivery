<?php  
session_start();
include('connection.php');

if(isset($_POST['btnUpdate'])) 
{
	$txtStaffID=$_POST['txtStaffID'];
	$txtStaffName=$_POST['txtStaffName'];
	$txtPhone=$_POST['txtPhone'];
	$txtAddress=$_POST['txtAddress'];
	$txtEmail=$_POST['txtEmail'];
	$txtStaffType=$_POST['txtStaffType'];

	//Update Staff Data in table
	$update_data="UPDATE staff 
				  SET 
				  StaffName='$txtStaffName',
				  Phone='$txtPhone',
				  Email='$txtEmail',
				  Password='$txtPassword',
				  StaffType='$txtStaffType',
				  WHERE Staff_ID='$txtStaffID'
				  ";
	$result=mysqli_query($connection,$update_data);

	if($result) //True
	{
		echo "<script>window.alert('Staff Account Successfully Updated!')</script>";
		echo "<script>window.location='Staff_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Staff Update" . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['Staff_ID'])) 
{
	$StaffID=$_GET['Staff_ID'];

	$query="SELECT * FROM staff WHERE Staff_ID='$StaffID'";
	$ret=mysqli_query($connection,$query);
	$rows=mysqli_fetch_array($ret);
}
else
{
	$StaffID="";
	echo "<script>window.alert('Somthing went wrong | StaffID not found')</script>";
	echo "<script>window.location='Staff_Entry.php'</script>";
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Staff Update</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />

</head>
<body>
<form action="Staff_Update.php" method="post">

<a href="Staff_Home.php">Staff Home</a>

<fieldset>
<legend>Enter Staff Information for Update :</legend>

<table>
<tr>
	<td>Staff Name</td>
	<td>
		<input type="text" name="txtStaffName" value="<?php echo $rows['Staff_Name'] ?>" required />
	</td>
</tr>
<tr>
	<td>Password</td>
	<td>
		<input type="password" name="txtPassword" value="<?php echo $rows['Password'] ?>" required />
	</td>
</tr>
<tr>
	<td>Phone</td>
	<td>
		<input type="text" name="txtPhone" value="<?php echo $rows['Phone'] ?>" required />
	</td>
</tr>
<tr>
	<td>Address</td>
	<td>
		<textarea name="txtAddress">
			<?php echo $rows['Address'] ?>
		</textarea>
	</td>
</tr>
<tr>
	<td>Email</td>
	<td>
		<input type="email" name="txtEmail" value="<?php echo $rows['Email'] ?>" required />
	</td>
</tr>

<tr>
	<td>StaffType</td>
	<td>
		<select name="StaffType">
			<option><?php echo $rows['StaffType'] ?></option>
			<option>-Choose StaffType-</option>
			<option>Sales Manager</option>
			<option>Web Administrator</option>
			<option>Operation Staff</option>
		</select>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="hidden" name="txtStaffID" value="<?php echo $rows['Staff_ID'] ?>" />
		<input type="submit" value="Update" name="btnUpdate"/>
		<input type="reset" value="Clear" />
	</td>
</tr>
</table>
</fieldset>

</form>
</body>
</html>
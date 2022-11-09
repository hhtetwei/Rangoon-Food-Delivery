<?php  
session_start();
include('connection.php');

$StaffID=$_GET['Staff_ID'];

$delete="DELETE FROM staff WHERE Staff_ID='$StaffID'";
$result=mysqli_query($connection,$delete);

if($result) {
	echo "<script>window.alert('Staff Account Successfully Deleted!')</script>";
	echo "<script>window.location='Staff_Entry.php'</script>";
} else {
	echo "<p>Something went wrong in Staff Delete" . mysqli_error($connection) . "</p>";
}
?>
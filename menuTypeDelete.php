<?php
session_start();
include('connection.php');

$MenuTypeID = $_GET['MenuTypeID'];

$delete = "DELETE FROM menutype WHERE MenuTypeID='$MenuTypeID'";
$result = mysqli_query($connection, $delete);

if ($result) {
    echo "<script>window.alert('Menu Type Successfully Deleted!')</script>";
    echo "<script>window.location='MenuTypeEntry.php'</script>";
} else {
    echo "<p>Something went wrong in Menu Type Delete" . mysqli_error($connection) . "</p>";
}
?>
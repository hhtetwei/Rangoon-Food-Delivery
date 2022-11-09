<?php
session_start();
include('connection.php');

if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Staff_Login.php'
		</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Customer List</title>
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
        <p class="display-4">Customers</p>
        <div class="row">
            <div class="col p-3">
                <table id="table">
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
                        $query = "SELECT * FROM customer";
                        $ret = mysqli_query($connection, $query);
                        $count = mysqli_num_rows($ret);

                        for ($i = 0; $i < $count; $i++) {
                            $rows = mysqli_fetch_array($ret);
                            $customerId = $rows['CustomerID'];

                            echo "<tr>";
                            echo "<td>" . $rows['CustomerID'] . "</td>";
                            echo "<td>" . $rows['CustomerName'] . "</td>";
                            echo "<td>" . $rows['Phone'] . "</td>";
                            echo "<td>" . $rows['Address'] . "</td>";
                            echo "<td>" . $rows['Email'] . "</td>";
                            echo "<td><a class='btn btn-danger btn-sm' href='customerDelete.php?Customer_ID=$customerId'>Delete</a></td>";
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
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
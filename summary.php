<?php
session_start();
include('connection.php');

if (!isset($_SESSION['CustomerID'])) {
    echo "<script>alert('Please login to continue')
		window.location='Customer_Login.php'
		</script>";
}

if (isset($_POST['homepageBtn'])) {
    unset($_SESSION['ShoppingCart_Functions']);
    echo "<script>window.location='index.php'</script>";
}

include('AutoID_Functions.php');
include('Shopping_Cart_Functions.php');
?>
<!DOCTYPE html>

<html>

<head>
    <title>Summary</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .row {
            margin: 0 !important;
        }

        td:nth-child(3) {
            padding-left: 50px;
        }

        .shopping-cart thead th {
            font-size: 15px;
            padding: 5px !important;
            height: 30px;
            text-align: center;
        }

        .shopping-cart tbody td {
            text-align: center;
        }

        .custom-button {
            color: white !important;
            font-weight: bold !important;
            background-color: #f4511e !important;
        }

        .summary table td {
            text-align: left;
            padding: 5px;
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div class="container-fluid">
        <p class="display-4">Summary</p>

        <div class="text-center">
            <h3 class="text-success">Your order is now in progress.</h3>
            <h5 class="text-success">Thank you for shopping with us.</h5>
        </div>

        <div class="shopping-cart border border-dark p-3 mt-4">
            <h3 style="font-weight: 400;" class="mb-4">Ordered items</h3>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Image</th>
                        <th>Product name</th>
                        <th>Price <small>(MMK)</small></th>
                        <th>Quantity <small>(pcs)</small></th>
                        <th>Total <small>(MMK)</small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $size = count($_SESSION['ShoppingCart_Functions']);
                    for ($i = 0; $i < $size; $i++) {
                        $Image = $_SESSION['ShoppingCart_Functions'][$i]['Image'];
                        $MenuID = $_SESSION['ShoppingCart_Functions'][$i]['MenuID'];
                        $MenuName = $_SESSION['ShoppingCart_Functions'][$i]['MenuName'];
                        $Price = $_SESSION['ShoppingCart_Functions'][$i]['Price'];
                        $Quantity = $_SESSION['ShoppingCart_Functions'][$i]['Quantity'];
                        $SubTotal = $Price * $Quantity;
                        echo "<tr>";
                        echo "<td><img src='$Image' class='img-fluid' width='100px' height='100px' /></td>";
                        echo "<td>$MenuName</td>";
                        echo "<td>$Price</td>";
                        echo "<td>$Quantity</td>";
                        echo "<td>$SubTotal</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-end summary">
                <table>
                    <tr>
                        <td>Total quantity</td>
                        <td>- <b><?php echo CalculateTotalQuantity() ?> pcs</b></td>
                    </tr>
                    <tr>
                        <td>Total amount</td>
                        <td>- <b><?php echo CalculateTotalAmount() ?> MMK</b></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>- <b><?php echo CalculateVAT() ?> MMK</b></td>
                    </tr>
                    <tr>
                        <td>Grand total</td>
                        <td>- <b><?php echo CalculateTotalAmount() + CalculateVAT() ?> MMK</b></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="my-3">
            <form action="summary.php" method="POST">
                <input type="submit" class="btn custom-button" name="homepageBtn" value="Go back to homepage">
            </form>
        </div>
    </div>
    <?php
    include('footer.php');
    ?>
</body>

</html>
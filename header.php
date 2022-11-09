<?php
include('connection.php');
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Untitled Document</title>
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <script src="fontawesome-free-5.15.1-web/js/all.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
        .dd-button {
            color: white !important;
        }

        .nav-link {
            color: white !important;
            display: inline-block !important;
        }

        .navbar-brand img {
            width: 75px;
            height: 75px;
        }

        .navbar-brand {
            font-size: 30px !important;
            font-family: "Comic Sans MS", cursive, sans-serif;
        }
    </style>
</head>

<body>
    <?php
    if (empty($_SESSION['CustomerID']) && empty($_SESSION['Staff_Name'])) :
    ?>
        <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#f4511e;  height: 65px;">
            <a href="index.php" class="navbar-brand">RANGooN <img src="image/sticker-png-person-riding-on-motorcycle-illustration-pizza-u0130skender-kebap-kebab-take-out-delivery-creative-motorcycles-food-creative-artwork-logo-car-removebg-preview.png"></a>
            <button type="button" class="navbar-toggler border-0" data-toggle="collapse" data-target="#collapsibalnavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="collapsibalnavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="Customer_Login.php" data-toggle="modal"><i class="fas fa-unlock"></i> Login</a>
                    </li>
                    <li>
                        <a class="nav-link" href="customerRegister.php"><i class="fas fa-id-card"></i> Register</a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php elseif (isset($_SESSION['Staff_Name'])) : ?>
        <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#f4511e; height: 65px;">
            <a href="index.php" class="navbar-brand">RANGooN <img src="image/sticker-png-person-riding-on-motorcycle-illustration-pizza-u0130skender-kebap-kebab-take-out-delivery-creative-motorcycles-food-creative-artwork-logo-car-removebg-preview.png"></a>
            <button type="button" class="navbar-toggler border-0" data-toggle="collapse" data-target="#collapsibalnavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="collapsibalnavbar">
                <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle dd-button" data-toggle="dropdown">
                        Pages
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="Menu.php">Menus</a>
                        <a class="dropdown-item" href="MenuTypeEntry.php">Menu types</a>
                        <a class="dropdown-item" href="Restaurants.php">Restaurants</a>
                        <a class="dropdown-item" href="orders.php">Orders</a>
                        <a class="dropdown-item" href="Staff_Entry.php">Staffs</a>
                        <a class="dropdown-item" href="customers.php">Customers</a>
                        <a class="dropdown-item" href="RestaurantOwner_Entry.php">Restaurant Owners</a>
                        <a class="dropdown-item" href="ContractRestaurants.php">Contract Restaurants</a>
                    </div>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="Logout.php"><i class="fas fa-arrow-alt-circle-left"></i> Log out</a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php else : ?>
        <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#f4511e; height: 65px;">
            <a href="index.php" class="navbar-brand">RANGooN <img src="image/sticker-png-person-riding-on-motorcycle-illustration-pizza-u0130skender-kebap-kebab-take-out-delivery-creative-motorcycles-food-creative-artwork-logo-car-removebg-preview.png"></a>
            <button type="button" class="navbar-toggler border-0" data-toggle="collapse" data-target="#collapsibalnavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="collapsibalnavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="Shopping_Cart.php"><i class="fas fa-shopping-cart"></i> Shopping cart</a>
                        <a class="nav-link" href="Logout.php"><i class="fas fa-arrow-alt-circle-left"></i> Log out</a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>
</body>

</html>
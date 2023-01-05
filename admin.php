<?php
    require('functions.php');

    if (!isset($_COOKIE['login'])) {
        header('location: login.php');
    }
    else if (isset($_COOKIE['login']) && !isAdmin($_COOKIE['login'])) {
        header('location: user.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Snap Up!</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="jquery.js"></script>
    <script src="https://kit.fontawesome.com/a94f14827e.js" crossorigin="anonymous"></script>
</head>

<body id="adminBody">
    <header>
        <h1>Snap Up! <i class="fa-solid fa-cart-shopping"></i></h1>
    </header>
    <a href="index.php" id="homeBtn"><i class="fa-solid fa-house"></i></a>
    <main id="adminMain">
        <p>Manage database.</p>
        <nav>
            <a href="admin/brand.php"><i class="fa-solid fa-globe"></i>Brand</a>
            <a href="admin/category.php"><i class="fa-solid fa-chart-pie"></i>Category</a>
            <a href="admin/chain.php"><i class="fa-solid fa-shop"></i>Chain</a>
            <a href="admin/item.php"><i class="fa-solid fa-barcode"></i>Item</a>
            <a href="admin/store.php"><i class="fa-solid fa-store"></i>Store</a>
            <a href="admin/report.php"><i class="fa-solid fa-comment-dollar"></i>Report</a>
        </nav>
        <form action="" method="POST">
            <br><br>
            <input type="submit" name="logout" value="Logout" class="logoutBtn">
            <?php logout() ?>
            <br><br>
        </form>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? 'Logged in as <a href="admin.php">' . $_COOKIE["login"] . '</a><br><br>' : 'Logged in as <a href="user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
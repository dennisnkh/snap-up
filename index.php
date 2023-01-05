<?php
    require('functions.php');
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

<body id="indexBody">
    <header>
        <h1>Snap Up! <i class="fa-solid fa-cart-shopping"></i></h1>
    </header>
    <a href="index.php" id="homeBtn"><i class="fa-solid fa-house"></i></a>
    <main id="indexMain">
        <p id="indexDescription">
            <span id="indexDescription1">This is a platform for people to&nbsp;</span>
            <span id="indexDescription2">share bargains with each other.</span>
        </p>
        <nav>
            <a href="search.php"><i class="fa-solid fa-magnifying-glass"></i>Search</a>
            <a href="report.php"><i class="fa-solid fa-comment-dollar"></i>Report</a>
        </nav>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? '<a href="admin.php" id="userBtn"><i class="fa-solid fa-user"></i> Admin</a>' : '<a href="user.php" id="userBtn"><i class="fa-solid fa-user"></i> User Profile</a>' : '<a href="login.php" id="userBtn"><i class="fa-solid fa-user"></i> User Login</a>') ?>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? 'Logged in as <a href="admin.php">' . $_COOKIE["login"] . '</a><br><br>' : 'Logged in as <a href="user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
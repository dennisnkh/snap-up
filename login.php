<?php
require('functions.php');

if (isset($_COOKIE['login'])) {
    header('location: index.php');
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

<body>
    <header>
        <h1>Snap Up! <i class="fa-solid fa-cart-shopping"></i></h1>
    </header>
    <a href="index.php" id="homeBtn"><i class="fa-solid fa-house"></i></a>
    <main>
        <p>Login to report a good bargain or access to user's features.</p>
        <fieldset>
            <form action="login.php" method="POST"><br>
                Username: <input type="text" required name="username"><br><br>
                Password: <input type="password" required name="password"><br><br>
                <input type="submit" value="Login" name="sub">
                <br>
            </form>
            <?php loginValidation() ?>
        </fieldset>
        <div>
            <p>New to Snap Up? Click <a href="create.php">here</a> to create an account.</p>
        </div>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? 'Logged in as <a href="admin.php">' . $_COOKIE["login"] . '</a><br><br>' : 'Logged in as <a href="user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
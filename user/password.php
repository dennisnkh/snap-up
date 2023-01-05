<?php
    require('../functions.php');

    if (!isset($_COOKIE['login'])) {
        header('location: ../login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Snap Up!</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="user.js"></script>
    <script src="https://kit.fontawesome.com/a94f14827e.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <h1>Snap Up! <i class="fa-solid fa-cart-shopping"></i></h1>
    </header>
    <a href="../index.php" id="homeBtn"><i class="fa-solid fa-house"></i></a>
    <main>
        <p>Change your password.</p>
        <form action="password.php" method="POST"><br>
            <label for="username">Old password: </label><input type="password" required id="oldpassword" name="oldpassword"> <br><br>
            <label for="username">New Password: </label><input type="password" required id="newpassword" name="newpassword"> <br>
            <div id="passwordGuide">
                <ul>
                    <li>at least 8 - 20 characters</li>
                    <li>must contain at least one alphabet (a-zA-Z), one digit (0-9) and one special character (@, $, *, !)</li>
                </ul>
            </div>
            <br>
            <input type="submit" value="Change" class="submitBtn">
        </form>
        <?php passwordValidation() ?>
        <br>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? 'Logged in as <a href="../user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="../doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
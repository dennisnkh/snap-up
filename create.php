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

<body>
    <header>
        <h1>Snap Up! <i class="fa-solid fa-cart-shopping"></i></h1>
    </header>
    <a href="index.php" id="homeBtn"><i class="fa-solid fa-house"></i></a>
    <main>
        <fieldset>
            <form action="create.php" method="POST"><br>
                <label for="username">Create username: </label><input type="text" required id="usernameCreate" name="usernameCreate">
                <div id="usernameGuide">
                    <ul>
                        <li>- at least 5 - 20 characters</li>
                        <li>- consist of alphabets (a-zA-Z) and digits (0-9) only</li>
                        <li>- special characters are not allowed</li>
                    </ul>
                </div>
                <br><br>
                <label for="username">Create password: </label><input type="password" required id="passwordCreate" name="passwordCreate">
                <div id="passwordGuide">
                    <ul>
                        <li>- at least 8 - 20 characters</li>
                        <li>- must contain at least one alphabet (a-zA-Z), one digit (0-9) and one special character (@, $, *, !)</li>
                    </ul>
                </div>
                <br><br>
                <input type="submit" value="Create">
                <br>
            </form>
        </fieldset>
        <?php userCreateValidation() ?>
        <br>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? 'Logged in as <a href="admin.php">' . $_COOKIE["login"] . '</a><br><br>' : 'Logged in as <a href="user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
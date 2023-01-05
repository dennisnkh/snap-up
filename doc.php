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
    <main id="doc" style="font-size: small">
        <p><u>Student</u><br>Ki Hin Ng</p>
        <p><u>College</u><br>Langara College</p>
        <p><u>Student ID</u><br>100378679</p>
        <p><u>Course</u><br>CPSC2030</p>
        <p>
            <u>Documentation</u><br>
            The project is built by php using phpMyAdmin of XAMPP.<br>
            This is a platform for people to share bargains.<br><br>
            Search: <br>
            - No login required<br>
            - the latest 10 reports will be shown by default<br>
            - Users can search based on items, categories, brands or chains<br><br>
            Report: <br>
            - Login required <br>
            - select items, stores and input price to report<br><br>
            Users: <br>
            - People who are new to the website can sign up to login<br>
            - Normal users can edit their reports and change login password<br>
            - Admin can manage the whole database<br><br>
            Validation (functions.php) from <a href="https://extendsclass.com/php-tester.html">ExtendsClass</a>:<br>
            <img src="img/validation.png" alt="validation" width="60%"><br>
        </p>
        <p>
            <u>Sources</u><br>
            (Fonts) <a href="https://fonts.google.com/">Google Fonts</a><br>
            (Icons) <a href="https://fontawesome.com/">Font Awesome</a><br>
            (Select Boxes) <a href="https://select2.org/">Select2</a><br>
            (Google Maps Iframe Generator) <a href="https://www.maps.ie/create-google-map/">Maps.ie</a>
        </p>
        <br><br>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? 'Logged in as <a href="admin.php">' . $_COOKIE["login"] . '</a><br><br>' : 'Logged in as <a href="user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
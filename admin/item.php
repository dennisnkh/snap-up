<?php
    require('../functions.php');

    if (!isset($_COOKIE['login'])) {
        header('location: ../login.php');
    }
    else if (isset($_COOKIE['login']) && !isAdmin($_COOKIE['login'])) {
        header('location: ../user.php');
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
    <script src="admin.js"></script>
    <script src="https://kit.fontawesome.com/a94f14827e.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <h1>Snap Up! <i class="fa-solid fa-cart-shopping"></i></h1>
    </header>
    <a href="../index.php" id="homeBtn"><i class="fa-solid fa-house"></i></a>
    <main>
        <p>What do you want to manage about item?</p>
        <button class="addBtn">Add</button>
        <button class="updateBtn">Update</button>
        <button class="deleteBtn">Delete</button>
        <div class="add">
            <br>
            <form action="item.php" method="POST">
                <fieldset>
                    <legend>Add Item</legend>
                    <div class="adminForm">
                        <?php itemAddBrandFilter() ?>
                    </div>
                    <div class="adminForm">
                        <label for="itemName">item name:</label>
                        <input type="text" id="itemName" name="itemName" required>
                    </div>
                    <br>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>
        </div>
        <div class="update">
            <br>
            <form action="item.php" method="POST">
                <fieldset>
                    <legend>Update Item</legend>
                    <?php itemUpdateFilter() ?>
                    <div class="adminForm">
                        <label for="newItemName">New name (leave blank if no change):</label>
                        <input type="text" id="newItemName" name="newItemName">
                    </div>
                    <br>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>
        </div>
        <div class="delete">
            <br>
            <form action="item.php" method="POST">
                <fieldset>
                    <legend>Delete Item</legend>
                    <div class="adminForm">
                        <?php itemDeleteFIlter() ?>
                    </div>
                    <br>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>
        </div>
        <br><br>
        <?php itemAdd() ?>
        <?php itemUpdate() ?>
        <?php itemDelete() ?>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? 'Logged in as <a href="../admin.php">' . $_COOKIE["login"] . '</a><br><br>' : 'Logged in as <a href="../user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="../doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
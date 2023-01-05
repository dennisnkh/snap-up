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
        <p>What do you want to manage about store?</p>
        <button class="addBtn">Add</button>
        <button class="updateBtn">Update</button>
        <button class="deleteBtn">Delete</button>
        <div class="add">
            <br>
            <form action="store.php" method="POST">
                <fieldset>
                    <legend>Add Store</legend>
                    <div class="adminForm">
                        <?php storeAddChainFilter() ?>
                    </div>
                    <div class="adminForm">
                        <label for="newStoreName">store name:</label>
                        <input type="text" id="newStoreName" name="newStoreName" required>
                    </div>
                    <div class="adminForm">
                        <label for="newStoreAddress">store address:</label>
                        <input type="text" id="newStoreAddress" name="newStoreAddress" required>
                    </div>
                    <br>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>
        </div>
        <div class="update">
            <br>
            <form action="store.php" method="POST">
                <fieldset>
                    <legend>Update Store</legend>
                    <?php storeUpdateFilter() ?>
                    <div class="adminForm">
                        <label for="updateStoreName">New name:</label>
                        <input type="text" id="updateStoreName" name="updateStoreName" placeholder="(leave blank if no change)">
                    </div>
                    <div class="adminForm">
                    <label for="updateStoreAddress">New address:</label>
                    <input type="text" id="updateStoreAddress" name="updateStoreAddress" placeholder="(leave blank if no change)">
                    </div>
                    <br>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>
        </div>
        <div class="delete">
            <br>
            <form action="store.php" method="POST">
                <fieldset>
                    <legend>Delete Store</legend>
                    <div class="adminForm">
                        <?php storeDeleteFilter() ?>
                    </div>
                    <br>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>
        </div>
        <br><br>
        <?php storeAdd() ?>
        <?php storeUpdate() ?>
        <?php storeDelete() ?>
    </main>
    <footer>
        <?php echo (isset($_COOKIE['login']) ? isAdmin($_COOKIE['login']) ? 'Logged in as <a href="../admin.php">' . $_COOKIE["login"] . '</a><br><br>' : 'Logged in as <a href="../user.php">' . $_COOKIE["login"] . '</a><br><br>' : '') ?>
        <a href="../doc.php">About</a>&nbsp;&nbsp;|&nbsp;
        Copyright &copy; Dennis Ng <?php echo date('Y') ?>
    </footer>
</body>

</html>
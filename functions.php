<?php

// Connect to database

define('DBHOST', 'localhost');
define('DBNAME', 'snap_up');
define('DBUSER', 'root');
define('DBPASS', '');

$pdo = db_connect();

function db_connect() {
    try {
        $connectionString = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
        $user = DBUSER;
        $pass = DBPASS;

        $pdo = new PDO($connectionString, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
}

// Get data from database

$brands = [];
$categories = [];
$chains = [];
$items = [];
$stores = [];
$users = [];

function getCategories() {
    global $pdo;
    global $categories;

    $sql = "SELECT * FROM category ORDER BY categoryName ASC";

    $result = $pdo->query($sql);
    while ($row = $result->Fetch()) {
      $categories[] = $row;
    }
}
getCategories();

function getBrands() {
    global $pdo;
    global $brands;

    $sql = "SELECT * FROM brand ORDER BY brandName ASC";

    $result = $pdo->query($sql);
    while ($row = $result->Fetch()) {
      $brands[] = $row;
    }
}
getBrands();

function getChains() {
    global $pdo;
    global $chains;

    $sql = "SELECT * FROM chain ORDER BY chainName ASC";

    $result = $pdo->query($sql);
    while ($row = $result->Fetch()) {
      $chains[] = $row;
    }
}
getChains();

function getItems() {
    global $pdo;
    global $items;

    $sql = "SELECT * FROM item ORDER BY itemName ASC";

    $result = $pdo->query($sql);
    while ($row = $result->Fetch()) {
      $items[] = $row;
    }
}
getItems();

function getStores() {
    global $pdo;
    global $stores;

    $sql = "SELECT * FROM store ORDER BY storeName ASC";

    $result = $pdo->query($sql);
    while ($row = $result->Fetch()) {
      $stores[] = $row;
    }
}
getStores();

function getUsers() {
    global $pdo;
    global $users;

    $sql = "SELECT * FROM user";

    $result = $pdo->query($sql);
    while ($row = $result->Fetch()) {
      $users[] = $row;
    }
}
getUsers();

// Filter templates

function brandFilter() {
    global $brands;

    echo '<label for="brand">Brand</label>
          <select id="brand" name="brand" style="width: 60%">';

    echo '<option value="All">All</option>';

    foreach($brands as $row) {
        ?>
          <option value="<?php echo $row['brandName']; ?>"><?php echo $row['brandName']; ?></option>
        <?php
    }

    echo '</select>';
}

function categoryFilter() {
    global $categories;

    echo '<label for="category">Category</label>
          <select id="category" name="category" style="width: 60%">';

    echo '<option value="All">All</option>';

    foreach($categories as $row) {
        ?>
          <option value="<?php echo $row['categoryName']; ?>"><?php echo $row['categoryName']; ?></option>
        <?php
    }

    echo '</select>';
}

function chainFilter() {
    global $chains;

    echo '<label for="chain">Chain</label>
          <select id="chain" name="chain" style="width: 60%">';

    echo '<option value="All">All</option>';

    foreach($chains as $row) {
        ?>
          <option value="<?php echo $row['chainName']; ?>"><?php echo $row['chainName']; ?></option>
        <?php
    }

    echo '</select>';
}

function itemFilter() {
    global $items;

    echo '<label for="item">Item</label>
          <select id="item" name="item" style="width: 60%">';

    echo '<option value="" selected>All</option>';

    foreach($items as $row) {
        ?>
          <option value="<?php echo $row['itemName']; ?>"><?php echo $row['itemName']; ?></option>
        <?php
    }

    echo '</select>';
}

function reportItemFilter() {
    global $items;

    echo '<label for="item">Item</label>
          <select id="item" name="item" style="width: 60%" required>';

    echo '<option value="" selected disabled>Select an item</option>';

    foreach($items as $row) {
        ?>
          <option value="<?php echo $row['itemName']; ?>"><?php echo $row['itemName']; ?></option>
        <?php
    }

    echo '</select>';
}

function storeFilter() {
    global $stores;

    echo '<label for="store">Store</label>
          <select id="store" name="store" required style="width: 60%">';

    echo '<option value="" disabled selected>Select a store</option>';

    foreach($stores as $row) {
        ?>
          <option value="<?php echo $row['storeName']; ?>"><?php echo $row['storeName']; ?></option>
        <?php
    }

    echo '</select>';
}

// Search function

$results = [];

function handleSearch() {
    global $pdo;
    global $results;
  
        if (isset($_GET['item']) && isset($_GET['category']) && isset($_GET['brand']) && isset($_GET['chain'])) {

            $category = $brand = $chain = "";

            if ($_GET['category'] != "All") {
                $category = "AND categoryName = '" . $_GET['category'] . "' ";
            }
            if ($_GET['brand'] != "All") {
                $brand = "AND brandName = '" . $_GET['brand'] . "' ";
            }
            if ($_GET['chain'] != "All") {
                $chain = "AND chainName = '" . $_GET['chain'] . "' ";
            }
            
            $sql = "SELECT reportID, date, time, username, categoryName, brandName, itemName, price, storeName
                    FROM report
                    INNER JOIN item ON report.itemID = item.itemID
                    INNER JOIN store ON report.storeID = store.storeID
                    INNER JOIN brand ON item.brandID = brand.brandID
                    INNER JOIN category ON brand.categoryID = category.categoryID
                    INNER JOIN chain ON store.chainID = chain.chainID
                    INNER JOIN user ON report.userID = user.userID
                    WHERE itemName LIKE '%" . $_GET['item'] . "%' " . $category . $brand . $chain ."
                    ORDER BY date DESC, time DESC ";

            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                $results[] = $row;
            }
        }
        else {
            $sql = "SELECT reportID, date, time, username, categoryName, brandName, itemName, price, storeName
                    FROM report
                    INNER JOIN item ON report.itemID = item.itemID
                    INNER JOIN store ON report.storeID = store.storeID
                    INNER JOIN brand ON item.brandID = brand.brandID
                    INNER JOIN category ON brand.categoryID = category.categoryID
                    INNER JOIN chain ON store.chainID = chain.chainID
                    INNER JOIN user ON report.userID = user.userID
                    ORDER BY date DESC, time DESC ";

            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                $results[] = $row;
            }
        }
    
}

// Show search result

function getResults() {
    global $results;
    global $stores;

    if (isset($_GET['item']) && isset($_GET['category']) && isset($_GET['brand']) && isset($_GET['chain'])) {

        if (count($results) == 0) {
            echo "No results.";
        }
        else {
            foreach($results as $row) {
                $storeAddress = "";
                foreach ($stores as $storeRow) {
                    if ($row['storeName'] == $storeRow['storeName']) {
                        $storeAddress = str_replace(" ","%20", $storeRow['address']);
                    }
                }
                ?>
                    <div class="searchResult">
                        <div class="reportID"><i class="fa-solid fa-hashtag"></i> <?php echo $row['reportID']; ?></div>
                        <div class="datetime"><i class="fa-regular fa-clock"></i> <?php echo $row['date']; ?> <?php echo $row['time']; ?></div>
                        <div class="itemname"><i class="fa-solid fa-barcode"></i> <?php echo $row['itemName']; ?></div>
                        <div class="price"><i class="fa-solid fa-comment-dollar"></i> $<?php echo $row['price']; ?></div>
                        <div class="username"><i class="fa-solid fa-user"></i> <?php echo $row['username']; ?></div>
                        <div class="store"><i class="fa-solid fa-location-dot"></i> <?php echo $row['storeName']; ?> <input type="submit" class="showMapBtn" value="Show Map"></div>
                        <div class="map" style="width: 100%; display: none;"><iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=100%25&amp;hl=en&amp;q=<?php echo $storeAddress; ?>+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.maps.ie/distance-area-calculator.html">area maps</a></iframe></div>
                    </div><br>
                <?php
            }
        }

    }
    else {
        foreach(array_slice($results,0,10) as $row) {
            $storeAddress = "";
            foreach ($stores as $storeRow) {
                if ($row['storeName'] == $storeRow['storeName']) {
                    $storeAddress = str_replace(" ","%20", $storeRow['address']);
                }
            }
            ?>
                <div class="searchResult">
                    <div class="reportID"><i class="fa-solid fa-hashtag"></i> <?php echo $row['reportID']; ?></div>
                    <div class="datetime"><i class="fa-regular fa-clock"></i> <?php echo $row['date']; ?> <?php echo $row['time']; ?></div>
                    <div class="itemname"><i class="fa-solid fa-barcode"></i> <?php echo $row['itemName']; ?></div>
                    <div class="price"><i class="fa-solid fa-comment-dollar"></i> $<?php echo $row['price']; ?></div>
                    <div class="username"><i class="fa-solid fa-user"></i> <?php echo $row['username']; ?></div>
                    <div class="store"><i class="fa-solid fa-location-dot"></i> <?php echo $row['storeName']; ?> <input type="submit" class="showMapBtn" value="Show Map"></div>
                    <div class="map" style="width: 100%; display: none;"><iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=100%25&amp;hl=en&amp;q=<?php echo $storeAddress; ?>+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.maps.ie/distance-area-calculator.html">area maps</a></iframe></div>
                </div><br>
            <?php
        }
    }
}

// Submit report function

function handleSubmit() {
    global $pdo;
    global $items;
    global $stores;
    global $users;

    $store = "";
    $item = "";
    $user = "";
  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST['item']) && isset($_POST['store']) && isset($_POST['price'])) {

            foreach($stores as $row) {
                if ($row['storeName'] == $_POST['store']) {
                    $store = $row['storeID'];
                }
            }

            foreach($items as $row) {
                if ($row['itemName'] == $_POST['item']) {
                    $item = $row['itemID'];
                }
            }

            foreach($users as $row) {
                if ($row['username'] == $_COOKIE['login']) {
                    $user = $row['userID'];
                }
            }

            $sql = 'INSERT INTO report (userID, itemID, storeID, price, date, time) VALUES (:userid, :itemid, :storeid, :price, :date, :time)';
    
            $statement = $pdo->prepare($sql);

            $statement->bindValue(':userid', $user);
            $statement->bindValue(':itemid', $item);
            $statement->bindValue(':storeid', $store);
            $statement->bindValue(':price', $_POST['price']);
            $statement->bindValue(':date', date('Y-m-d'));
            $statement->bindValue(':time', date('H:i:s'));
    
            $statement->execute();
        }
    }
}

// Show submitted report

function showReport() {
    if (isset($_POST['item']) && isset($_POST['store']) && isset($_POST['price'])) {
        echo "<div id='submissionReport' style='color: blue'>
                <p>Successful submission! Please find your report below.</p>
                <p>Item: <strong>" . $_POST['item'] . "</strong></p>
                <p>Store: <strong>" . $_POST['store'] . "</strong></p>
                <p>Price: <strong>$" . $_POST['price'] . "</strong></p>
                <p>Submission time: <strong>" . date('Y-m-d') . " " . date('H:i:s') . "</strong></p>
              </div><br>";
    }
}

// Admin functions

// Category

function catAdd() {
    global $pdo;
    global $categories;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['catName'])) {
            
            $unique = true;

            foreach($categories as $row) {
                if ($_POST['catName'] == $row['categoryName']) {
                    $unique = false;
                }
            }

            if ($unique) {
                $sql = 'INSERT INTO category (categoryName) VALUES (:catName)';
    
                $statement = $pdo->prepare($sql);

                $statement->bindValue(':catName', $_POST['catName']);
        
                $statement->execute();

                echo "<script>alert('A new category " . $_POST['catName'] . " is added successfully!')</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<p class='adminResult'>Failed: category already exists</p>";
            }
        }
    }

}

function catUpdateFilter() {
    
    global $categories;

    echo '<label for="catToUpdate">Choose a category:</label>
          <select id="catToUpdate" name="catToUpdate" required>';

    echo '<option value="" disabled selected>Select a category</option>';

    foreach($categories as $row) {
        ?>
          <option value="<?php echo $row['categoryName']; ?>"><?php echo $row['categoryName']; ?></option>
        <?php
    }

    echo '</select>';
}

function catUpdate() {
    global $pdo;
    global $categories;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['catToUpdate']) && isset($_POST['newCatName'])) {

            $unique = true;

            foreach($categories as $row) {
                if ($_POST['newCatName'] == $row['categoryName']) {
                    $unique = false;
                }
            }

            if ($unique) {
                $sql = 'UPDATE category SET categoryName = :newCatName WHERE categoryName = :catToUpdate';
    
                $statement = $pdo->prepare($sql);

                $statement->bindValue(':newCatName', $_POST['newCatName']);
                $statement->bindValue(':catToUpdate', $_POST['catToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Category is updated successfully: ' . $_POST['newCatName'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<p class='adminResult'>Failed: this category name already exists</p>";
            }
            
        }
    }
}

function catDeleteFilter() {
    
    global $categories;

    echo '<label for="catToDelete">Choose a category:</label>
          <select id="catToDelete" name="catToDelete" required>';

    echo '<option value="" disabled selected>Select a category</option>';

    foreach($categories as $row) {
        ?>
          <option value="<?php echo $row['categoryName']; ?>"><?php echo $row['categoryName']; ?></option>
        <?php
    }

    echo '</select>';
}

function catDelete() {
    global $pdo;
    global $categories;
    global $brands;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['catToDelete'])) {

            $catID = "";

            foreach($categories as $row) {
                if ($_POST['catToDelete'] == $row['categoryName']) {
                    $catID = $row['categoryID'];
                }
            }

            $hasBrands = false;

            foreach($brands as $row) {
                if ($catID == $row['categoryID']) {
                    $hasBrands = true;
                }
            }

            if ($hasBrands) {
                echo "<p class='adminResult'>Failed to delete category: " . $_POST['catToDelete'] . " (Please delete associated brands first)</p>";
            }
            else {
                $sql = 'DELETE FROM category WHERE categoryName = :catToDelete';
    
                $statement = $pdo->prepare($sql);
    
                $statement->bindValue(':catToDelete', $_POST['catToDelete']);
            
                $statement->execute();
    
                echo "<script>alert('Category is deleted successfully: " . $_POST['catToDelete'] . "')</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            
        }
    }
}

// Brand

function brandAddCategoryFilter() {
    global $categories;

    echo '<label for="catForNewBrand">Choose a category:</label>
          <select id="catForNewBrand" name="catForNewBrand" required>';

    echo '<option value="" disabled selected>Select a category</option>';

    foreach($categories as $row) {
        ?>
          <option value="<?php echo $row['categoryName']; ?>"><?php echo $row['categoryName']; ?></option>
        <?php
    }

    echo '</select>';
}

function brandAdd() {
    global $pdo;
    global $categories;
    global $brands;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['brandName']) && isset($_POST['catForNewBrand'])) {

            $categoryID = "";
            
            foreach($categories as $row) {
                if ($_POST['catForNewBrand'] == $row['categoryName']) {
                    $categoryID = $row['categoryID'];
                }
            }
            
            $unique = true;

            foreach($brands as $row) {
                if ($_POST['brandName'] == $row['brandName'] && $categoryID == $row['categoryID']) {
                    $unique = false;
                }
            }

            if ($unique) {
                $sql = 'INSERT INTO brand (brandName, categoryID) VALUES (:brandName, :catID)';
    
                $statement = $pdo->prepare($sql);

                $statement->bindValue(':brandName', $_POST['brandName']);
                $statement->bindValue(':catID', $categoryID);
        
                $statement->execute();

                echo "<script>alert('A new brand " . $_POST['brandName'] . " is added successfully to " . $_POST['catForNewBrand'] . " category!')</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<p class='adminResult'>Failed: brand already exists in the same category</p>";
            }
        }
    }
}

function brandUpdateFilter() {
    global $brands;

    echo '<div class="adminForm">
            <label for="brandToUpdate">Choose a brand:</label>
            <select id="brandToUpdate" name="brandToUpdate" required>';

    echo '<option value="" disabled selected>Select a brand</option>';

    foreach($brands as $row) {
        ?>
          <option value="<?php echo $row['brandName']; ?>"><?php echo $row['brandName']; ?></option>
        <?php
    }

    echo '</select></div>';

    global $categories;

    echo '<div class="adminForm">
            <label for="newCat">Choose a category:</label>
            <select id="newCat" name="newCat">';

    echo '<option value="" selected>No change</option>';

    foreach($categories as $row) {
        ?>
          <option value="<?php echo $row['categoryName']; ?>"><?php echo $row['categoryName']; ?></option>
        <?php
    }

    echo '</select></div>';

}

function brandUpdate() {
    global $pdo;
    global $categories;
    global $brands;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['brandToUpdate']) && isset($_POST['newCat']) && isset($_POST['newBrandName'])) {
            
            if ($_POST['newCat'] == "" && $_POST['newBrandName'] == "") {
                echo "<p class='adminResult'>No change is made to the brand you selected</p>";
            }
            else if ($_POST['newCat'] == "") {
                $categoryID = "";
            
                foreach($brands as $row) {
                    if ($_POST['brandToUpdate'] == $row['brandName']) {
                        $categoryID = $row['categoryID'];
                    }
                }

                $unique = true;

                foreach($brands as $row) {
                    if ($_POST['newBrandName'] == $row['brandName'] && $categoryID == $row['categoryID']) {
                        $unique = false;
                    }
                }

                if($unique) {
                    $sql = 'UPDATE brand SET brandName = :newBrandName WHERE brandName = :brandToUpdate';

                    $statement = $pdo->prepare($sql);

                    $statement->bindValue(':newBrandName', $_POST['newBrandName']);
                    $statement->bindValue(':brandToUpdate', $_POST['brandToUpdate']);
                
                    $statement->execute();

                    echo '<script>alert("Brand name is updated successfully: ' . $_POST['newBrandName'] . '");</script>';
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                else {
                    echo "<p class='adminResult'>Failed: this brand name already exists in the same category</p>";
                }
                
            }
            else if ($_POST['newBrandName'] == "") {
                $sql = 'UPDATE brand SET categoryID = :newCatID WHERE brandName = :brandToUpdate';

                $newCatID = "";

                foreach($categories as $row) {
                    if ($_POST['newCat'] == $row['categoryName']) {
                        $newCatID = $row['categoryID'];
                    }
                }

                $statement = $pdo->prepare($sql);

                $statement->bindValue(':newCatID', $newCatID);
                $statement->bindValue(':brandToUpdate', $_POST['brandToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Brand category of ' . $_POST['brandToUpdate'] . ' is updated successfully: ' . $_POST['newCat'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                $categoryID = "";
            
                foreach($categories as $row) {
                    if ($_POST['newCat'] == $row['categoryName']) {
                        $categoryID = $row['categoryID'];
                    }
                }

                $unique = true;

                foreach($brands as $row) {
                    if ($_POST['newBrandName'] == $row['brandName'] && $categoryID == $row['categoryID']) {
                        $unique = false;
                    }
                }

                if ($unique) {
                    $sql = 'UPDATE brand SET brandName = :newBrandName, categoryID = :newCatID WHERE brandName = :brandToUpdate';

                    $newCatID = "";

                    foreach($categories as $row) {
                        if ($_POST['newCat'] == $row['categoryName']) {
                            $newCatID = $row['categoryID'];
                        }
                    }

                    $statement = $pdo->prepare($sql);

                    $statement->bindValue(':newBrandName', $_POST['newBrandName']);
                    $statement->bindValue(':newCatID', $newCatID);
                    $statement->bindValue(':brandToUpdate', $_POST['brandToUpdate']);
                
                    $statement->execute();

                    echo '<script>alert("Brand is updated successfully!\nName: ' . $_POST['newBrandName'] . '\nCategory: ' . $_POST['newCat'] . '");</script>';
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                else {
                    echo "<p class='adminResult'>Failed: this brand name already exists in the same category</p>";
                }
                
            }
            
        }
    }
}

function brandDeleteFilter() {
    
    global $brands;

    echo '<label for="brandToDelete">Choose a brand:</label>
          <select id="brandToDelete" name="brandToDelete" required>';

    echo '<option value="" disabled selected>Select a brand</option>';

    foreach($brands as $row) {
        ?>
          <option value="<?php echo $row['brandName']; ?>"><?php echo $row['brandName']; ?></option>
        <?php
    }

    echo '</select>';
}

function brandDelete() {
    global $pdo;
    global $items;
    global $brands;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['brandToDelete'])) {

            $brandID = "";

            foreach($brands as $row) {
                if ($_POST['brandToDelete'] == $row['brandName']) {
                    $brandID = $row['brandID'];
                }
            }

            $hasItems = false;

            foreach($items as $row) {
                if ($brandID == $row['brandID']) {
                    $hasItems = true;
                }
            }

            if ($hasItems) {
                echo "<p class='adminResult'>Failed to delete brand: " . $_POST['brandToDelete'] . " (Please delete associated items first)</p>";
            }
            else {
                $sql = 'DELETE FROM brand WHERE brandName = :brandToDelete';
    
                $statement = $pdo->prepare($sql);
    
                $statement->bindValue(':brandToDelete', $_POST['brandToDelete']);
            
                $statement->execute();
    
                echo "<script>alert('Brand is deleted successfully: " . $_POST['brandToDelete'] . "')</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            
        }
    }
}

// Chain

function chainAdd() {
    global $pdo;
    global $chains;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['chainName'])) {
            
            $unique = true;

            foreach($chains as $row) {
                if ($_POST['chainName'] == $row['chainName']) {
                    $unique = false;
                }
            }

            if ($unique) {
                $sql = 'INSERT INTO chain (chainName) VALUES (:chainName)';
    
                $statement = $pdo->prepare($sql);

                $statement->bindValue(':chainName', $_POST['chainName']);
        
                $statement->execute();

                echo "<script>alert('A new chain " . $_POST['chainName'] . " is added successfully!')</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<p class='adminResult'>Failed: chain already exists</p>";
            }
        }
    }
}

function chainUpdateFilter() {
    
    global $chains;

    echo '<label for="chainToUpdate">Choose a chain:</label>
          <select id="chainToUpdate" name="chainToUpdate" required>';

    echo '<option value="" disabled selected>Select a chain</option>';

    foreach($chains as $row) {
        ?>
          <option value="<?php echo $row['chainName']; ?>"><?php echo $row['chainName']; ?></option>
        <?php
    }

    echo '</select>';
}

function chainUpdate() {
    global $pdo;
    global $chains;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['chainToUpdate']) && isset($_POST['newChainName'])) {
            $unique = true;

            foreach($chains as $row) {
                if ($_POST['newChainName'] == $row['chainName']) {
                    $unique = false;
                }
            }

            if($unique) {
                $sql = 'UPDATE chain SET chainName = :newChainName WHERE chainName = :chainToUpdate';
    
                $statement = $pdo->prepare($sql);

                $statement->bindValue(':newChainName', $_POST['newChainName']);
                $statement->bindValue(':chainToUpdate', $_POST['chainToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Chain is updated successfully: ' . $_POST['newChainName'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<p class='adminResult'>Failed: this chain name already exists</p>";
            }
            
            
            
        }
    }
}

function chainDeleteFilter() {
    
    global $chains;

    echo '<label for="chainToDelete">Choose a chain:</label>
          <select id="chainToDelete" name="chainToDelete" required>';

    echo '<option value="" disabled selected>Select a chain</option>';

    foreach($chains as $row) {
        ?>
          <option value="<?php echo $row['chainName']; ?>"><?php echo $row['chainName']; ?></option>
        <?php
    }

    echo '</select>';
}

function chainDelete() {
    global $pdo;
    global $chains;
    global $stores;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['chainToDelete'])) {

            $chainID = "";

            foreach($chains as $row) {
                if ($_POST['chainToDelete'] == $row['chainName']) {
                    $chainID = $row['chainID'];
                }
            }

            $hasStores = false;

            foreach($stores as $row) {
                if ($chainID == $row['chainID']) {
                    $hasStores = true;
                }
            }

            if ($hasStores) {
                echo "<p class='adminResult'>Failed to delete chain: " . $_POST['chainToDelete'] . " (Please delete associated stores first)</p>";
            }
            else {
                $sql = 'DELETE FROM chain WHERE chainName = :chainToDelete';
    
                $statement = $pdo->prepare($sql);
    
                $statement->bindValue(':chainToDelete', $_POST['chainToDelete']);
            
                $statement->execute();
    
                echo "<script>alert('Chain is deleted successfully: " . $_POST['chainToDelete'] . "')</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            
        }
    }
}

// Item

function itemAddBrandFilter() {
    global $brands;

    echo '<label for="brandForNewItem">Choose a brand:</label>
          <select id="brandForNewItem" name="brandForNewItem" required>';

    echo '<option value="" disabled selected>Select a brand</option>';

    foreach($brands as $row) {
        ?>
          <option value="<?php echo $row['brandName']; ?>"><?php echo $row['brandName']; ?></option>
        <?php
    }

    echo '</select>';
}

function itemAdd() {
    global $pdo;
    global $items;
    global $brands;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['itemName']) && isset($_POST['brandForNewItem'])) {

            $brandID = "";
            
            foreach($brands as $row) {
                if ($_POST['brandForNewItem'] == $row['brandName']) {
                    $brandID = $row['brandID'];
                }
            }
            
            $unique = true;

            foreach($items as $row) {
                if ($_POST['itemName'] == $row['itemName'] && $brandID == $row['brandID']) {
                    $unique = false;
                }
            }

            if ($unique) {
                $sql = 'INSERT INTO item (itemName, brandID) VALUES (:itemName, :brandID)';
    
                $statement = $pdo->prepare($sql);

                $statement->bindValue(':itemName', $_POST['itemName']);
                $statement->bindValue(':brandID', $brandID);
        
                $statement->execute();

                echo '<script>alert("Item is added successfully!\nName: ' . $_POST['itemName'] . '\nBrand: ' . $_POST['brandForNewItem'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<p class='adminResult'>Failed: item already exists in the same brand</p>";
            }
        }
    }
}

function itemUpdateFilter() {
    global $items;

    echo '<div class="adminForm">
            <label for="itemToUpdate">Choose a item:</label>
            <select id="itemToUpdate" name="itemToUpdate" required>';

    echo '<option value="" disabled selected>Select an item</option>';

    foreach($items as $row) {
        ?>
          <option value="<?php echo $row['itemName']; ?>"><?php echo $row['itemName']; ?></option>
        <?php
    }

    echo '</select></div>';

    global $brands;

    echo '<div class="adminForm">
            <label for="newBrand">Choose a brand:</label>
            <select id="newBrand" name="newBrand">';

    echo '<option value="" selected>No change</option>';

    foreach($brands as $row) {
        ?>
          <option value="<?php echo $row['brandName']; ?>"><?php echo $row['brandName']; ?></option>
        <?php
    }

    echo '</select></div>';

}

function itemUpdate() {
    global $pdo;
    global $items;
    global $brands;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['itemToUpdate']) && isset($_POST['newBrand']) && isset($_POST['newItemName'])) {
            
            if ($_POST['newBrand'] == "" && $_POST['newItemName'] == "") {
                echo "<p class='adminResult'>No change is made to the item you selected</p>";
            }
            else if ($_POST['newBrand'] == "") {
                $brandID = "";
            
                foreach($items as $row) {
                    if ($_POST['itemToUpdate'] == $row['itemName']) {
                        $brandID = $row['brandID'];
                    }
                }
                
                $unique = true;

                foreach($items as $row) {
                    if ($_POST['newItemName'] == $row['itemName'] && $brandID == $row['brandID']) {
                        $unique = false;
                    }
                }

                if ($unique) {
                    $sql = 'UPDATE item SET itemName = :newItemName WHERE itemName = :itemToUpdate';

                    $statement = $pdo->prepare($sql);

                    $statement->bindValue(':newItemName', $_POST['newItemName']);
                    $statement->bindValue(':itemToUpdate', $_POST['itemToUpdate']);
                
                    $statement->execute();

                    echo '<script>alert("Item name is updated successfully: ' . $_POST['newItemName'] . '");</script>';
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                else {
                    echo "<p class='adminResult'>Failed: this item name already exists in the same brand</p>";
                }

                
            }
            else if ($_POST['newItemName'] == "") {
                $sql = 'UPDATE item SET brandID = :newBrandID WHERE itemName = :itemToUpdate';

                $newBrandID = "";

                foreach($brands as $row) {
                    if ($_POST['newBrand'] == $row['brandName']) {
                        $newBrandID = $row['brandID'];
                    }
                }

                $statement = $pdo->prepare($sql);

                $statement->bindValue(':newBrandID', $newBrandID);
                $statement->bindValue(':itemToUpdate', $_POST['itemToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Item brand of ' . $_POST['itemToUpdate'] . ' is updated successfully: ' . $_POST['newBrand'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                
                $brandID = "";
                
                foreach($brands as $row) {
                    if ($_POST['newBrand'] == $row['brandName']) {
                        $brandID = $row['brandID'];
                    }
                }
                
                $unique = true;

                foreach($items as $row) {
                    if ($_POST['newItemName'] == $row['itemName'] && $brandID == $row['brandID']) {
                        $unique = false;
                    }
                }

                if ($unique) {
                    $sql = 'UPDATE item SET itemName = :newItemName, brandID = :newBrandID WHERE itemName = :itemToUpdate';

                    $newBrandID = "";

                    foreach($brands as $row) {
                        if ($_POST['newBrand'] == $row['brandName']) {
                            $newBrandID = $row['brandID'];
                        }
                    }

                    $statement = $pdo->prepare($sql);

                    $statement->bindValue(':newItemName', $_POST['newItemName']);
                    $statement->bindValue(':newBrandID', $newBrandID);
                    $statement->bindValue(':itemToUpdate', $_POST['itemToUpdate']);
                
                    $statement->execute();

                    echo '<script>alert("Item is updated successfully!\nName: ' . $_POST['newItemName'] . '\nBrand: ' . $_POST['newBrand'] . '");</script>';
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                else {
                    echo "<p class='adminResult'>Failed: this item name already exists in the same brand</p>";
                }

                
            }
            
        }
    }
}

function itemDeleteFilter() {
    
    global $items;

    echo '<label for="itemToDelete">Choose a item:</label>
          <select id="itemToDelete" name="itemToDelete" required>';

    echo '<option value="" disabled selected>Select an item</option>';

    foreach($items as $row) {
        ?>
          <option value="<?php echo $row['itemName']; ?>"><?php echo $row['itemName']; ?></option>
        <?php
    }

    echo '</select>';
}

function itemDelete() {
    global $pdo;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['itemToDelete'])) {

            $sql = 'DELETE FROM item WHERE itemName = :itemToDelete';
    
            $statement = $pdo->prepare($sql);
    
            $statement->bindValue(':itemToDelete', $_POST['itemToDelete']);
            
            $statement->execute();
    
            echo "<script>alert('Item is deleted successfully: " . $_POST['itemToDelete'] . "')</script>";
            echo "<meta http-equiv='refresh' content='0'>";
            
        }
    }
}

// Store

function storeAddChainFilter() {
    global $chains;

    echo '<label for="chainForNewStore">Choose a chain:</label>
          <select id="chainForNewStore" name="chainForNewStore" required>';

    echo '<option value="" disabled selected>Select a chain</option>';

    foreach($chains as $row) {
        ?>
          <option value="<?php echo $row['chainName']; ?>"><?php echo $row['chainName']; ?></option>
        <?php
    }

    echo '</select>';
}

function storeAdd() {
    global $pdo;
    global $stores;
    global $chains;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['newStoreName']) && isset($_POST['chainForNewStore']) && isset($_POST['newStoreAddress'])) {

            $chainID = "";
            
            foreach($chains as $row) {
                if ($_POST['chainForNewStore'] == $row['chainName']) {
                    $chainID = $row['chainID'];
                }
            }
            
            $unique = true;

            foreach($stores as $row) {
                if ($_POST['newStoreName'] == $row['storeName'] && $chainID == $row['chainID']) {
                    $unique = false;
                }
            }

            if ($unique) {
                $sql = 'INSERT INTO store (storeName, address, chainID) VALUES (:newStoreName, :newStoreAddress, :chainID)';
    
                $statement = $pdo->prepare($sql);

                $statement->bindValue(':newStoreName', $_POST['newStoreName']);
                $statement->bindValue(':newStoreAddress', $_POST['newStoreAddress']);
                $statement->bindValue(':chainID', $chainID);
        
                $statement->execute();

                echo '<script>alert("Store is added successfully!\nName: ' . $_POST['newStoreName'] . '\nAddress: ' . $_POST['newStoreAddress'] . '\nChain: ' . $_POST['chainForNewStore'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<p class='adminResult'>Failed: store already exists in the same chain</p>";
            }
        }
    }
}

function storeUpdateFilter() {
    global $stores;

    echo '<div class="adminForm">
            <label for="storeToUpdate">Choose a store:</label>
            <select id="storeToUpdate" name="storeToUpdate" required>';

    echo '<option value="" disabled selected>Select a store</option>';

    foreach($stores as $row) {
        ?>
          <option value="<?php echo $row['storeName']; ?>"><?php echo $row['storeName']; ?></option>
        <?php
    }

    echo '</select></div>';

    global $chains;

    echo '<div class="adminForm">
            <label for="updateChainName">Choose a chain:</label>
            <select id="updateChainName" name="updateChainName">';

    echo '<option value="" selected>(No change)</option>';

    foreach($chains as $row) {
        ?>
          <option value="<?php echo $row['chainName']; ?>"><?php echo $row['chainName']; ?></option>
        <?php
    }

    echo '</select></div>';

}

function storeUpdate() {
    global $pdo;
    global $chains;
    global $stores;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['storeToUpdate']) && isset($_POST['updateChainName']) && isset($_POST['updateStoreName']) && isset($_POST['updateStoreAddress'])) {
            
            if ($_POST['updateChainName'] == "" && $_POST['updateStoreName'] == "" && $_POST['updateStoreAddress'] == "") {
                echo "<p class='adminResult'>No change is made to the store you selected</p>";
            }
            else if ($_POST['updateStoreName'] == "" && $_POST['updateStoreAddress'] == "") {
                $sql = 'UPDATE store SET chainID = :newChainID WHERE storeName = :storeToUpdate';

                $newChainID = "";

                foreach($chains as $row) {
                    if ($_POST['updateChainName'] == $row['chainName']) {
                        $newChainID = $row['chainID'];
                    }
                }

                $statement = $pdo->prepare($sql);

                $statement->bindValue(':newChainID', $newChainID);
                $statement->bindValue(':storeToUpdate', $_POST['storeToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Store is updated successfully: \nName: ' . $_POST['storeToUpdate'] . '\nChain: ' . $_POST['updateChainName'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else if ($_POST['updateChainName'] == "" && $_POST['updateStoreAddress'] == "") {
                $chainID = "";
            
                foreach($stores as $row) {
                    if ($_POST['storeToUpdate'] == $row['storeName']) {
                        $chainID = $row['chainID'];
                    }
                }
                
                $unique = true;

                foreach($stores as $row) {
                    if ($_POST['updateStoreName'] == $row['storeName'] && $chainID == $row['chainID']) {
                        $unique = false;
                    }
                }

                if ($unique) {
                    $sql = 'UPDATE store SET storeName = :updateStoreName WHERE storeName = :storeToUpdate';

                    $statement = $pdo->prepare($sql);
    
                    $statement->bindValue(':updateStoreName', $_POST['updateStoreName']);
                    $statement->bindValue(':storeToUpdate', $_POST['storeToUpdate']);
                
                    $statement->execute();
    
                    echo '<script>alert("Store is updated successfully: \nOriginal name: ' . $_POST['storeToUpdate'] . '\nNew name: ' . $_POST['updateStoreName'] . '");</script>';
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                else {
                    echo "<p class='adminResult'>Failed: this store name already exists in the same chain</p>";
                }

                
            }
            else if ($_POST['updateChainName'] == "" && $_POST['updateStoreName'] == "") {
                $sql = 'UPDATE store SET address = :updateStoreAddress WHERE storeName = :storeToUpdate';

                $statement = $pdo->prepare($sql);

                $statement->bindValue(':updateStoreAddress', $_POST['updateStoreAddress']);
                $statement->bindValue(':storeToUpdate', $_POST['storeToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Store is updated successfully: \nName: ' . $_POST['storeToUpdate'] . '\nNew Address: ' . $_POST['updateStoreAddress'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else if ($_POST['updateChainName'] == "") {
                $chainID = "";
            
                foreach($stores as $row) {
                    if ($_POST['storeToUpdate'] == $row['storeName']) {
                        $chainID = $row['chainID'];
                    }
                }
                
                $unique = true;

                foreach($stores as $row) {
                    if ($_POST['updateStoreName'] == $row['storeName'] && $chainID == $row['chainID']) {
                        $unique = false;
                    }
                }

                if ($unique) {
                    $sql = 'UPDATE store SET storeName = :updateStoreName, address = :updateStoreAddress WHERE storeName = :storeToUpdate';

                    $statement = $pdo->prepare($sql);
    
                    $statement->bindValue(':updateStoreName', $_POST['updateStoreName']);
                    $statement->bindValue(':updateStoreAddress', $_POST['updateStoreAddress']);
                    $statement->bindValue(':storeToUpdate', $_POST['storeToUpdate']);
                
                    $statement->execute();
    
                    echo '<script>alert("Store is updated successfully: \nName: ' . $_POST['updateStoreName'] . '\nAddress: ' . $_POST['updateStoreAddress'] . '");</script>';
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                else {
                    echo "<p class='adminResult'>Failed: this store name already exists in the same chain</p>";
                }
                
            }
            else if ($_POST['updateStoreName'] == "") {
                $sql = 'UPDATE store SET chainID = :newChainID, address = :updateStoreAddress WHERE storeName = :storeToUpdate';

                $newChainID = "";

                foreach($chains as $row) {
                    if ($_POST['updateChainName'] == $row['chainName']) {
                        $newChainID = $row['chainID'];
                    }
                }

                $statement = $pdo->prepare($sql);

                $statement->bindValue(':newChainID', $newChainID);
                $statement->bindValue(':updateStoreAddress', $_POST['updateStoreAddress']);
                $statement->bindValue(':storeToUpdate', $_POST['storeToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Store is updated successfully: \nName: ' . $_POST['storeToUpdate'] . '\nChain: ' . $_POST['updateChainName'] . '\nAddress: ' . $_POST['updateStoreAddress'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else if ($_POST['updateStoreAddress'] == "") {
                $sql = 'UPDATE store SET storeName = :updateStoreName, chainID = :newChainID WHERE storeName = :storeToUpdate';

                $newChainID = "";

                foreach($chains as $row) {
                    if ($_POST['updateChainName'] == $row['chainName']) {
                        $newChainID = $row['chainID'];
                    }
                }

                $statement = $pdo->prepare($sql);

                $statement->bindValue(':updateStoreName', $_POST['updateStoreName']);
                $statement->bindValue(':newChainID', $newChainID);
                $statement->bindValue(':storeToUpdate', $_POST['storeToUpdate']);
            
                $statement->execute();

                echo '<script>alert("Store is updated successfully: \nName: ' . $_POST['updateStoreName'] . '\nChain: ' . $_POST['updateChainName'] . '");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                $chainID = "";
            
                foreach($chains as $row) {
                    if ($_POST['updateChainName'] == $row['chainName']) {
                        $chainID = $row['chainID'];
                    }
                }
                
                $unique = true;

                foreach($stores as $row) {
                    if ($_POST['updateStoreName'] == $row['storeName'] && $chainID == $row['chainID']) {
                        $unique = false;
                    }
                }

                if ($unique) {
                    $sql = 'UPDATE store SET storeName = :updateStoreName, chainID = :newChainID, address = :updateStoreAddress WHERE storeName = :storeToUpdate';

                    $newChainID = "";
    
                    foreach($chains as $row) {
                        if ($_POST['updateChainName'] == $row['chainName']) {
                            $newChainID = $row['chainID'];
                        }
                    }
    
                    $statement = $pdo->prepare($sql);
    
                    $statement->bindValue(':updateStoreName', $_POST['updateStoreName']);
                    $statement->bindValue(':newChainID', $newChainID);
                    $statement->bindValue(':updateStoreAddress', $_POST['updateStoreAddress']);
                    $statement->bindValue(':storeToUpdate', $_POST['storeToUpdate']);
                
                    $statement->execute();
    
                    echo '<script>alert("Item is updated successfully!\nOriginal name: ' . $_POST['storeToUpdate'] . '\nNew name: ' . $_POST['updateStoreName'] . '\nChain: ' . $_POST['updateChainName'] . '\nAddress: ' . $_POST['updateStoreAddress'] . '");</script>';
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                else {
                    echo "<p class='adminResult'>Failed: this store name already exists in the same chain</p>";
                }
                
            }
            
        }
    }
}

function storeDeleteFilter() {
    global $stores;

    echo '<label for="storeToDelete">Choose a store:</label>
          <select id="storeToDelete" name="storeToDelete" required>';

    echo '<option value="" disabled selected>Select a store</option>';

    foreach($stores as $row) {
        ?>
          <option value="<?php echo $row['storeName']; ?>"><?php echo $row['storeName']; ?></option>
        <?php
    }

    echo '</select>';
}

function storeDelete() {
    global $pdo;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['storeToDelete'])) {

            $sql = 'DELETE FROM store WHERE storeName = :storeToDelete';
    
            $statement = $pdo->prepare($sql);
    
            $statement->bindValue(':storeToDelete', $_POST['storeToDelete']);
            
            $statement->execute();
    
            echo "<script>alert('Store is deleted successfully: " . $_POST['storeToDelete'] . "')</script>";
            echo "<meta http-equiv='refresh' content='0'>";
            
        }
    }
}

// Report

function showAdminReport() {
    global $results;
    global $stores;
    global $items;

    if (isset($_GET['item']) && isset($_GET['category']) && isset($_GET['brand']) && isset($_GET['chain'])) {

        if (count($results) == 0) {
            echo "No results.";
        }
        else {
            foreach ($results as $row) {
                ?>
                    <form action="report.php" method="POST">
                        <div class="adminSearchResult">
                            <div class="reportID">
                                <i class="fa-solid fa-hashtag"></i>
                                <input type="number" class="adminReportID" name="adminReportID" value="<?php echo $row['reportID']; ?>" readonly>
                            </div>
                            <div class="itemname">
                                <i class="fa-solid fa-barcode"></i> 
                                <select name="adminReportItem">
                                    <option value="<?php echo $row['itemName']; ?>" selected><?php echo $row['itemName']; ?></option>
                                    <?php
                                        foreach($items as $itemRow) {
                                            if ($row['itemName'] != $itemRow['itemName']) {
                                                ?>
                                                    <option value="<?php echo $itemRow['itemName']?>"><?php echo $itemRow['itemName']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="price">
                                <i class="fa-solid fa-comment-dollar"></i>
                                <input type="number" name="adminReportPrice" value="<?php echo $row['price']; ?>" min="0.1" max="100" step=".01">
                            </div>
                            <div class="store">
                                <i class="fa-solid fa-location-dot"></i>
                                <select name="adminReportStore">
                                    <option value="<?php echo $row['storeName']; ?>" selected><?php echo $row['storeName']; ?></option>
                                    <?php
                                        foreach($stores as $storeRow) {
                                            if ($row['storeName'] != $storeRow['storeName']) {
                                                ?>
                                                    <option value="<?php echo $storeRow['storeName']?>"><?php echo $storeRow['storeName']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="actionBtn">
                                <input type="submit" name="reportEdit" value="Edit"></button>
                                <input type="submit" name="reportDelete" value="Delete"></button>
                            </div>
                        </div><br>
                    </form>
                <?php
            }
        }

    }
}

function adminReportAction() {
    global $pdo;
    global $items;
    global $stores;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['reportEdit'])) {
            $sql = 'UPDATE report SET itemID = :itemID, price = :price, storeID = :storeID, date = :date, time = :time WHERE reportID = :reportID';

            $itemID = "";
            $storeID = "";

            foreach($items as $row) {
                if ($_POST['adminReportItem'] == $row['itemName']) {
                    $itemID = $row['itemID'];
                }
            }

            foreach($stores as $row) {
                if ($_POST['adminReportStore'] == $row['storeName']) {
                    $storeID = $row['storeID'];
                }
            }
    
            $statement = $pdo->prepare($sql);
            
            $statement->bindValue(':itemID', $itemID);
            $statement->bindValue(':price', $_POST['adminReportPrice']);
            $statement->bindValue(':storeID', $storeID);
            $statement->bindValue(':reportID', $_POST['adminReportID']);
            $statement->bindValue(':date', date('Y-m-d'));
            $statement->bindValue(':time', date('H:i:s'));
            
            $statement->execute();
            
            echo '<script>alert("Report is updated successfully!\nID: ' . $_POST['adminReportID'] . '\nItem: ' . $_POST['adminReportItem'] . '\nPrice: ' . $_POST['adminReportPrice'] . '\nStore: ' . $_POST['adminReportStore'] . '")</script>';
            echo "<meta http-equiv='refresh' content='0'>";
        }
        else if (isset($_POST['reportDelete'])) {
            $sql = 'DELETE FROM report WHERE reportID = :reportID';
    
            $statement = $pdo->prepare($sql);
    
            $statement->bindValue(':reportID', $_POST['adminReportID']);
            
            $statement->execute();
    
            echo "<script>alert('Report is deleted successfully! ID: " . $_POST['adminReportID'] . "')</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}

// Login validation

function loginValidation() {
    global $users;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $userFound = false;

            foreach ($users as $row) {
                if ($_POST['username'] == $row['username'] && $_POST['password'] == $row['password']) {
                    setcookie("login", $_POST['username'], time() + 3600);
                    $userFound = true;
                }
            }

            if($userFound) {
                echo '<script>alert("Login success! Welcome back.")</script>';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo '<p style="color: red; font-size: small">Login failed! Please double check your username or password.</p>';
            }
        }
    }
}

// Create user

function userCreateValidation() {
    global $pdo;
    global $users;

    $valid = true;
    $errorMessage = '<div id="userCreateErrorResult"><br>Fail to create user:<ul>';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['usernameCreate']) && isset($_POST['passwordCreate'])) {

            // Check if username is unique
            $uniqueUsername = true;
            foreach ($users as $row) {
                if ($_POST['usernameCreate'] == $row['username']) {
                    $uniqueUsername = false;
                    $valid = false;
                }
            }
            if ($uniqueUsername == false) {
                $errorMessage .= '<li>Username is duplicated. Please think of another one.</li>';
            }

            // Check if username length is valid
            if (strlen($_POST['usernameCreate']) < 5 || strlen($_POST['usernameCreate']) > 20) {
                $valid = false;
                $errorMessage .= '<li>Username should at least have 5 - 20 characters.</li>';
            }
            
            // Check if username has any special characters
            $noSpecialChar = true;
            foreach (str_split($_POST['usernameCreate']) as $char) {
                if (!preg_match('/[a-zA-Z]|[0-9]/', $char)) {
                    $valid = false;
                    $noSpecialChar = false;
                }
            }
            if ($noSpecialChar == false) {
                $errorMessage .= '<li>Username should not contain any special characters.</li>';
            }

            // Check if password length is valid
            if (strlen($_POST['passwordCreate']) < 8 || strlen($_POST['passwordCreate']) > 20) {
                $valid = false;
                $errorMessage .= '<li>Password should at least have 8 - 20 characters.</li>';
            }

            // Check if password has enough required characters
            $letterCount = $digitCount = $spCount = 0;
            $noOtherSpChar = true;
            foreach (str_split($_POST['passwordCreate']) as $char) {
                if (preg_match('/[a-zA-Z]/', $char)) {
                    $letterCount++;
                }
                else if (preg_match('/[0-9]/', $char)) {
                    $digitCount++;
                }
                else if (preg_match('/[@$\*!]/', $char)) {
                    $spCount++;
                }
                else {
                    $noOtherSpChar = false;
                }
            }
            if ($letterCount == 0) {
                $valid = false;
                $errorMessage .= '<li>Password should at least have one alphabet character (a-zA-z).</li>';
            }
            if ($digitCount == 0) {
                $valid = false;
                $errorMessage .= '<li>Password should at least have one digit character (0-9).</li>';
            }
            if ($spCount == 0) {
                $valid = false;
                $errorMessage .= '<li>Password should at least have one special character (@, $, *, !).</li>';
            }
            if ($noOtherSpChar == false) {
                $errorMessage .= '<li>Password should not contain special characters other than the following: (@, $, *, !).</li>';
            }
        }

        if ($valid) {
            $sql = 'INSERT INTO user (username, password, isAdmin) VALUES (:usernameCreate, :passwordCreate, 0)';
    
            $statement = $pdo->prepare($sql);

            $statement->bindValue(':usernameCreate', $_POST['usernameCreate']);
            $statement->bindValue(':passwordCreate', $_POST['passwordCreate']);
        
            $statement->execute();

            echo '<div id="userCreateSuccessResult" style="font-size: small; color: limegreen">
                    <br>User is successfully created: ' . $_POST['usernameCreate'] . '
                  </div>';
        }
        else {
            $errorMessage .= '</ul></div>';
            echo $errorMessage;
        }
    }
}

// Logout button

function logout() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['logout'])) {
            setcookie("login", "", time() - 3600);
            echo '<script>alert("You have successfully logged out!");</script>';
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}

// Check if user is admin or not

function isAdmin($username) {
    global $users;
    foreach ($users as $user) {
        if ($user['username'] == $username) {
            if ($user['isAdmin'] == 1) {
                return true;
            }
            else {
                return false;
            }
        }
    }
}

// User functions

$userResults = [];

function handleUserSearch() {
    global $pdo;
    global $userResults;
  
        if (isset($_GET['item']) && isset($_GET['category']) && isset($_GET['brand']) && isset($_GET['chain'])) {

            $category = $brand = $chain = "";

            if ($_GET['category'] != "All") {
                $category = "AND categoryName = '" . $_GET['category'] . "' ";
            }
            if ($_GET['brand'] != "All") {
                $brand = "AND brandName = '" . $_GET['brand'] . "' ";
            }
            if ($_GET['chain'] != "All") {
                $chain = "AND chainName = '" . $_GET['chain'] . "' ";
            }
            
            $sql = "SELECT reportID, date, time, username, categoryName, brandName, itemName, price, storeName
                    FROM report
                    INNER JOIN item ON report.itemID = item.itemID
                    INNER JOIN store ON report.storeID = store.storeID
                    INNER JOIN brand ON item.brandID = brand.brandID
                    INNER JOIN category ON brand.categoryID = category.categoryID
                    INNER JOIN chain ON store.chainID = chain.chainID
                    INNER JOIN user ON report.userID = user.userID
                    WHERE itemName LIKE '%" . $_GET['item'] . "%'
                    AND username = '" . $_COOKIE['login'] . "' " . $category . $brand . $chain ."
                    ORDER BY date DESC, time DESC ";

            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                $userResults[] = $row;
            }
        }
        else {
            $sql = "SELECT reportID, date, time, username, categoryName, brandName, itemName, price, storeName
                    FROM report
                    INNER JOIN item ON report.itemID = item.itemID
                    INNER JOIN store ON report.storeID = store.storeID
                    INNER JOIN brand ON item.brandID = brand.brandID
                    INNER JOIN category ON brand.categoryID = category.categoryID
                    INNER JOIN chain ON store.chainID = chain.chainID
                    INNER JOIN user ON report.userID = user.userID
                    WHERE username = '" . $_COOKIE['login'] . "'
                    ORDER BY date DESC, time DESC ";
            
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                $userResults[] = $row;
            }
        }
    
}

function showUserReport() {
    global $userResults;
    global $stores;
    global $items;

    if (isset($_GET['item']) && isset($_GET['category']) && isset($_GET['brand']) && isset($_GET['chain'])) {

        if (count($userResults) == 0) {
            echo "<p>No results.</p><br>";
        }
        else {
            foreach ($userResults as $row) {
                ?>
                    <form action="report.php" method="POST">
                        <div class="userSearchResult">
                            <div class="reportID">
                                <i class="fa-solid fa-hashtag"></i>
                                <input type="number" class="adminReportID" name="adminReportID" value="<?php echo $row['reportID']; ?>" readonly>
                            </div>
                            <div class="itemname">
                                <i class="fa-solid fa-barcode"></i> 
                                <select name="adminReportItem">
                                    <option value="<?php echo $row['itemName']; ?>" selected><?php echo $row['itemName']; ?></option>
                                    <?php
                                        foreach($items as $itemRow) {
                                            if ($row['itemName'] != $itemRow['itemName']) {
                                                ?>
                                                    <option value="<?php echo $itemRow['itemName']?>"><?php echo $itemRow['itemName']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="price">
                                <i class="fa-solid fa-comment-dollar"></i>
                                <input type="number" name="adminReportPrice" value="<?php echo $row['price']; ?>" min="0.1" max="100" step=".01">
                            </div>
                            <div class="store">
                                <i class="fa-solid fa-location-dot"></i>
                                <select name="adminReportStore">
                                    <option value="<?php echo $row['storeName']; ?>" selected><?php echo $row['storeName']; ?></option>
                                    <?php
                                        foreach($stores as $storeRow) {
                                            if ($row['storeName'] != $storeRow['storeName']) {
                                                ?>
                                                    <option value="<?php echo $storeRow['storeName']?>"><?php echo $storeRow['storeName']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="actionBtn">
                                <input type="submit" name="reportEdit" value="Edit"></button>
                            </div>
                        </div><br>
                    </form>
                <?php
            }
            
        }

    }
    else {
        foreach (array_slice($userResults,0,10) as $row) {
            ?>
                <form action="report.php" method="POST">
                    <div class="userSearchResult">
                        <div class="reportID">
                            <i class="fa-solid fa-hashtag"></i>
                            <input type="number" class="adminReportID" name="adminReportID" value="<?php echo $row['reportID']; ?>" readonly>
                        </div>
                        <div class="itemname">
                            <i class="fa-solid fa-barcode"></i> 
                            <select name="adminReportItem">
                                <option value="<?php echo $row['itemName']; ?>" selected><?php echo $row['itemName']; ?></option>
                                <?php
                                    foreach($items as $itemRow) {
                                        if ($row['itemName'] != $itemRow['itemName']) {
                                            ?>
                                                <option value="<?php echo $itemRow['itemName']?>"><?php echo $itemRow['itemName']?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="price">
                            <i class="fa-solid fa-comment-dollar"></i>
                            <input type="number" name="adminReportPrice" value="<?php echo $row['price']; ?>" min="0.1" max="100" step=".01">
                        </div>
                        <div class="store">
                            <i class="fa-solid fa-location-dot"></i>
                            <select name="adminReportStore">
                                <option value="<?php echo $row['storeName']; ?>" selected><?php echo $row['storeName']; ?></option>
                                <?php
                                    foreach($stores as $storeRow) {
                                        if ($row['storeName'] != $storeRow['storeName']) {
                                            ?>
                                                <option value="<?php echo $storeRow['storeName']?>"><?php echo $storeRow['storeName']?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="actionBtn">
                            <input type="submit" name="reportEdit" value="Edit"></button>
                        </div>
                    </div><br>
                </form>
            <?php
        }
    }
}

// Change password function

function passwordValidation() {
    global $pdo;
    global $users;

    $valid = true;
    $errorMessage = '<div id="changePasswordErrorResult"><br>Fail to change password:<ul>';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['oldpassword']) && isset($_POST['newpassword'])) {

            // Check if old password is correct
            $correctPassword = true;
            foreach ($users as $row) {
                if ($_COOKIE['login'] == $row['username']) {
                    if ($row['password'] != $_POST['oldpassword']) {
                        $correctPassword = false;
                        $valid = false;
                    }
                }
            }
            if ($correctPassword == false) {
                $errorMessage .= '<li>Old password is not correct. Please double check your input.</li>';
            }

            // Check if password length is valid
            if (strlen($_POST['newpassword']) < 8 || strlen($_POST['newpassword']) > 20) {
                $valid = false;
                $errorMessage .= '<li>New password should at least have 8 - 20 characters.</li>';
            }

            // Check if password has enough required characters
            $letterCount = $digitCount = $spCount = 0;
            $noOtherSpChar = true;
            foreach (str_split($_POST['newpassword']) as $char) {
                if (preg_match('/[a-zA-Z]/', $char)) {
                    $letterCount++;
                }
                else if (preg_match('/[0-9]/', $char)) {
                    $digitCount++;
                }
                else if (preg_match('/[@$\*!]/', $char)) {
                    $spCount++;
                }
                else {
                    $noOtherSpChar = false;
                }
            }
            if ($letterCount == 0) {
                $valid = false;
                $errorMessage .= '<li>New password should at least have one alphabet character (a-zA-z).</li>';
            }
            if ($digitCount == 0) {
                $valid = false;
                $errorMessage .= '<li>New password should at least have one digit character (0-9).</li>';
            }
            if ($spCount == 0) {
                $valid = false;
                $errorMessage .= '<li>New password should at least have one special character (@, $, *, !).</li>';
            }
            if ($noOtherSpChar == false) {
                $errorMessage .= '<li>New password should not contain special characters other than the following: (@, $, *, !).</li>';
            }
        }

        // Check if old password and new password are the same
        if ($correctPassword && $_POST['oldpassword'] == $_POST['newpassword']) {
            $errorMessage .= '<li>New password cannot be the same as old password.</li>';
            $valid = false;
        }

        if ($valid) {
            $sql = 'UPDATE user SET password = :newpassword WHERE username = :username';
    
            $statement = $pdo->prepare($sql);

            $statement->bindValue(':newpassword', $_POST['newpassword']);
            $statement->bindValue(':username', $_COOKIE['login']);
        
            $statement->execute();

            echo '<div id="changePasswordSuccessResult" style="font-size: small; color: limegreen">
                    <br>Password is successfully updated!
                  </div><br>';
        }
        else {
            $errorMessage .= '</ul></div>';
            echo $errorMessage;
        }
    }
}

?>
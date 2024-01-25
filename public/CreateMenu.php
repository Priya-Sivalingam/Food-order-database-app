<?php
require "../config.php";
require "../common.php";

// Initialize variables
$foodItem = $price = $mealType = $cuisineType = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        // Initialize variables with form data
        $foodItem = $_POST['foodItem'];
        $price = $_POST['price'];
        $mealType = $_POST['mealType'];
        $cuisineType = $_POST['cuisineType'];

        // Start a transaction
        $connection->beginTransaction();

        // Execute the query to insert the menu item
       $insertMenuItemSql = "INSERT INTO menuitem (mealType, cuisineType, foodItem, price ) VALUES (:mealType, :cuisineType, :foodItem, :price)";
        $insertMenuItemStatement = $connection->prepare($insertMenuItemSql);
        $insertMenuItemStatement->execute([
            ':foodItem' => $foodItem,
            ':price' => $price,
            ':mealType' => $mealType,
            ':cuisineType' => $cuisineType
        ]);

        // Commit the transaction
        $connection->commit();

        echo "Menu Item added successfully.";
    } catch (PDOException $error) {
        $connection->rollback();
        echo "Transaction rolled back: " . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<h2>Add a Menu Item</h2>

<form method="post">
    <div class="form-box">
        <label for="foodItem">Food Item</label>
        <input type="text" name="foodItem" id="foodItem" required>
    </div>

    <div class="form-box">
        <label for="price">Price</label>
        <input type="text" name="price" id="price" required>
    </div>

    <div class="form-box">
        <label for="mealType">Meal Type</label>
        <input type="text" name="mealType" id="mealType" required>
    </div>

    <div class="form-box">
        <label for="cuisineType">Cuisine Type</label>
        <input type="text" name="cuisineType" id="cuisineType" required>
    </div>

    <div class="form-box">
        <input type="submit" name="submit" value="Submit">
    </div>
</form>

<a href="Menu.php">Back</a>

<?php require "templates/footer.php"; ?>

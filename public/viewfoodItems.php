<?php
require "templates/header.php";
require "../config.php";
require "../common.php";

if (isset($_GET['mealType']) && isset($_GET['cuisineType']) && isset($_GET['foodItem'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $mealType = $_GET['mealType'];
        $cuisineType = $_GET['cuisineType'];
        $foodItemName = $_GET['foodItem'];

        $sql = "SELECT *
                FROM menuItem
                WHERE mealType = :mealType
                AND cuisineType = :cuisineType
                AND foodItem = :foodItem";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':mealType', $mealType, PDO::PARAM_STR);
        $statement->bindParam(':cuisineType', $cuisineType, PDO::PARAM_STR);
        $statement->bindParam(':foodItem', $foodItemName, PDO::PARAM_STR); // Changed the variable name here
        $statement->execute();

        $foodItem = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Food Item</title>
</head>
<body>

<?php if (isset($foodItem) && $foodItem): ?>
    <h2>Food Item Details</h2>
    <table>
        <tr>
            <td><strong>Meal Type:</strong></td>
            <td contenteditable="true"><?php echo escape($foodItem["mealType"]); ?></td>
        </tr>
        <tr>
            <td><strong>Cuisine Type:</strong></td>
            <td contenteditable="true"><?php echo escape($foodItem["cuisineType"]); ?></td>
        </tr>
        <tr>
            <td><strong>Food Item:</strong></td>
            <td contenteditable="true"><?php echo escape($foodItem["foodItem"]); ?></td>
        </tr>
        <tr>
            <td><strong>Price:</strong></td>
            <td contenteditable="true">$<?php echo escape($foodItem["price"]); ?></td>
        </tr>
    </table>
    <a href='editfoodItem.php?id=<?php echo escape($foodItem["id"]); ?>'>Edit</a>
<?php else: ?>
    <p>No Food Item found with those attributes.</p>
<?php endif; ?>
<a href="Menu.php">Back to Menu</a>

</body>
</html>

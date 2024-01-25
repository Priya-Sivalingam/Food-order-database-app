<?php
// Include your header, database configuration, and common code here
require "templates/header.php";
require "../config.php";
require "../common.php";

$result = array(); // Initialize the result variable

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $mealType = $_POST['mealType'];
        $cuisineType = $_POST['cuisineType'];
        $foodItem = $_POST['foodItem'];

        // Create the base SQL query
        $sql = "SELECT * FROM menuitem WHERE 1";

        // Check if mealType is provided
        if (!empty($mealType)) {
            $sql .= " AND mealType = :mealType";
        }

        // Check if cuisineType is provided
        if (!empty($cuisineType)) {
            $sql .= " AND cuisineType = :cuisineType";
        }

        // Check if foodItem is provided
        if (!empty($foodItem)) {
            $sql .= " AND foodItem = :foodItem";
        }

        $statement = $connection->prepare($sql);

        // Bind parameters if provided
        if (!empty($mealType)) {
            $statement->bindParam(':mealType', $mealType, PDO::PARAM_STR);
        }

        if (!empty($cuisineType)) {
            $statement->bindParam(':cuisineType', $cuisineType, PDO::PARAM_STR);
        }

        if (!empty($foodItem)) {
            $statement->bindParam(':foodItem', $foodItem, PDO::PARAM_STR);
        }

        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Menu</h2>

        <table>
            <thead>
                <tr>
                    <th>Meal Type</th>
                    <th>Cuisine Type</th>
                    <th>Food Item</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["mealType"]); ?></td>
                <td><?php echo escape($row["cuisineType"]); ?></td>
                <td><?php echo escape($row["foodItem"]); ?></td>
                <td><?php echo escape($row["price"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No menu items found.</blockquote>
    <?php }
} ?>

<h2>Find Menu Items</h2>

<form method="post">
    <label for="mealType">Meal Type</label>
    <input type="text" id="mealType" name="mealType">

    <label for="cuisineType">Cuisine Type</label>
    <input type="text" id="cuisineType" name="cuisineType">

    <label for="foodItem">Food Item</label>
    <input type="text" id="foodItem" name="foodItem">

    <input type="submit" name="submit" value="Search Menu">
</form>

<a href="Menu.php">Back to Menu</a>

<?php require "templates/footer.php"; ?>

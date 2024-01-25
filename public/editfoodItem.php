<?php
require "templates/header.php";
require "../config.php";
require "../common.php";

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET['id'];

        $sql = "SELECT *
                FROM menuItem
                WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $foodItem = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
// Handle form submission to update food item details
if (isset($_POST['submit'])) {
    try {
        $updatedFields = array();
        var_dump($_POST);
        var_dump($foodItem);

        // Check if each field is set and update it accordingly
        if (isset($_POST['mealType']) && $_POST['mealType'] !== $foodItem['mealType']) {
            $updatedFields['mealType'] = $_POST['mealType'];
        }
        if (isset($_POST['cuisineType']) && $_POST['cuisineType'] !== $foodItem['cuisineType']) {
            $updatedFields['cuisineType'] = $_POST['cuisineType'];
        }
        if (isset($_POST['foodItem']) && $_POST['foodItem'] !== $foodItem['foodItem']) {
            $updatedFields['foodItem'] = $_POST['foodItem'];
        }
        if (isset($_POST['price']) && $_POST['price'] !== $foodItem['price']) {
            $updatedFields['price'] = $_POST['price'];
        }

        // Check if any fields need to be updated
        if (!empty($updatedFields)) {
            $setClauses = array();
            foreach ($updatedFields as $key => $value) {
                $setClauses[] = $key . ' = :' . $key;
            }

            // Build the SQL query
            $sql = "UPDATE menuItem
                    SET " . implode(', ', $setClauses) . "
                    WHERE id = :id";

            $statement = $connection->prepare($sql);
            $updatedFields['id'] = $id;
            $statement->execute($updatedFields);

            // Redirect to the menu page with a success message
            header("Location: Menu.php?updated=1");
            exit();
        } else {
            // No fields need to be updated
            echo "No changes were made.";
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Food Item</title>
</head>
<body>

<?php if ($foodItem): ?>
    <h2>Edit Food Item</h2>
    <form method="post">
        <label for="mealType">Meal Type</label>
        <input type="text" name="mealType" value="<?php echo escape($foodItem['mealType']); ?>">

        <label for="cuisineType">Cuisine Type</label>
        <input type="text" name="cuisineType" value="<?php echo escape($foodItem['cuisineType']); ?>">

        <label for="foodItem">Food Item</label>
        <input type="text" name="foodItem" value="<?php echo escape($foodItem['foodItem']); ?>">

        <label for="price">Price</label>
        <input type="text" name="price" value="<?php echo escape($foodItem['price']); ?>">

        <input type="submit" name="submit" value="Save Changes">
    </form>
<?php else: ?>
    <p>No food item found with the specified ID.</p>
<?php endif; ?>

<a href="Menu.php">Back to Menu</a>
</body>
</html>

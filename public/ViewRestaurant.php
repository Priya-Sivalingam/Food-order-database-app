<?php
include "templates/header.php";
require "../config.php";
require "../common.php";

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $restaurant_id = $_GET['id'];

        // Retrieve restaurant details
        $restaurant_sql = "SELECT * FROM restaurant WHERE id = :restaurant_id";
        $restaurant_statement = $connection->prepare($restaurant_sql);
        $restaurant_statement->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $restaurant_statement->execute();
        $restaurant = $restaurant_statement->fetch(PDO::FETCH_ASSOC);

        // Retrieve associated menu items for the restaurant
        $menuitems_sql = "SELECT M.foodItem FROM restaurant_menu AS RM
            LEFT JOIN menuitem AS M ON RM.menuitem_id = M.id
            WHERE RM.restaurant_id = :restaurant_id";
        $menuitems_statement = $connection->prepare($menuitems_sql);
        $menuitems_statement->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $menuitems_statement->execute();
        $menuitems = $menuitems_statement->fetchAll(PDO::FETCH_COLUMN);

    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Restaurant Details</title>
</head>
<body>

<?php if (isset($restaurant) && $restaurant): ?>
    <h2>Restaurant Details</h2>
    <table>
        <tr>
            <td><strong>Restaurant ID:</strong></td>
            <td><?php echo escape($restaurant["id"]); ?></td>
        </tr>
        <tr>
            <td><strong>Name:</strong></td>
            <td><?php echo escape($restaurant["name"]); ?></td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td><?php echo escape($restaurant["address"]); ?></td>
        </tr>
        <tr>
            <td><strong>City:</strong></td>
            <td><?php echo escape($restaurant["city"]); ?></td>
        </tr>
        <tr>
            <td><strong>Phone:</strong></td>
            <td><?php echo escape($restaurant["phone"]); ?></td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><?php echo escape($restaurant["email"]); ?></td>
        </tr>
        <tr>
            <td><strong>Cuisine Type:</strong></td>
            <td><?php echo escape($restaurant["cuisine_type"]); ?></td>
        </tr>
        <tr>
            <td><strong>Rating:</strong></td>
            <td><?php echo escape($restaurant["rating"]); ?></td>
        </tr>
    </table>
    <a href="editRestaurant.php?id=<?php echo $restaurant['id']; ?>">Edit</a>
<?php else: ?>
    <p>No Restaurant found with that ID.</p>
<?php endif; ?>
<a href="Restaurant.php">Back</a>
</body>
</html>

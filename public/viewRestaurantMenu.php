<?php
include "templates/header.php";
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    // Retrieve menu items from the restaurant_menu table
    $menuitems_sql = "SELECT RM.Id AS menu_id, R.name AS restaurant_name, M.foodItem
        FROM restaurant_menu AS RM
        LEFT JOIN restaurant AS R ON RM.restaurant_id = R.id
        LEFT JOIN menuitem AS M ON RM.menuitem_id = M.id";
    $menuitems_statement = $connection->query($menuitems_sql);
    $menuitems = $menuitems_statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Restaurant Menu</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php if (!empty($menuitems)): ?>
    <h2>Restaurant Menu</h2>
    <table>
        <tr>
            <th>RestaurantMenu ID</th>
            <th>Restaurant Name</th>
            <th>Menu Item</th>
        </tr>
        <?php foreach ($menuitems as $menuitem): ?>
            <tr>
                <td><?php echo escape($menuitem["menu_id"]); ?></td>
                <td><?php echo escape($menuitem["restaurant_name"]); ?></td>
                <td><?php echo escape($menuitem["foodItem"]); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>
    <p>No menu items found.</p>
<?php endif; ?>

<a href="Home.php">Back</a>
</body>
</html>

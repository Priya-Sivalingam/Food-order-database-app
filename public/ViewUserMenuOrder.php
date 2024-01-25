<?php
include "templates/header.php";
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    // Retrieve the user menu orders
    $usermenuorder_sql = "SELECT UMO.id, U.id AS user_id, O.order_id, M.foodItem
        FROM usermenuorder AS UMO
        LEFT JOIN users AS U ON UMO.user_id = U.id
        LEFT JOIN orders AS O ON UMO.order_id = O.order_id
        LEFT JOIN menuitem AS M ON UMO.menuitem_id = M.id";
    $usermenuorder_statement = $connection->query($usermenuorder_sql);
    $usermenuorders = $usermenuorder_statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Menu Orders</title>
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

<?php if (!empty($usermenuorders)): ?>
    <h2>User Menu Orders</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Order ID</th>
            <th>Menu Item</th>
        </tr>
        <?php foreach ($usermenuorders as $usermenuorder): ?>
            <tr>
                <td><?php echo escape($usermenuorder['user_id']); ?></td>
                <td><?php echo escape($usermenuorder['order_id']); ?></td>
                <td><?php echo escape($usermenuorder['foodItem']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No user menu orders found.</p>
<?php endif; ?>

<a href="Home.php">Back</a>
</body>
</html>

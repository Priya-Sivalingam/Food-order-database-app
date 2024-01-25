<?php require "templates/header.php"; ?>
<style>
    ul {
        list-style: none;
        padding: 0;
        display: flex; /* Display list items horizontally */
    }

    .menu-item {
        font-size: 16px; /* Reduce the font size */
        margin: 0 10px; /* Add some spacing between items */
    }

    .menu-item a {
        text-decoration: none;
        color: #fff; /* Change text color to white */
        background-color: #3498db; /* Set a background color */
        padding: 10px 16px; /* Adjust padding for a circular shape */
        display: inline-block;
        border-radius: 50%; /* Create a circular shape */
        transition: background-color 0.3s, color 0.3s;
    }

    .menu-item a:hover {
        background-color: #ff5733; /* Change color on hover */
    }
</style>

<ul>
    <li class="menu-item"><a href="CreateOrder.php"><strong>Create</strong></a> - Add Order</li>
    <li class="menu-item"><a href="readOrder.php"><strong>Read</strong></a>- Find an Order</li>
</ul>

<?php
require "../config.php";
require "../common.php";

// Fetch recent orders
try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM orders";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $recent_orders = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<h2> Orders</h2>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Delivery Address</th>
            <th>Phone Number</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recent_orders as $order): ?>
            <tr>
                <td><?php echo escape($order["order_id"]); ?></td>
                <td><?php echo escape($order["delivery_address"]); ?></td>
                <td><?php echo escape($order["phone_number"]); ?></td>
                <td><?php echo escape($order["order_date"]); ?></td>
                <td><a href="viewOrder.php?order_id=<?php echo escape($order['order_id']); ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back</a>
<?php include "templates/footer.php"; ?>

<?php
require "templates/header.php"; // Include your header file if needed
require "../config.php"; // Adjust the path as needed
require "../common.php"; // Adjust the path as needed

if (isset($_GET['order_id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $order_id = $_GET['order_id'];

        $sql = "SELECT * FROM Orders WHERE order_id = :order_id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $statement->execute();

        $order = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}

// Handle editing the order
if (isset($_POST['edit_order'])) {
    try {
        // Retrieve the updated order details from the form
        $new_delivery_address = $_POST['new_delivery_address'];
        $new_phone_number = $_POST['new_phone_number'];
        $new_order_date = $_POST['new_order_date'];

        $sql = "UPDATE Orders SET
                delivery_address = :delivery_address,
                phone_number = :phone_number,
                order_date = :order_date
                WHERE order_id = :order_id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':delivery_address', $new_delivery_address, PDO::PARAM_STR);
        $statement->bindParam(':phone_number', $new_phone_number, PDO::PARAM_STR);
        $statement->bindParam(':order_date', $new_order_date, PDO::PARAM_STR);
        $statement->bindParam(':order_id', $order_id, PDO::PARAM_INT);

        $statement->execute();

        // Redirect back to view order details after editing
        header("Location: viewOrder.php?order_id=" . $order_id);
        exit();

    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Order Details</title>
</head>
<body>

<?php if (isset($order) && $order): ?>
    <h2>Order Details</h2>
    <table>
        <tr>
            <td><strong>Order ID:</strong></td>
            <td><?php echo escape($order["order_id"]); ?></td>
        </tr>
        <tr>
            <td><strong>Delivery Address:</strong></td>
            <td><?php echo escape($order["delivery_address"]); ?></td>
        </tr>
        <tr>
            <td><strong>Phone Number:</strong></td>
            <td><?php echo escape($order["phone_number"]); ?></td>
        </tr>
        <tr>
            <td><strong>Order Date:</strong></td>
            <td><?php echo escape($order["order_date"]); ?></td>
        </tr>
    </table>
    <a href='editorder.php?order_id=<?php echo escape($order["order_id"]); ?>'>Edit</a>
<?php else: ?>
    <p>No Order found with that Order ID.</p>
<?php endif; ?>
<a href="Order.php">Back</a>

</body>
</html>

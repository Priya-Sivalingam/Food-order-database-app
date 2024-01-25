<?php
require "templates/header.php"; // Include your header file if needed
require "../config.php"; // Adjust the path as needed
require "../common.php"; // Adjust the path as needed

$id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
$successMessage = "";
$errorMessage = "";

if (!$id) {
    $errorMessage = "No order ID specified.";
} else {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM Orders WHERE order_id = :order_id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':order_id', $id, PDO::PARAM_INT);
        $statement->execute();

        $order = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            $errorMessage = "No order found with the specified ID.";
        }
    } catch (PDOException $error) {
        $errorMessage = "Error: " . $error->getMessage();
    }
}

if (isset($_POST['submit'])) {
    // Handle form submission
    $delivery_address = $_POST['delivery_address'];
    $phone_number = $_POST['phone_number'];
    $order_date = $_POST['order_date'];

    // Add validation here if needed

    try {
        $sql = "UPDATE Orders
                SET delivery_address = :delivery_address,
                    phone_number = :phone_number,
                    order_date = :order_date
                WHERE order_id = :order_id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':order_id', $id, PDO::PARAM_INT);
        $statement->bindParam(':delivery_address', $delivery_address, PDO::PARAM_STR);
        $statement->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $statement->bindParam(':order_date', $order_date, PDO::PARAM_STR);

        if ($statement->execute()) {
            $successMessage = "Order successfully updated!";
        } else {
            $errorMessage = "Failed to update the order.";
        }
    } catch (PDOException $error) {
        $errorMessage = "Error: " . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
</head>
<body>
    <?php if ($errorMessage): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <?php if ($order): ?>
        <h2>Edit Order</h2>
        <form method="post">
            <label for="delivery_address">Delivery Address</label>
            <input type="text" name="delivery_address" value="<?php echo escape($order['delivery_address']); ?>">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" value="<?php echo escape($order['phone_number']); ?>">
            <label for="order_date">Order Date</label>
            <input type="date" name="order_date" value="<?php echo escape($order['order_date']); ?>">
            <input type="submit" name="submit" value="Save">
        </form>

        <?php if ($successMessage): ?>
            <p style="color: green;"><?php echo $successMessage; ?></p>
        <?php endif; ?>

    <?php else: ?>
        <p>No order found with the specified ID.</p>
    <?php endif; ?>

    <a href="viewOrder.php?order_id=<?php echo escape($id); ?>">Back to View Order</a>
</body>
</html>

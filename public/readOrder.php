<?php
// Include necessary files and connect to the database
require "templates/header.php";
require "../config.php";
require "../common.php";

// Initialize variables
$result = [];
$errorMessage = "";

if (isset($_POST['submit'])) {
    try {
        // Create a PDO connection
        $connection = new PDO($dsn, $username, $password, $options);

        // Get user input values
        $orderID = $_POST['orderID'];

        // Build the SQL query
        $sql = "SELECT * FROM Orders WHERE 1";

        if (!empty($orderID)) {
            $sql .= " AND order_id = :orderID";
        }

        $statement = $connection->prepare($sql);

        if (!empty($orderID)) {
            $statement->bindParam(':orderID', $orderID, PDO::PARAM_INT);
        }

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        $errorMessage = "Error: " . $error->getMessage();
    }
}
?>

<h2>Find Orders by Order ID</h2>

<!-- Display error message if any -->
<?php if ($errorMessage): ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
<?php endif; ?>

<!-- Search form -->
<form method="post">
    <label for="orderID">Order ID</label>
    <input type="text" id="orderID" name="orderID">
    <input type="submit" name="submit" value="View Results">
</form>

<!-- Display search results -->
<?php if ($result): ?>
    <h2>Search Results</h2>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Delivery Address</th>
                <th>Phone Number</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $order): ?>
                <tr>
                    <td><?php echo escape($order["order_id"]); ?></td>
                    <td><?php echo escape($order["delivery_address"]); ?></td>
                    <td><?php echo escape($order["phone_number"]); ?></td>
                    <td><?php echo escape($order["order_date"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No results found.</p>
<?php endif; ?>

<!-- Back to home link -->
<a href="Order.php">Back to Home</a>

<!-- Include the footer template -->
<?php require "templates/footer.php"; ?>

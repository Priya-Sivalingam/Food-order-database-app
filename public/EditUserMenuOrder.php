<?php
include "templates/header.php";
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    if (isset($_POST['submit'])) {
        $usermenuorder_id = $_GET['id'];
        $menuitem_id = $_POST['menuitem_id'];

        // Update the user menu order
        $update_sql = "UPDATE usermenuorder SET menuitem_id = :menuitem_id WHERE id = :usermenuorder_id";
        $update_statement = $connection->prepare($update_sql);
        $update_statement->execute([
            ':menuitem_id' => $menuitem_id,
            ':usermenuorder_id' => $usermenuorder_id,
        ]);

        echo "User menu order updated successfully.";
    }

    $usermenuorder_id = $_GET['id'];

    // Retrieve the user menu order details
    $usermenuorder_sql = "SELECT UMO.id, U.customerName, O.order_date, M.foodItem, UMO.menuitem_id
        FROM usermenuorder AS UMO
        LEFT JOIN users AS U ON UMO.user_id = U.id
        LEFT JOIN orders AS O ON UMO.order_id = O.order_id
        LEFT JOIN menuitem AS M ON UMO.menuitem_id = M.id
        WHERE UMO.id = :usermenuorder_id";
    $usermenuorder_statement = $connection->prepare($usermenuorder_sql);
    $usermenuorder_statement->bindParam(':usermenuorder_id', $usermenuorder_id, PDO::PARAM_INT);
    $usermenuorder_statement->execute();
    $usermenuorder = $usermenuorder_statement->fetch(PDO::FETCH_ASSOC);

    // Fetch menu items for the dropdown
    $menuitems_sql = "SELECT id, foodItem FROM menuitem";
    $menuitems_statement = $connection->query($menuitems_sql);
    $menuitems = $menuitems_statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User Menu Order</title>
</head>
<body>

<?php if (isset($usermenuorder) && $usermenuorder): ?>
    <h2>Edit User Menu Order</h2>
    <form method="post">
        <div class="form-box">
            <label for="customerName">User Name</label>
            <input type="text" name="customerName" value="<?php echo escape($usermenuorder['customerName']); ?>" readonly>
        </div>
        <div class="form-box">
            <label for="order_date">Order Date</label>
            <input type="text" name="order_date" value="<?php echo escape($usermenuorder['order_date']); ?>" readonly>
        </div>
        <div class="form-box">
            <label for="foodItem">Menu Item</label>
            <select name="menuitem_id" id="menuitem_id">
                <?php foreach ($menuitems as $mi) { ?>
                    <option value="<?php echo $mi['id']; ?>" <?php if ($mi['id'] == $usermenuorder['menuitem_id']) echo "selected"; ?>>
                        <?php echo $mi['foodItem']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <input type="submit" name="submit" value="Save Changes">
    </form>
<?php else: ?>
    <p>No User Menu Order found with that ID.</p>
<?php endif; ?>

<a href="ViewUserMenuOrder.php">Back</a>

</body>
</html>

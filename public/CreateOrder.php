<?php
require "templates/header.php";
require "../config.php";
require "../common.php";

$delivery_address = $phone_number = $order_date = $user_id = $menuitems = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $delivery_address = $_POST['delivery_address'];
        $phone_number = $_POST['phone_number'];
        $order_date = $_POST['order_date'];
        $user_id = $_POST['user_id'];
        $menuitems = $_POST['menuitems'];

        $connection->beginTransaction();

        // Step 1: Insert the order information
        $insertOrderSql = "INSERT INTO orders (delivery_address, phone_number, order_date) VALUES (:delivery_address, :phone_number, :order_date)";
        $insertOrderStatement = $connection->prepare($insertOrderSql);
        $insertOrderStatement->execute([
            ':delivery_address' => $delivery_address,
            ':phone_number' => $phone_number,
            ':order_date' => $order_date,

        ]);

        $insertedOrderId = $connection->lastInsertId();

        // Step 2: Insert the selected menu items for the order
        if (!empty($menuitems)) {
            $insertOrderMenuSql = "INSERT INTO usermenuorder (user_id, order_id, menuitem_id) VALUES (:user_id, :order_id, :menuitem_id)";
            $insertOrderMenuStatement = $connection->prepare($insertOrderMenuSql);

            foreach ($menuitems as $menuitem_id) {
                $insertOrderMenuStatement->execute([
                    ':user_id' => $user_id,
                    ':order_id' => $insertedOrderId,
                    ':menuitem_id' => $menuitem_id
                ]);
            }
        }

        $connection->commit();

        echo "Order and associated menu items added successfully.";
    } catch (PDOException $error) {
        $connection->rollBack();
        echo "Transaction rolled back: " . $error->getMessage();
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);

   $userSql = "SELECT u.id AS user_id, u.customerName, o.delivery_address, o.phone_number, o.order_date, m.foodItem
           FROM users u
           LEFT JOIN usermenuorder uo ON u.id = uo.user_id
           LEFT JOIN orders o ON uo.order_id = o.order_id
           LEFT JOIN menuitem m ON uo.menuitem_id = m.id";

    $userResult = $connection->query($userSql);
    $users = $userResult->fetchAll(PDO::FETCH_ASSOC);

    $menuitemSql = "SELECT id, foodItem FROM menuitem";
    $menuitemResult = $connection->query($menuitemSql);
    $menuitems = $menuitemResult->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<h2>Create an Order</h2>
<form method="post">
<div class="form-box">
    <label for="user_id">Select User</label>
    <select name="user_id" id="user_id">
        <?php foreach ($users as $user) { ?>
            <option value="<?php echo $user['user_id']; ?>">
                <?php echo $user['customerName']; ?>
            </option>
        <?php } ?>
    </select>
</div>


    <div class="form-box">
        <label for="delivery_address">Delivery Address</label>
        <input type="text" name="delivery_address" id="delivery_address" required>
    </div>

    <div class="form-box">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" required>
    </div>

    <div class="form-box">
        <label for="order_date">Order Date</label>
        <input type="date" name="order_date" id="order_date" required>
    </div>

    <div class="form-box">
        <label for="menuitems[]">Select Menu Items (Hold Ctrl/Cmd to select multiple)</label>
        <select multiple name="menuitems[]" id="menuitems">
            <?php foreach ($menuitems as $menuitem) { ?>
                <option value="<?php echo $menuitem['id']; ?>">
                    <?php echo $menuitem['foodItem']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-box">
        <input type="submit" name="submit" value="Submit">
    </div>
</form>

<a href="Order.php">Back</a>

<?php require "templates/footer.php"; ?>

<?php
include "templates/header.php";
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    // Retrieve the menu items
    $menuitems_sql = "SELECT RM.Id AS menu_id, R.id AS restaurant_id, R.name AS restaurant_name, M.id AS menuitem_id, M.foodItem
        FROM restaurant_menu AS RM
        LEFT JOIN restaurant AS R ON RM.restaurant_id = R.id
        LEFT JOIN menuitem AS M ON RM.menuitem_id = M.id";
    $menuitems_statement = $connection->query($menuitems_sql);
    $menuitems = $menuitems_statement->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all menu items
    $menuitems_sql = "SELECT id, foodItem FROM menuitem";
    $menuitems_statement = $connection->query($menuitems_sql);
    $all_menuitems = $menuitems_statement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {
        $menu_id = $_POST['menu_id'];
        $restaurant_id = $_POST['restaurant_id'];
        $menuitem_id = $_POST['menuitem_id'];

        // Update the restaurant menu item
        $update_sql = "UPDATE restaurant_menu SET restaurant_id = :restaurant_id, menuitem_id = :menuitem_id WHERE Id = :menu_id";
        $update_statement = $connection->prepare($update_sql);
        $update_statement->execute([
            ':restaurant_id' => $restaurant_id,
            ':menuitem_id' => $menuitem_id,
            ':menu_id' => $menu_id,
        ]);

        echo "Menu item updated successfully.";
    }
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Restaurant Menu Items</title>
</head>
<body>

<h2>Edit Restaurant Menu Items</h2>

<table>
    <tr>
        <th>Restaurant Name</th>
        <th>Menu Item</th>
        <th>Action</th>
    </tr>
    <?php foreach ($menuitems as $menuitem): ?>
        <tr>
            <td><?php echo escape($menuitem['restaurant_name']); ?></td>
            <td><?php echo escape($menuitem['foodItem']); ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="menu_id" value="<?php echo $menuitem['menu_id']; ?>">
                    <input type="hidden" name="restaurant_id" value="<?php echo $menuitem['restaurant_id']; ?>">
                    <select name="menuitem_id">
                        <?php foreach ($all_menuitems as $mi) { ?>
                            <option value="<?php echo $mi['id']; ?>" <?php if ($mi['id'] == $menuitem['menuitem_id']) echo "selected"; ?>>
                                <?php echo $mi['foodItem']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="submit" name="submit" value="Save Changes">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="ViewRestaurantMenu.php">Back</a>

</body>
</html>

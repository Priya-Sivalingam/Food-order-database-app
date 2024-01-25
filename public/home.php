<?php
require "templates/header.php";
require "../config.php";
require "../common.php";
?>
<!DOCTYPE html>
<html>
<head>
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

        #back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }

        #back-to-top a {
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
        }

        #back-to-top a i {
            font-size: 24px;
        }

        #back-to-top a:hover {
            background-color: #ff5733;
        }
    </style>

<ul>
    <li class="menu-item"><a href="viewRestaurantMenu.php"><strong>View</strong></a> -Restaurant-Menu</li>
    <li class="menu-item"><a href="viewUserMenuOrder.php"><strong>View</strong></a> -User-MenuItem-order</li>
</ul>

<?php
$recent_orders = $recent_users = $recent_restaurants = $recent_menuitems = array(); // Initialize arrays

try {
    $connection = new PDO($dsn, $username, $password, $options);
     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recent 3 orders
    $order_sql = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 3";
    $order_statement = $connection->prepare($order_sql);
    $order_statement->execute();
    $recent_orders = $order_statement->fetchAll(PDO::FETCH_ASSOC);

    // Recent 3 users
    $user_sql = "SELECT * FROM Users ORDER BY id DESC LIMIT 3";
    $user_statement = $connection->prepare($user_sql);
    $user_statement->execute();
    $recent_users = $user_statement->fetchAll(PDO::FETCH_ASSOC);

    // Recent 3 restaurants
    $restaurant_sql = "SELECT * FROM restaurant ORDER BY id DESC LIMIT 3";
    $restaurant_statement = $connection->prepare($restaurant_sql);
    $restaurant_statement->execute();
    $recent_restaurants = $restaurant_statement->fetchAll(PDO::FETCH_ASSOC);

    // Recent menu items (adjust the query as needed)
   $menuitem_sql = "SELECT * FROM menuitem ORDER BY id DESC LIMIT 3";
           $menuitem_statement = $connection->prepare($menuitem_sql);
           $menuitem_statement->execute();
           $recent_menuitems = $menuitem_statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>


<h2>Recent Users</h2>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Address</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recent_users as $user): ?>
            <tr>
                <td><?php echo escape($user["id"]); ?></td>
                <td><?php echo escape($user["customerName"]); ?></td>
                <td><?php echo escape($user["phoneNumber"]); ?></td>
                <td><?php echo escape($user["Email"]); ?></td>
                <td><?php echo escape($user["Address"]); ?></td>
                <td><?php echo escape($user["date"]); ?></td>
                <td><a href="viewUser.php?id=<?php echo escape($user['id']); ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Recent Orders</h2>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Delivery Address</th>
            <th>Phone Number</th>
            <th>Date</th>
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

<h2>Recent Menu Items</h2>
<table>
    <thead>
        <tr>
            <th>Menu Item ID</th>
            <th>Food Item</th>
            <th>Price</th>
            <th>Meal Type</th>
            <th>Cuisine Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recent_menuitems as $menuitem): ?>
            <tr>
                <td><?php echo escape($menuitem["id"]); ?></td>
                <td><?php echo escape($menuitem["foodItem"]); ?></td>
                <td><?php echo escape($menuitem["price"]); ?></td>
                <td><?php echo escape($menuitem["mealType"]); ?></td>
                <td><?php echo escape($menuitem["cuisineType"]); ?></td>
                 <td><a href="viewfoodItems.php?id=<?php echo escape($menuitem['id']); ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<h2>Recent Restaurants</h2>

<table>
    <thead>
        <tr>
            <th>Restaurant ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Cuisine Type</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recent_restaurants as $restaurant): ?>
            <tr>
                <td><?php echo escape($restaurant["id"]); ?></td>
                <td><?php echo escape($restaurant["name"]); ?></td>
                <td><?php echo escape($restaurant["address"]); ?></td>
                <td><?php echo escape($restaurant["city"]); ?></td>
                <td><?php echo escape($restaurant["phone"]); ?></td>
                <td><?php echo escape($restaurant["email"]); ?></td>
                <td><?php echo escape($restaurant["cuisine_type"]); ?></td>
                <td><?php echo escape($restaurant["rating"]); ?></td>
                <td><a href="viewRestaurant.php?id=<?php echo escape($restaurant['id']); ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<a href="index.php">Back</a>

<?php require "templates/footer.php"; ?>

<!-- Back-to-top arrow -->
<div id="back-to-top">
    <a href="#top"><i class="fa fa-arrow-up"></i></a>
</div>

<script>
    window.addEventListener('scroll', function () {
        var arrow = document.getElementById('back-to-top');
        if (window.scrollY > 200) {
            arrow.style.display = 'block';
        } else {
            arrow.style.display = 'none';
        }
    });
</script>
</body>
</html>


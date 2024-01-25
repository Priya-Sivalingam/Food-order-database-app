<?php include "templates/header.php"; ?>
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

<h2>Restaurant</h2>
<ul>
    <li class="menu-item"><a href="CreateRestaurant.php"><strong>Create</strong></a> - Add Restaurant</li>
    <li class="menu-item"><a href="ReadRestaurant.php"><strong>Read</strong></a> - Find Restaurant</li>
</ul>

<?php
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM restaurant";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $restaurants = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<h2>ALL Restaurants Details</h2>

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
        <?php foreach ($restaurants as $restaurant): ?>
            <tr>
                <td><?php echo escape($restaurant["id"]); ?></td>
                <td><?php echo escape($restaurant["name"]); ?></td>
                <td><?php echo escape($restaurant["address"]); ?></td>
                <td><?php echo escape($restaurant["city"]); ?></td>
                <td><?php echo escape($restaurant["phone"]); ?></td>
                <td><?php echo escape($restaurant["email"]); ?></td>
                <td><?php echo escape($restaurant["cuisine_type"]); ?></td>
                <td><?php echo escape($restaurant["rating"]); ?></td>
                <td><a href="ViewRestaurant.php?id=<?php echo escape($restaurant['id']); ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back</a>

<?php require "templates/footer.php"; ?>

<?php
require "templates/header.php";
require "../config.php";
require "../common.php";

// Include your database connection code or require_once statement here
// For example: require_once "includes/db_connect.php";

// Query to retrieve distinct meal types (e.g., lunch or dinner)
$mealTypesQuery = "SELECT DISTINCT mealType FROM menuItem"; // Replace with your table name

// Execute the query to get meal types
$connection = mysqli_connect($host, $username, $password, $dbname);

$mealTypesResult = mysqli_query($connection, $mealTypesQuery); // Replace $connection with your database connection variable

// Check for query errors and handle them if necessary
if (!$connection) {
    die("Database query failed: " . mysqli_error($connection)); // Handle errors appropriately
}
?>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <!-- Add your CSS styles here -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Add Item link at the top -->
    <ul>
    <li class="menu-item"><a href='CreateMenu.php'>Create</a> -Add Menu </li>
    <li class="menu-item"><a href='ReadMenu.php'>Read</a> -Read Menu</li>
    </ul>

    <h2>Menu</h2>

    <div class="menu-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Meal Type</th>
                    <th>Cuisine Type</th>
                    <th>Food Item</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rowCounter = 1; // Initialize row counter

                // Loop through meal types and fetch cuisine types and food items
                while ($mealTypeRow = mysqli_fetch_assoc($mealTypesResult)) {
                    $mealType = $mealTypeRow['mealType'];
                    $cuisineTypesQuery = "SELECT DISTINCT cuisineType FROM menuItem WHERE mealType = '$mealType'";
                    $cuisineTypesResult = mysqli_query($connection, $cuisineTypesQuery);

                    while ($cuisineTypeRow = mysqli_fetch_assoc($cuisineTypesResult)) {
                        $cuisineType = $cuisineTypeRow['cuisineType'];
                        $foodItemsQuery = "SELECT foodItem, price FROM menuItem WHERE mealType = '$mealType' AND cuisineType = '$cuisineType'";
                        $foodItemsResult = mysqli_query($connection, $foodItemsQuery);

                        while ($foodItemRow = mysqli_fetch_assoc($foodItemsResult)) {
                            $foodItem = $foodItemRow['foodItem'];
                            $price = $foodItemRow['price'];
                ?>
                            <tr>
                                <td><?php echo $rowCounter; ?></td>
                                <td><?php echo $mealType; ?></td>
                                <td><?php echo $cuisineType; ?></td>
                                <td><?php echo $foodItem; ?></td>
                                <td>$<?php echo $price; ?></td>
                                <td>
                                    <a href='viewfoodItems.php?mealType=<?php echo urlencode($mealType); ?>&cuisineType=<?php echo urlencode($cuisineType); ?>&foodItem=<?php echo urlencode($foodItem); ?>'>View</a>
                                </td>
                            </tr>
                <?php
                            $rowCounter++; // Increment row counter
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<a href="index.php"><strong>Back</strong></a>

<?php
require "templates/footer.php";
?>

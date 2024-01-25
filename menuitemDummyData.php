<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "uberEats";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the number of menu items to generate
$numMenuItems = 30;

// Define the SQL statement to create the "menuitem" table
$createTableSQL = "CREATE TABLE IF NOT EXISTS menuitem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    foodItem VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    mealType VARCHAR(255),
    cuisineType VARCHAR(255)
)";

// Create the "menuitem" table if it doesn't exist
if ($conn->query($createTableSQL) === FALSE) {
    echo "Error creating table: " . $conn->error;
    exit;
}

// ...
for ($i = 1; $i <= $numMenuItems; $i++) {
    $foodItem = "FoodItem" . rand(1, $numMenuItems);
    $price = rand(5, 30) + (rand(0, 99) / 100); // Generate a random price with two decimal places
    $mealType = "Dinner"; // Set the meal type to "Breakfast" for all records
    $cuisineType = "CuisineType" . rand(1, 10); // You can adjust the number of cuisine types

    // Insert data into the "menuitem" table
    $sql = "INSERT INTO menuitem (foodItem, price, mealType, cuisineType) VALUES (?, ?, ?, ?)";

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $foodItem, $price, $mealType, $cuisineType);
    $stmt->execute();
    $stmt->close();
}
// ...


// Close the connection
$conn->close();

echo "Inserted $numMenuItems menu items with 'Breakfast' as the meal type into the 'menuitem' table.";
?>

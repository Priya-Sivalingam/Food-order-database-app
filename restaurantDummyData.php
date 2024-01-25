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

// Define the number of restaurants to generate
$numRestaurants = 100;

// Define the SQL statement to create the "restaurant" table
$createTableSQL = "CREATE TABLE IF NOT EXISTS restaurant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    email VARCHAR(255) NOT NULL,
    cuisine_type VARCHAR(255),
    rating DECIMAL(3, 2)
)";

// Create the "restaurant" table if it doesn't exist
if ($conn->query($createTableSQL) === FALSE) {
    echo "Error creating table: " . $conn->error;
    exit;
}

for ($i = 1; $i <= $numRestaurants; $i++) {
    $name = "Restaurant" . rand(1, $numRestaurants);
    $address = "Address" . rand(1, $numRestaurants);
    $city = "City" . rand(1, 10); // You can adjust the number of cities
    $phone = rand(100000000, 999999999); // Generate a random 9-digit phone number
    $email = "restaurant" . $i . "@example.com"; // Adjust the email generation as needed
    $cuisineType = "CuisineType" . rand(1, 10); // You can adjust the number of cuisine types
    $rating = rand(3, 5) + (rand(0, 99) / 100); // Generate a random rating with two decimal places

    // Insert data into the "restaurant" table
    $sql = "INSERT INTO restaurant (name, address, city, phone, email, cuisine_type, rating) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssd", $name, $address, $city, $phone, $email, $cuisineType, $rating);
    $stmt->execute();
    $stmt->close();
}

// Close the connection
$conn->close();

echo "Inserted $numRestaurants restaurants with random data into the 'restaurant' table.";
?>

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

// Define the number of rows to generate
$numRows = 100;

// Define the SQL statement to create the "orders" table
$createTableSQL = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customerName VARCHAR(255) NOT NULL,
    phoneNumber VARCHAR(10) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    date DATETIME
)";

// Create the "orders" table if it doesn't exist
if ($conn->query($createTableSQL) === FALSE) {
    echo "Error creating table: " . $conn->error;
    exit;
}

for ($i = 1; $i <= $numRows; $i++) {
    $customerName = "Customer" . rand(1, $numRows);
    $phoneNumber = rand(100000000, 999999999); // Generate a random 9-digit phone number
    $email = "customer" . $i . "@example.com"; // Adjust the email generation as needed
    $address = "Address" . rand(1, $numRows);

    $startDate = strtotime("2023-01-01");
    $endDate = strtotime("2023-12-31");
    $randomTimestamp = rand($startDate, $endDate);
    $randomDate = date("Y-m-d H:i:s", $randomTimestamp);

    // Insert data into the "orders" table
    $sql = "INSERT INTO users (customerName, phoneNumber, Email, Address, date) VALUES (?, ?, ?, ?, ?)";

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $customerName, $phoneNumber, $email, $address, $randomDate);
    $stmt->execute();
    $stmt->close();
}

// Close the connection
$conn->close();

echo "Inserted $numRows rows of random data into the 'orders' table.";
?>

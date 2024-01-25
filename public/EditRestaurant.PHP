<?php
require "templates/header.php";
require "../config.php";
require "../common.php";

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $restaurant_id = $_GET['id'];

       $sql = "SELECT *
               FROM Restaurant
               WHERE id = :restaurant_id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $statement->execute();

        $restaurant = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// Handle form submission to update restaurant details
if (isset($_POST['submit'])) {
    try {
        $updatedFields = array();

        // Check if each field is set and update it accordingly
        if (isset($_POST['name']) && $_POST['name'] !== $restaurant['name']) {
            $updatedFields['name'] = $_POST['name'];
        }
        if (isset($_POST['address']) && $_POST['address'] !== $restaurant['address']) {
            $updatedFields['address'] = $_POST['address'];
        }
        if (isset($_POST['city']) && $_POST['city'] !== $restaurant['city']) {
            $updatedFields['city'] = $_POST['city'];
        }
        if (isset($_POST['phone']) && $_POST['phone'] !== $restaurant['phone']) {
            $updatedFields['phone'] = $_POST['phone'];
        }
        if (isset($_POST['email']) && $_POST['email'] !== $restaurant['email']) {
            $updatedFields['email'] = $_POST['email'];
        }
        if (isset($_POST['cuisine_type']) && $_POST['cuisine_type'] !== $restaurant['cuisine_type']) {
            $updatedFields['cuisine_type'] = $_POST['cuisine_type'];
        }
        if (isset($_POST['rating']) && $_POST['rating'] !== $restaurant['rating']) {
            $updatedFields['rating'] = $_POST['rating'];
        }

        // Check if any fields need to be updated
        if (!empty($updatedFields)) {
            $setClauses = array();
            foreach ($updatedFields as $key => $value) {
                $setClauses[] = $key . ' = :' . $key;
            }

            // Build the SQL query
            $sql = "UPDATE Restaurant
                    SET " . implode(', ', $setClauses) . "
                    WHERE id = :restaurant_id";

            $statement = $connection->prepare($sql);
            $updatedFields['restaurant_id'] = $restaurant_id;
            $statement->execute($updatedFields);

            // Redirect to the view restaurant page with a success message
            header("Location: viewRestaurant.php?id=" . $restaurant_id . "&updated=1");
            exit();
        } else {
            // No fields need to be updated
            echo "No changes were made.";
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Restaurant</title>
</head>
<body>

<?php if ($restaurant): ?>
    <h2>Edit Restaurant</h2>
    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo escape($restaurant['name']); ?>">

        <label for="address">Address</label>
        <input type="text" name="address" value="<?php echo escape($restaurant['address']); ?>">

        <label for="city">City</label>
        <input type="text" name="city" value="<?php echo escape($restaurant['city']); ?>">

        <label for="name">Phone</label>
        <input type="text" name="phone" value="<?php echo escape($restaurant['phone']); ?>">

        <label for="address">Email</label>
        <input type="text" name="email" value="<?php echo escape($restaurant['email']); ?>">

        <label for="city">Cuisine Type</label>
        <input type="text" name="cuisine_type" value="<?php echo escape($restaurant['cuisine_type']); ?>">

        <label for="city">Rating</label>
        <input type="text" name="rating" value="<?php echo escape($restaurant['rating']); ?>">

        <input type="submit" name="submit" value="Save Changes">
    </form>
<?php else: ?>
    <p>No restaurant found with the specified ID.</p>
<?php endif; ?>

<a href="Restaurant.php?id=<?php echo $restaurant_id; ?>">Back</a>
</body>
</html>

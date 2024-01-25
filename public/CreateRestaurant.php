<?php
require "../config.php";
require "../common.php";

// Initialize variables
$name = $address = $city = $phone = $email = $cuisine_type = $rating = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        // Initialize variables with form data
        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $cuisine_type = $_POST['cuisine_type'];
        $rating = $_POST['rating'];

        // Start a transaction
        $connection->beginTransaction();

        // Step 1: Execute the first query (insertion) for the restaurant
        $insertRestaurantSql = "INSERT INTO restaurant (name, address, city, phone, email, cuisine_type, rating) VALUES (:name, :address, :city, :phone, :email, :cuisine_type, :rating)";
        $insertRestaurantStatement = $connection->prepare($insertRestaurantSql);
        $insertRestaurantStatement->execute([
            ':name' => $name,
            ':address' => $address,
            ':city' => $city,
            ':phone' => $phone,
            ':email' => $email,
            ':cuisine_type' => $cuisine_type,
            ':rating' => $rating
        ]);

        //To check rollback
//
//           $insertRestaurantSql = "INSERT INTO Hotel (name, address, city, phone, email, cuisine_type, rating) VALUES (:name, :address, :city, :phone, :email, :cuisine_type, :rating)";
//                 $insertRestaurantStatement = $connection->prepare($insertRestaurantSql);
//                 $insertRestaurantStatement->execute([
//                     ':name' => $name,
//                     ':address' => $address,
//                     ':city' => $city,
//                     ':phone' => $phone,
//                     ':email' => $email,
//                     ':cuisine_type' => $cuisine_type,
//                     ':rating' => $rating
//                 ]);

        // Step 2: Get the inserted Restaurant ID
        $insertedRestaurantId = $connection->lastInsertId();

        // Step 3: Execute the second query (updating) to update restaurant_menu
        if (isset($_POST['menuitems']) && is_array($_POST['menuitems'])) {
            $menuitems = $_POST['menuitems'];

            foreach ($menuitems as $menuitem_id) {
                $updateRestaurantMenuSql = "INSERT INTO restaurant_menu (restaurant_id, menuitem_id) VALUES (:restaurant_id, :menuitem_id)";
                $updateRestaurantMenuStatement = $connection->prepare($updateRestaurantMenuSql);
                $updateRestaurantMenuStatement->execute([
                    ':restaurant_id' => $insertedRestaurantId,
                    ':menuitem_id' => $menuitem_id
                ]);
            }
        }

        // Commit the transaction
        $connection->commit();

        echo "Transaction committed Successfully.";
    } catch (PDOException $error) {
        $connection->rollback();
        echo "Transaction rolled back: " . $error->getMessage();
    }
}

// Fetch menu items to populate the dropdown
try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT id, foodItem FROM menuitem";
    $result = $connection->query($sql);
    $menuitems = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Add a Restaurant</h2>

<form method="post">
    <div class="form-box">
        <label for="name">Restaurant Name</label>
        <input type="text" name="name" id="name" required>
    </div>

    <div class="form-box">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" required>
    </div>

    <div class="form-box">
        <label for="city">City</label>
        <input type="text" name="city" id="city">
    </div>

    <div class="form-box">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone">
    </div>

    <div class="form-box">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </div>

    <div class="form-box">
        <label for="cuisine_type">Cuisine Type</label>
        <input type="text" name="cuisine_type" id="cuisine_type">
    </div>

    <div class="form-box">
        <label for="rating">Rating</label>
        <input type="text" name="rating" id="rating">
    </div>

    <div class="form-box">
        <label for="menuitems">Select Menu Items (Hold Ctrl/Cmd to select multiple)</label>
        <select multiple name="menuitems[]" id="menuitems">
            <?php foreach ($menuitems as $menuitem) { ?>
                <option value="<?php echo $menuitem['id']; ?>"><?php echo $menuitem['foodItem']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-box">
        <input type="submit" name="submit" value="Submit">
    </div>
</form>

<a href="Restaurant.php">Back</a>

<?php require "templates/footer.php"; ?>

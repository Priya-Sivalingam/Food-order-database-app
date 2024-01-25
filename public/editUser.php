<?php
require "templates/header.php";
require "../config.php";
require "../common.php";

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $user_id = $_GET['id'];

        $sql = "SELECT *
                FROM Users
                WHERE id = :user_id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// Handle form submission to update user details
if (isset($_POST['submit'])) {
    try {
        $updatedFields = array();

        // Check if each field is set and update it accordingly
        if (isset($_POST['customerName']) && $_POST['customerName'] !== $user['customerName']) {
            $updatedFields['customerName'] = $_POST['customerName'];
        }
        if (isset($_POST['phoneNumber']) && $_POST['phoneNumber'] !== $user['phoneNumber']) {
            $updatedFields['phoneNumber'] = $_POST['phoneNumber'];
        }
        if (isset($_POST['Email']) && $_POST['Email'] !== $user['Email']) {
            $updatedFields['Email'] = $_POST['Email'];
        }
        if (isset($_POST['Address']) && $_POST['Address'] !== $user['Address']) {
            $updatedFields['Address'] = $_POST['Address'];
       }

        // Check if any fields need to be updated
        if (!empty($updatedFields)) {
            $setClauses = array();
            foreach ($updatedFields as $key => $value) {
                $setClauses[] = $key . ' = :' . $key;
            }

            // Build the SQL query
            $sql = "UPDATE Users
                    SET " . implode(', ', $setClauses) . "
                    WHERE id = :user_id";

            $statement = $connection->prepare($sql);
            $updatedFields['user_id'] = $user_id;
            $statement->execute($updatedFields);

            // Redirect to the view user page with a success message
            header("Location: viewUser.php?id=" . $user_id . "&updated=1");
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
    <title>Edit User</title>
</head>
<body>

<?php if ($user): ?>
    <h2>Edit User</h2>
    <form method="post">
        <label for="customerName">User Name</label>
        <input type="text" name="customerName" value="<?php echo escape($user['customerName']); ?>">
         <label for="customerName">Phone Number</label>
         <input type="text" name="phoneNumber" value="<?php echo escape($user['phoneNumber']); ?>">
         <label for="customerName">Email</label>
         <input type="text" name="Email" value="<?php echo escape($user['Email']); ?>">
         <label for="customerName">Address</label>
         <input type="text" name="Address" value="<?php echo escape($user['Address']); ?>">


        <input type="submit" name="submit" value="Save Changes">
    </form>
<?php else: ?>
    <p>No user found with the specified ID.</p>
<?php endif; ?>

<a href="Userlogin.php?id=<?php echo $user_id; ?>">Back</a>
</body>
</html>

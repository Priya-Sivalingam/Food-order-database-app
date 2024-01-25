<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 */

if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "customerName" => $_POST['customerName'],
            "PhoneNumber" => $_POST['PhoneNumber'],
            "Email" => $_POST['Email'],
            "Address" => $_POST['Address']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            "users", // Assuming you want to insert data into the "users" table
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['customerName']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a user</h2>

<form method="post">
    <label for="customerName">Customer Name</label>
    <input type="text" name="customerName" id="customerName">
    <label for="PhoneNumber">Phone Number</label>
    <input type="text" name="PhoneNumber" id="PhoneNumber">
    <label for="Email">Email</label>
    <input type="text" name="Email" id="Email">
    <label for="Address">Address</label>
    <input type="text" name="Address" id="Address">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="Userlogin.php">Back</a>

<?php require "templates/footer.php"; ?>

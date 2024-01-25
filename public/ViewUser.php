<?php
require "templates/header.php";
require "../config.php";
require "../common.php";
if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET['id'];

        $sql = "SELECT *
                FROM users
                WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
$updatedMessage = "";

if (isset($_GET['updated']) && $_GET['updated'] == 1) {
    $updatedMessage = "User successfully updated!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View User</title>
</head>
<body>

<?php if ($user): ?>
    <h2>User Details</h2>

    <p><strong>User Name: </strong><?php echo escape($user["customerName"]); ?> </p>
    <p><strong>Phone Number: </strong><?php echo escape($user["phoneNumber"]); ?> </p>
    <p><strong>Email: </strong><?php echo escape($user["Email"]); ?> </p>
    <p><strong>Address: </strong><?php echo escape($user["Address"]); ?> </p>
    <a href='editUser.php?id=<?php echo escape($user["id"]); ?>'>Edit</a>


<?php else: ?>
    <blockquote>No User found with that ID.</blockquote>
<?php endif; ?>
<a href="ReadUser.php?id=<?php echo escape($id); ?>">Back</a>

</body>
</html>
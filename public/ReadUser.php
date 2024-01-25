<?php

if (isset($_POST['submit'])) {
    try  {
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_POST['id'];

        // Create the base SQL query
        $sql = "SELECT * FROM Users WHERE 1";

        // Check if either location or food item is provided
        if (!empty($id)) {
            $sql .= " AND id = :id";
        }

        $statement = $connection->prepare($sql);

        if (!empty($id)) {
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
        }

        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>customerName</th>
                    <th>phoneNumber</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Create Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["id"]); ?></td>
                <td><?php echo escape($row["customerName"]); ?></td>
                <td><?php echo escape($row["phoneNumber"]); ?></td>
                <td><?php echo escape($row["Email"]); ?></td>
                <td><?php echo escape($row["Address"]); ?></td>
                <td><?php echo escape($row["date"]); ?> </td>
                <td><a href="viewUser.php?id=<?php echo escape($row['id']); ?>">View</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found.</blockquote>
    <?php }
} ?>

<h2>Find User based on User ID</h2>

<form method="post">
    <label for="id">User ID</label>
    <input type="number" id="id" name="id">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="Userlogin.php">Back</a>

<?php require "templates/footer.php"; ?>

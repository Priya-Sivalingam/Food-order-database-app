<?php
if (isset($_POST['submit'])) {
    try {
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_POST['id'];

        // Create the base SQL query
        $sql = "SELECT * FROM Restaurant WHERE 1";

        // Check if restaurant_id is provided
        if (!empty($id)) {
            $sql .= " AND id = :id";
        }

        $statement = $connection->prepare($sql);

        if (!empty($id)) {
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
        }

        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $error) {
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
                    <th>Restaurant ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>

                    <th>Phone</th>
                    <th>Email</th>
                    <th>Cuisine Type</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo escape($row["id"]); ?></td>
                    <td><?php echo escape($row["name"]); ?></td>
                    <td><?php echo escape($row["address"]); ?></td>
                    <td><?php echo escape($row["city"]); ?></td>

                    <td><?php echo escape($row["phone"]); ?></td>
                    <td><?php echo escape($row["email"]); ?></td>
                    <td><?php echo escape($row["cuisine_type"]); ?></td>
                    <td><?php echo escape($row["rating"]); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <blockquote>No results found.</blockquote>
    <?php }
}
?>

<h2>Find Restaurant based on Restaurant ID</h2>

<form method="post">
    <label for="id">Restaurant ID</label>
    <input type="number" id="id" name="id">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="Restaurant.php">Back to Restaurant </a>

<?php require "templates/footer.php"; ?>

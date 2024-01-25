<?php include "templates/header.php"; ?>
<style>
    ul {
        list-style: none;
        padding: 0;
        display: flex; /* Display list items horizontally */
    }

    .menu-item {
        font-size: 16px; /* Reduce the font size */
        margin: 0 10px; /* Add some spacing between items */
    }

    .menu-item a {
        text-decoration: none;
        color: #fff; /* Change text color to white */
        background-color: #3498db; /* Set a background color */
        padding: 10px 16px; /* Adjust padding for a circular shape */
        display: inline-block;
        border-radius: 50%; /* Create a circular shape */
        transition: background-color 0.3s, color 0.3s;
    }

    .menu-item a:hover {
        background-color: #ff5733; /* Change color on hover */
    }
</style>
<h2>User</h2>
<ul>
	<li class="menu-item"><a href="CreateUser.php"><strong>Create</strong></a> -Add User</li>
	<li class="menu-item"><a href="ReadUser.php"><strong>Read</strong></a> -Find User</li>
</ul>

<?php
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Users  "; // Retrieve the last 3 created users

    $statement = $connection->prepare($sql);
    $statement->execute();

    $recent_users = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Recent Users</h2>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Address</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recent_users as $user): ?>
            <tr>
                <td><?php echo escape($user["id"]); ?></td>
                <td><?php echo escape($user["customerName"]); ?></td>
                <td><?php echo escape($user["phoneNumber"]); ?></td>
                <td><?php echo escape($user["Email"]); ?></td>
                <td><?php echo escape($user["Address"]); ?></td>
                <td><?php echo escape($user["date"]); ?></td>
                <td><a href="viewUser.php?id=<?php echo escape($user['id']); ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back</a>

<?php require "templates/footer.php"; ?>

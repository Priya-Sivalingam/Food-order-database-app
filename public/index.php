<?php include "templates/header.php"; ?>

<style>
    ul {
        list-style: none;
        padding: 0;
         /* Display list items horizontally */
    }

    .menu-item {
        font-size: 18px; /* Change the font size to your preferred value */
        margin:20px 10px; /* Add some spacing between items */
    }

    .menu-item a {
        text-decoration: none;
        color: #333;
        background-color: #f7f7f7;
        padding: 10px 20px;
        display: inline-block;
        border: 1px solid #333;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .menu-item a:hover {
        background-color: #333;
        color: #fff;
    }
</style>

<ul>
    <li class="menu-item"><a href="home.php"><strong>Home</strong></a></li>
    <li class="menu-item"><a href="Userlogin.php"><strong>User</strong></a></li>
    <li class="menu-item"><a href="Restaurant.php"><strong>Restaurant</strong></a></li>
    <li class="menu-item"><a href="Menu.php"><strong>Menu</strong></a></li>
    <li class="menu-item"><a href="order.php"><strong>Order</strong></a></li>
</ul>

<?php include "templates/footer.php"; ?>

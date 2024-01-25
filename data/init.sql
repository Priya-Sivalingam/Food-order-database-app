CREATE DATABASE uberEats;

use uberEats;

CREATE TABLE users(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	customerName VARCHAR(50) NOT NULL,
	phoneNumber INT(15) NOT NULL,
	Email VARCHAR(50) NOT NULL,
    Address VARCHAR(50) NOT NULL,
    date TIMESTAMP
)

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    delivery_address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    order_date DATE NOT NULL
);

CREATE TABLE restaurant (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(255),
    cuisine_type VARCHAR(100),
    rating DECIMAL(3, 1)
) ENGINE=InnoDB;

CREATE TABLE menuitem (
    id INT PRIMARY KEY AUTO_INCREMENT,
    foodItem VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    mealType VARCHAR(50) NOT NULL,
    cuisineType VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE restaurant_menu (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    restaurant_id INT(11) ,
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(id),
    menuitem_id INT(11) ,
    FOREIGN KEY (menuitem_id) REFERENCES menuitem(id)
) ENGINE=InnoDB;

CREATE TABLE usermenuorder (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    order_id INT(11),
    menuitem_id INT(11),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (order_id) REFERENCES orders (order_id)
);











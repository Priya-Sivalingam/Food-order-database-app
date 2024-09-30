# Simple Food Order Database App
![image](https://github.com/user-attachments/assets/2225290b-b5e6-4169-b08f-2ecb9b8bca03)

![image](https://github.com/user-attachments/assets/77644a57-5e8c-48d2-9189-bf19e0616f64)

![image](https://github.com/user-attachments/assets/6fd91d5c-f67f-4904-8acf-98c969ae6c9e)


## Introduction
The "Simple Food Order Database App" is a 5th-semester Database Management System course project. It is a web application that allows users to interact with a food ordering database. The main objective of this project is to explore and demonstrate the use of SQL queries in a real-world application.This application focus only admin managment side 

## Features

### Admin Features

**Restaurant Management**:
- Admin can view the list of registered restaurants.
- Admin can edit the details of existing restaurants, such as name, address, cuisine type, and rating.
- Admin can create new restaurant entries.
- Admin can remove restaurants from the system.

**Menu Item Management**:
- Admin can view the list of available menu items.
- Admin can edit the details of existing menu items, such as food item name, price, meal type, and cuisine type.
- Admin can add new menu items to the system.
- Admin can remove menu items from the system.

**Order Management**:
- Admin can view the list of all orders placed by users.
- Admin can edit the details of existing orders, such as delivery address and order status.
- Admin can mark orders as completed, cancelled, or in progress.

**User Management**:
- Admin can view the list of registered users.
- Admin can edit the details of existing user accounts, such as name, phone number, email, and address.
- Admin can create new user accounts.
- Admin can deactivate or delete user accounts.

These admin-side features will provide the necessary functionality for the restaurant, menu, order, and user data management within the "Simple Food Order Database App" project.

## Technologies Used
- **Backend**: PHP
- **Frontend**: HTML, CSS
- **Database**: MySQL

## Database Schema
The database schema for this project includes the following tables:

1. `users`
   - `id`: Primary key, auto-increment
   - `customerName`: Customer name
   - `phoneNumber`: Customer phone number
   - `Email`: Customer email address
   - `Address`: Customer address
   - `date`: Timestamp of when the user account was created

2. `orders`
   - `order_id`: Primary key, auto-increment
   - `delivery_address`: Delivery address for the order
   - `phone_number`: Phone number associated with the order
   - `order_date`: Date when the order was placed

3. `restaurant`
   - `id`: Primary key, auto-increment
   - `name`: Restaurant name
   - `address`: Restaurant address
   - `city`: Restaurant city
   - `phone`: Restaurant phone number
   - `email`: Restaurant email
   - `cuisine_type`: Type of cuisine offered by the restaurant
   - `rating`: Restaurant rating

4. `menuitem`
   - `id`: Primary key, auto-increment
   - `foodItem`: Name of the menu item
   - `price`: Price of the menu item
   - `mealType`: Type of meal (e.g., breakfast, lunch, dinner)
   - `cuisineType`: Type of cuisine the menu item belongs to

5. `restaurant_menu`
   - `Id`: Primary key, auto-increment
   - `restaurant_id`: Foreign key referencing `restaurant.id`
   - `menuitem_id`: Foreign key referencing `menuitem.id`

6. `usermenuorder`
   - `id`: Primary key, auto-increment
   - `user_id`: Foreign key referencing `users.id`
   - `order_id`: Foreign key referencing `orders.order_id`
   - `menuitem_id`: Foreign key referencing `menuitem.id`

## SQL Queries
The application utilizes various SQL queries, including:
- `SELECT` to retrieve data from the database
- `INSERT` to add new orders
- `UPDATE` to change the order status
- `CREATE INDEX` to improve query performance
- `CREATE RELATIONSHIP` to establish connections between tables

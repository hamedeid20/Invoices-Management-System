# Invoice Management System
This project is my first attempt at developing a complete application using the Laravel framework. I focused on understanding every aspect of the project to train myself in Laravel. This system serves as a comprehensive platform for managing invoices and is designed to be both a blackbox for web pentesters and a fully functional web project for backend developers.
## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)


## Features
```
.
├── Home Page:
│   ├── User-friendly interface for quick access to all features.
├── Invoices:
│   ├── View all invoices
│   ├── Paid invoices
│   ├── Unpaid invoices
│   ├── Partially paid invoices
│   └── Archived (deleted) invoices
├── Reports:
│   ├── Invoice reports
│   └── Customer reports
├── Users:
│   ├── Manage users
│   └── Manage user roles and permissions
├── Settings:
│   ├── Manage departments
│   └── Manage products
```
Functionalities for Each Section:

    📝 Add
    ✏️ Edit
    👀 View
    🗑️ Delete

## Technologies Used
- HTML
- CSS
- JavaScript
- PHP
- MySQL
- Laravel
## Installation
 1. Clone the repository: <br>
    ```
    git clone https://github.com/hamedeid20/Invoices-Management-System.git
    cd invoice-management-system
    ```
 2. Configure your database in the .env file: <br>
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```
 3. Run database migrations: <br>
    ```
    php artisan migrate
    ```
 4. Seed the database: <br>
    ```
    php artisan db:seed
    ```
 5. Run the development server: <br>
    ```
    php artisan serve
    ```
## Usage
- Visit http://localhost:8000 to access the application.
- Use the navigation menu to explore different sections: Invoices, Reports, Users, and Settings.
- Add, edit, view, and delete records as per your requirements.

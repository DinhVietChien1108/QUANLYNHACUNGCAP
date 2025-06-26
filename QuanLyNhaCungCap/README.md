# Supplier Management System

A web-based application for managing suppliers, items, and orders.

## Features

- Supplier management (add, edit, view, delete)
- Item management (add, edit, view, delete)
- Order management (add, edit, view, delete)
- Category management
- User authentication
- Dashboard with statistics

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache, Nginx, etc.)

## Installation

1. Clone or download this repository to your web server directory
2. Create a MySQL database
3. Import the database schema by visiting `init_db.php` in your browser
4. Configure the database connection in `config/database.php` if needed
5. Access the application through your web browser

## Default Login

- Username: admin
- Password: admin123

## Directory Structure

- `config/` - Configuration files
- `controllers/` - Controller classes
- `models/` - Model classes
- `views/` - View templates
- `helpers/` - Helper functions
- `index.php` - Main entry point
- `database.sql` - Database schema
- `init_db.php` - Database initialization script

## License

This project is licensed under the MIT License.

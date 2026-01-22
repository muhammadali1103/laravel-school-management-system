# School Management System

A complete School Management System built with Laravel Blade templates, Bootstrap 5, and MySQL. Features role-based authentication for Admin, Teacher, and Student with dedicated dashboards and modules.

## Admin Dashboard
![Admin Dashboard](https://github.com/muhammadali1103/laravel-school-management-system/blob/efbc478c54672cf42ad4f6014967ac3b69bd11b7/screenshoots/admin.jpg)

## Teacher Dashboard
![Teacher Dashboard](https://github.com/muhammadali1103/laravel-school-management-system/blob/efbc478c54672cf42ad4f6014967ac3b69bd11b7/screenshoots/teacher.jpg)

## Student Dashboard
![Student Dashboard](https://github.com/muhammadali1103/laravel-school-management-system/blob/efbc478c54672cf42ad4f6014967ac3b69bd11b7/screenshoots/student.jpg)

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM (for asset compilation, optional)

## Installation

### 1. Clone or Use Existing Project
The project is located at: `d:\laravel\school`

### 2. Install Dependencies
```bash
composer install
```

### 3. Set Up Environment
The `.env` file is already configured with:
- Database name: `school_management`
- Database user: `root`
- Database password:

### 4. Create Database
Create a MySQL database named `school_management`:
- Using phpMyAdmin: Create new database
- Using MySQL Workbench: Execute `CREATE DATABASE school_management;`
- Using command line: `mysql -u root -e "CREATE DATABASE school_management;"`

### 5. Run Migrations and Seeders
```bash
php artisan migrate:fresh --seed
```

### 6. Start Development Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Default Login Credentials

### Admin
- Email: `admin@school.com`
- Password: `password`

### Teacher
- Email: `teacher@school.com`
- Password: `password`
-

### Student
- Email: `muhammad.hamza@student.pk`
- Password: `password`


## License

This School Management System is open-source software.

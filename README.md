# School Management System

A complete School Management System built with Laravel 10+, Blade templates, Bootstrap 5, and MySQL. Features role-based authentication for Admin, Teacher, and Student with dedicated dashboards and modules.

## Features

### 🔐 Role-Based Authentication
- **Admin**: Full system access and management
- **Teacher**: Manage classes, take attendance, view students
- **Student**: View attendance, courses, and timetable

### 👨‍💼 Admin Panel
- Dashboard with statistics (Students, Teachers, Courses, Classes, Attendance)
- CRUD operations for Students, Teachers, Courses, and Classes
- Attendance management and reporting
- Fee tracking and payment receipts
- Timetable creation and assignment
- Notifications system
- Fully functional sidebar with active menu highlighting

### 👨‍🏫 Teacher Panel
- Dashboard with assigned classes and attendance summary
- View students in assigned classes
- Mark and update attendance
- View personal timetable
- User profile management

### 👨‍🎓 Student Panel
- Dashboard with attendance percentage and enrolled courses
- View attendance history
- View enrolled courses
- View class timetable
- User profile management

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
- Database password: (empty)

### 4. Create Database
Create a MySQL database named `school_management`:
- Using phpMyAdmin: Create new database
- Using MySQL Workbench: Execute `CREATE DATABASE school_management;`
- Using command line: `mysql -u root -e "CREATE DATABASE school_management;"`

### 5. Run Migrations and Seeders
```bash
php artisan migrate:fresh --seed
```

This will:
- Create all database tables
- Seed roles (Admin, Teacher, Student)
- Create default users with sample data
- Populate courses, classes, and assignments

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
-


## Features Breakdown

### Database Structure
- **Roles**: Admin, Teacher, Student
- **Users**: Authentication and role assignment
- **Students**: Student profiles with parent info
- **Teachers**: Teacher profiles with qualifications
- **Courses**: Course information (name, code, credits)
- **Classes**: Class management with teacher assignment
- **Attendances**: Daily attendance tracking
- **Fees**: Student fee payments and records
- **Timetables**: Class schedules with day/time slots
- **Notifications**: Messaging system

### Middleware
- `AdminMiddleware`: Protects admin routes
- `TeacherMiddleware`: Protects teacher routes
- `StudentMiddleware`: Protects student routes

### Routes
All routes are protected by authentication and role-specific middleware:
- `/admin/*` - Admin panel routes
- `/teacher/*` - Teacher panel routes
- `/student/*` - Student panel routes

### UI/UX
- **Bootstrap 5** for responsive design
- **Bootstrap Icons** for iconography
- Different color themes for each role:
  - Admin: Blue gradient
  - Teacher: Green gradient
  - Student: Purple gradient
- Active menu highlighting
- Responsive sidebar navigation
- Alert messages for user feedback

## Project Structure

```
school/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Teacher/        # Teacher controllers
│   │   │   └── Student/        # Student controllers
│   │   └── Middleware/         # Custom middleware
│   └── Models/                 # Eloquent models
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   └── views/
│       ├── admin/              # Admin views
│       ├── teacher/            # Teacher views
│       └── student/            # Student views
└── routes/
    └── web.php                 # Application routes
```

## Usage

### After Installation

1. Login with any of the default credentials above
2. You will be automatically redirected to your role-specific dashboard
3. Explore the sidebar menu for available features
4. Admin can manage all aspects of the system
5. Teachers can manage their classes and take attendance
6. Students can view their information and progress

### Adding More Data

**Add Students (Admin)**:
1. Navigate to Admin Dashboard → Students
2. Click "Add New Student"
3. Fill in the form and assign classes
4. Submit

**Add Teachers (Admin)**:
1. Navigate to Admin Dashboard → Teachers
2. Click "Add New Teacher"
3. Fill in teacher information
4. Submit

**Create Classes (Admin)**:
1. Navigate to Admin Dashboard → Classes
2. Click "Create Class"
3. Assign teacher and students
4. Submit

## Technology Stack

- **Backend**: Laravel 10+
- **Frontend**: Blade Templates, Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel UI with custom role-based redirection
- **Icons**: Bootstrap Icons

## Security

- Passwords are hashed using bcrypt
- CSRF protection on all forms
- Role-based middleware protection
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating

## Support

For issues or questions:
1. Check that database is created and migrations ran successfully
2. Verify `.env` file configuration
3. Clear cache: `php artisan cache:clear`
4. Clear config: `php artisan config:clear`

## License

This School Management System is open-source software.

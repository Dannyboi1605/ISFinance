# ISFinance - Islamic Microfinance Platform

![ISFinance](https://img.shields.io/badge/Laravel-11-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.0-38bdf8)
![License](https://img.shields.io/badge/License-MIT-green)

A modern, Shariah-compliant microfinance platform for managing interest-free Qard Hasan loans. Built with Laravel 11, TailwindCSS, and designed with a beautiful hot pink theme.

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Seeding Test Data](#seeding-test-data)
- [Running the Application](#running-the-application)
- [User Roles](#user-roles)
- [Project Structure](#project-structure)
- [Development Guidelines](#development-guidelines)
- [Contributing](#contributing)
- [Troubleshooting](#troubleshooting)

---

## ✨ Features

### Current Features (v1.0)
- ✅ **Role-Based Access Control (RBAC)**
  - Admin and Borrower roles
  - Protected routes with middleware
  - Role-specific dashboards

- ✅ **Authentication System**
  - Laravel Breeze integration
  - Email verification
  - Password reset functionality

- ✅ **Modern UI/UX**
  - Hot pink theme (#EC4899)
  - Responsive design (mobile-first)
  - Smooth animations and transitions
  - Card-based layouts

- ✅ **Dashboard Views**
  - Borrower Dashboard (loan stats, quick actions)
  - Admin Dashboard (approval stats, system metrics)
  - Role-based content display

### Planned Features (Future Releases)
- 🔄 Loan application system
- 🔄 Loan approval workflow
- 🔄 Repayment tracking
- 🔄 Smart contract integration (blockchain)
- 🔄 Notification system
- 🔄 Reports and analytics

---

## 🛠️ Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade Templates, TailwindCSS, Alpine.js
- **Database:** PostgreSQL (Supabase) / MySQL / SQLite
- **Authentication:** Laravel Breeze
- **Styling:** TailwindCSS with custom hot pink theme

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x and npm
- **Database:** PostgreSQL / MySQL / SQLite
- **Git**

### Recommended Tools
- **XAMPP** (for Windows users)
- **VS Code** with PHP and Blade extensions
- **Postman** (for API testing in future)

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/ISFinance.git
cd ISFinance
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file with your database credentials:

#### For SQLite (Easiest for local development):
```env
DB_CONNECTION=sqlite
# Comment out or remove these:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=isfinance
# DB_USERNAME=root
# DB_PASSWORD=
```

Then create the database file:
```bash
touch database/database.sqlite
# On Windows: New-Item -Path "database\database.sqlite" -ItemType File
```

#### For MySQL (XAMPP):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=isfinance
DB_USERNAME=root
DB_PASSWORD=
```

#### For PostgreSQL (Supabase):
```env
DB_CONNECTION=pgsql
DB_HOST=your-supabase-host
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

---

## 💾 Database Setup

### Run Migrations

```bash
php artisan migrate
```

This will create all necessary tables including:
- `users` (with `role` column)
- `password_reset_tokens`
- `sessions`
- `cache`
- `jobs`

---

## 🌱 Seeding Test Data

To quickly set up test users for development:

```bash
php artisan db:seed
```

This creates the following test accounts:

| Role | Email | Password | Name |
|------|-------|----------|------|
| Admin | admin@isfinance.com | password | Admin User |
| Borrower | borrower@isfinance.com | password | Borrower User |
| Borrower | john@example.com | password | John Doe |
| Borrower | jane@example.com | password | Jane Smith |

**⚠️ Important:** Change these passwords in production!

---

## 🏃 Running the Application

### 1. Build Frontend Assets

```bash
npm run dev
```

Or for production:
```bash
npm run build
```

### 2. Start Laravel Development Server

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

### 3. Access the Application

- **Landing Page:** http://localhost:8000
- **Login:** http://localhost:8000/login
- **Register:** http://localhost:8000/register
- **Dashboard:** http://localhost:8000/dashboard (after login)

---

## 👥 User Roles

### Borrower
- **Default role** for new registrations
- Can view personal loan stats
- Can apply for loans (coming soon)
- Can track repayments (coming soon)
- **Dashboard:** `/borrower/dashboard`

### Admin
- Manually assigned role
- Can approve/reject loans (coming soon)
- Can view all system statistics
- Can manage users (coming soon)
- **Dashboard:** `/admin/dashboard`

### Changing User Role

To make a user an admin, update the database:

```sql
UPDATE users SET role = 'admin' WHERE email = 'user@example.com';
```

Or use tinker:
```bash
php artisan tinker
>>> $user = User::where('email', 'user@example.com')->first();
>>> $user->role = 'admin';
>>> $user->save();
```

---

## 📁 Project Structure

```
ISFinance/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php      # Admin role protection
│   │       └── BorrowerMiddleware.php   # Borrower role protection
│   └── Models/
│       └── User.php
├── bootstrap/
│   └── app.php                          # Middleware registration
├── database/
│   ├── migrations/
│   │   └── 2025_12_12_150613_add_role_to_users_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php               # Test user seeder
├── resources/
│   └── views/
│       ├── admin/
│       │   └── dashboard.blade.php      # Admin dashboard
│       ├── borrower/
│       │   └── dashboard.blade.php      # Borrower dashboard
│       ├── layouts/
│       │   ├── app.blade.php            # Main layout with hot pink theme
│       │   └── navigation.blade.php     # Navbar with gradient
│       ├── home.blade.php               # Unified role-based dashboard
│       └── welcome.blade.php            # Landing page
├── routes/
│   └── web.php                          # All routes with RBAC
└── README.md
```

---

## 🔧 Development Guidelines

### Code Style
- Follow **PSR-12** coding standards
- Use **meaningful variable names**
- Add **comments** for complex logic
- Keep **functions small** and focused

### Git Workflow
1. Create a new branch for each feature:
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. Make commits with clear messages:
   ```bash
   git commit -m "feat: add loan application form"
   ```

3. Push and create a Pull Request:
   ```bash
   git push origin feature/your-feature-name
   ```

### Commit Message Convention
- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation changes
- `style:` - Code style changes (formatting)
- `refactor:` - Code refactoring
- `test:` - Adding tests
- `chore:` - Maintenance tasks

### Testing
- Write tests for new features
- Run tests before committing:
  ```bash
  php artisan test
  ```

---

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

### Pull Request Guidelines
- Provide a clear description of changes
- Reference any related issues
- Ensure all tests pass
- Update documentation if needed

---

## 🐛 Troubleshooting

### Common Issues

#### 1. **PostgreSQL Driver Not Found**
```
Error: could not find driver (Connection: pgsql)
```

**Solution:**
- Enable `pdo_pgsql` extension in `php.ini`
- Or switch to MySQL/SQLite for local development

#### 2. **Vite/NPM Build Errors**
```
Error: Cannot find module '@vitejs/plugin-laravel'
```

**Solution:**
```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

#### 3. **Permission Denied (Storage/Cache)**
```
Error: The stream or file could not be opened
```

**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
```

#### 4. **Migration Already Exists**
```
Error: Migration already exists
```

**Solution:**
```bash
php artisan migrate:fresh --seed
```
**⚠️ Warning:** This will delete all data!

---

## 📞 Support

For issues and questions:
- Create an issue on GitHub
- Contact the development team
- Check the documentation

---

## 📄 License

This project is licensed under the MIT License.

---

## 👨‍💻 Development Team

- **Project Lead:** [Your Name]
- **Contributors:** [Team Members]

---

## 🎯 Roadmap

### Phase 1: Foundation (✅ Completed)
- [x] Authentication system
- [x] Role-based access control
- [x] Dashboard views
- [x] Hot pink theme implementation

### Phase 2: Core Features (🔄 In Progress)
- [ ] Loan application system
- [ ] Admin approval workflow
- [ ] Repayment tracking
- [ ] User management

### Phase 3: Advanced Features (📅 Planned)
- [ ] Smart contract integration
- [ ] Blockchain transaction logging
- [ ] Notification system
- [ ] Reports and analytics
- [ ] Multi-language support

---

## 🙏 Acknowledgments

- Laravel Team for the amazing framework
- TailwindCSS for the utility-first CSS framework
- Laravel Breeze for authentication scaffolding

---

**Built with ❤️ for Islamic Microfinance**

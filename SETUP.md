# 🚀 Quick Setup Guide for ISFinance

This guide will help you get ISFinance running on your local machine in **under 10 minutes**.

## ✅ Prerequisites Checklist

Before starting, make sure you have:

- [ ] **PHP 8.2+** installed (`php -v` to check)
- [ ] **Composer** installed (`composer -V` to check)
- [ ] **Node.js 18+** and npm (`node -v` and `npm -v` to check)
- [ ] **Git** installed (`git --version` to check)
- [ ] A **database** (PostgreSQL, MySQL, or SQLite)

---

## 📥 Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/ISFinance.git
cd ISFinance
```

---

## 📦 Step 2: Install Dependencies

### Install PHP Dependencies
```bash
composer install
```

### Install Node Dependencies
```bash
npm install
```

---

## ⚙️ Step 3: Environment Setup

### Copy Environment File
```bash
# On Mac/Linux
cp .env.example .env

# On Windows (PowerShell)
Copy-Item .env.example .env
```

### Generate Application Key
```bash
php artisan key:generate
```

### Configure Database

Edit `.env` file and choose ONE of these options:

#### **Option A: SQLite (Easiest - Recommended for beginners)**

1. In `.env`, set:
   ```env
   DB_CONNECTION=sqlite
   ```

2. Comment out or remove these lines:
   ```env
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=isfinance
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

3. Create SQLite database file:
   ```bash
   # On Mac/Linux
   touch database/database.sqlite
   
   # On Windows (PowerShell)
   New-Item -Path "database\database.sqlite" -ItemType File
   ```

#### **Option B: MySQL (XAMPP)**

1. Start XAMPP and ensure MySQL is running

2. In `.env`, set:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=isfinance
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Create database in phpMyAdmin or via command:
   ```sql
   CREATE DATABASE isfinance;
   ```

#### **Option C: PostgreSQL (Supabase)**

1. Get your Supabase credentials

2. In `.env`, set:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=your-project.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=your-password
   ```

3. **Important for PostgreSQL users:**
   - Enable `pdo_pgsql` extension in `php.ini`
   - Uncomment: `;extension=pdo_pgsql`
   - Restart your web server

---

## 🗄️ Step 4: Database Migration & Seeding

### Run Migrations
```bash
php artisan migrate
```

### Seed Test Data
```bash
php artisan db:seed
```

This creates test accounts:
- **Admin:** admin@isfinance.com / password
- **Borrower:** borrower@isfinance.com / password

---

## 🎨 Step 5: Build Frontend Assets

### For Development (with hot reload)
```bash
npm run dev
```

Keep this terminal running!

### For Production Build
```bash
npm run build
```

---

## 🚀 Step 6: Start the Application

### In a NEW terminal, run:
```bash
php artisan serve
```

### Access the Application

Open your browser and visit:
- **Landing Page:** http://localhost:8000
- **Login:** http://localhost:8000/login
- **Register:** http://localhost:8000/register

---

## 🧪 Step 7: Test the Setup

### Login as Admin
1. Go to http://localhost:8000/login
2. Email: `admin@isfinance.com`
3. Password: `password`
4. You should see the **Admin Dashboard** with hot pink theme

### Login as Borrower
1. Logout (if logged in)
2. Email: `borrower@isfinance.com`
3. Password: `password`
4. You should see the **Borrower Dashboard**

---

## ✅ Verification Checklist

After setup, verify everything works:

- [ ] Landing page loads with hot pink theme
- [ ] Can register a new account
- [ ] Can login with test accounts
- [ ] Admin sees admin dashboard
- [ ] Borrower sees borrower dashboard
- [ ] Navigation bar is hot pink gradient
- [ ] Cards have hover effects
- [ ] No console errors in browser

---

## 🐛 Common Issues & Solutions

### Issue 1: "could not find driver (pgsql)"

**Solution:**
- Enable PostgreSQL extension in `php.ini`
- OR switch to SQLite/MySQL

### Issue 2: "npm run dev" fails

**Solution:**
```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### Issue 3: "Class 'Database\Seeders\UserSeeder' not found"

**Solution:**
```bash
composer dump-autoload
php artisan db:seed
```

### Issue 4: "SQLSTATE[HY000] [2002] Connection refused"

**Solution:**
- Check if database server is running (MySQL/PostgreSQL)
- Verify database credentials in `.env`
- For SQLite, ensure `database/database.sqlite` exists

### Issue 5: "419 Page Expired" on login

**Solution:**
```bash
php artisan cache:clear
php artisan config:clear
```

---

## 🔄 Resetting the Database

If you need to start fresh:

```bash
# WARNING: This deletes ALL data!
php artisan migrate:fresh --seed
```

---

## 📚 Next Steps

Once setup is complete:

1. Read [README.md](README.md) for full documentation
2. Check [CONTRIBUTING.md](CONTRIBUTING.md) for development guidelines
3. Create a new branch for your work:
   ```bash
   git checkout -b feature/your-feature-name
   ```

---

## 💡 Tips for Development

### Running Both Servers

You need TWO terminals running:

**Terminal 1:** Frontend (Vite)
```bash
npm run dev
```

**Terminal 2:** Backend (Laravel)
```bash
php artisan serve
```

### Quick Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run tests
php artisan test

# Check routes
php artisan route:list

# Access tinker (Laravel REPL)
php artisan tinker
```

---

## 🆘 Need Help?

If you're stuck:

1. Check the [Troubleshooting section in README.md](README.md#troubleshooting)
2. Search existing [GitHub Issues](https://github.com/yourusername/ISFinance/issues)
3. Ask your team lead
4. Create a new issue with:
   - What you tried
   - Error messages
   - Your environment (OS, PHP version, etc.)

---

## 🎉 You're All Set!

Welcome to the ISFinance development team! 

**Happy coding! 🚀**

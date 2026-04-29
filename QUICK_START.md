# ⚡ Quick Start Guide - CatSU GAD Portal

Get the CatSU GAD Portal running in **5 minutes** on your local machine!

---

## 🔧 Prerequisites

Before starting, ensure you have installed:

- ✅ **PHP 8.2+** - Check: `php --version`
- ✅ **Composer** - Check: `composer --version`
- ✅ **Node.js 18+** - Check: `node --version`
- ✅ **MySQL 8.0+** - Check: `mysql --version` (or use XAMPP)
- ✅ **Git** - Check: `git --version`

---

## 🚀 Installation (5 Steps)

### Step 1: Clone Repository
```bash
git clone https://github.com/Fr4nzJ/catsugad.git
cd catsugad
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Database Setup
```bash
# Make sure MySQL is running (XAMPP, Docker, etc.)

# Run migrations
php artisan migrate

# (Optional) Seed demo data
php artisan db:seed
```

### Step 5: Start Development Server
```bash
# Option A: Simple PHP server
php artisan serve

# Option B: Full dev environment (includes queue and logs)
composer run dev
```

**✅ Done!** Open http://localhost:8000

---

## 📝 Quick Setup with XAMPP

If using XAMPP:

```bash
# 1. Clone to htdocs
cd C:\xampp\htdocs
git clone https://github.com/Fr4nzJ/catsugad.git
cd catsugad

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Setup environment
copy .env.example .env
php artisan key:generate

# 5. Configure database in .env
# DB_DATABASE=catsugad
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Create database
# Open phpMyAdmin (localhost/phpmyadmin)
# Create new database: catsugad

# 7. Run migrations
php artisan migrate

# 8. Build frontend
npm run build

# 9. Start server
php artisan serve
```

---

## 🔐 Admin Login

### Create Admin User

```bash
php artisan tinker
```

Then type:
```php
App\Models\User::create([
    'name' => 'Administrator',
    'email' => 'admin@catsugad.edu.ph',
    'password' => Hash::make('password123'),
]);
exit
```

### Login to Dashboard

- URL: http://localhost:8000/admin/login
- Email: `admin@catsugad.edu.ph`
- Password: `password123`

---

## 📁 Important Directories

```
catsugad/
├── app/                    # Application logic
├── resources/views/        # HTML templates
├── routes/                 # URL routes
├── database/migrations/    # Database schema
├── public/                 # Publicly accessible files
└── storage/                # Uploads and cache
```

---

## 📌 Useful Commands

### Development
```bash
php artisan serve              # Start dev server
npm run dev                    # Watch CSS/JS changes
composer run dev               # Full dev environment
```

### Database
```bash
php artisan migrate            # Run migrations
php artisan migrate:reset      # Reset database
php artisan db:seed            # Seed demo data
php artisan tinker             # Interactive shell
```

### Cache & Optimization
```bash
php artisan cache:clear        # Clear cache
php artisan route:clear        # Clear route cache
php artisan config:clear       # Clear config cache
php artisan optimize:clear     # Clear all
```

### Production Build
```bash
npm run build                  # Production build
php artisan migrate --force    # Run migrations
php artisan config:cache       # Cache config
```

---

## 🐛 Troubleshooting

### Issue: "No application encryption key has been specified"
**Solution**: Run `php artisan key:generate`

### Issue: "SQLSTATE[HY000]: General error: 1030 Got error..."
**Solution**: Check MySQL is running and database exists

### Issue: "npm command not found"
**Solution**: Install Node.js from https://nodejs.org

### Issue: "Composer command not found"
**Solution**: Install Composer from https://getcomposer.org

### Issue: "Class 'App\Models\User' not found"
**Solution**: Run `composer dump-autoload` then `php artisan migrate`

### Issue: Port 8000 already in use
**Solution**: Use `php artisan serve --port=8001`

### Issue: File upload errors
**Solution**: Run `php artisan storage:link` and create upload directories:
```bash
mkdir -p storage/app/public/announcements
mkdir -p storage/app/public/banners
mkdir -p storage/app/public/gad-submissions
mkdir -p storage/app/public/gad-guidelines
```

---

## 🎯 Explore Features

### Public Website
- Homepage: http://localhost:8000
- Announcements: http://localhost:8000/announcements
- Programs: http://localhost:8000/programs
- Documents: http://localhost:8000/documents
- Accomplishments: http://localhost:8000/accomplishment-report

### Admin Dashboard
- Dashboard: http://localhost:8000/admin/dashboard
- GAD Submissions: http://localhost:8000/admin/gad-submissions
- GAD Agendas: http://localhost:8000/admin/gad-agendas
- GAD Guidelines: http://localhost:8000/admin/gad-guidelines
- Statistics: http://localhost:8000/admin/statistics
- Announcements: http://localhost:8000/admin/announcements
- And more...

---

## 📚 Next Steps

1. **Read Documentation**
   - [README_COMPREHENSIVE.md](README_COMPREHENSIVE.md)
   - [GAD_MODULES_IMPLEMENTATION.md](GAD_MODULES_IMPLEMENTATION.md)
   - [DEPLOYMENT_STATUS.md](DEPLOYMENT_STATUS.md)

2. **Customize**
   - Update `app/name` in `.env`
   - Customize colors in `resources/css`
   - Edit templates in `resources/views`

3. **Add Content**
   - Create statistics in admin panel
   - Upload banners
   - Add announcements
   - Manage programs

4. **Deploy** (when ready)
   - Follow [DEPLOYMENT_STATUS.md](DEPLOYMENT_STATUS.md)
   - Choose hosting provider
   - Deploy to production

---

## 💡 Tips

- **Auto-refresh**: Use `npm run dev` to watch for CSS/JS changes
- **Debug**: Use `php artisan tinker` for interactive testing
- **Logs**: Check `storage/logs/laravel.log` for errors
- **Admin tools**: Use Laravel Debugbar (installed in dev mode)

---

## 🆘 Need Help?

- **Documentation**: See [README_COMPREHENSIVE.md](README_COMPREHENSIVE.md)
- **GitHub Issues**: https://github.com/Fr4nzJ/catsugad/issues
- **Email**: gad@catsugad.edu.ph

---

**Happy coding! 🚀**

*Last Updated: April 29, 2026*

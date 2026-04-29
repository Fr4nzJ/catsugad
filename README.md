# 🎓 CatSU GAD Portal - Gender and Development Management System

A comprehensive **Laravel 12** web application for managing Gender and Development (GAD) initiatives at Catanduanes State University (CatSU). This system integrates the latest 2026 PCW and DILG updates for decentralized GAD planning, reporting, and guideline management.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Modules](#project-modules)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Database Schema](#database-schema)
- [Deployment](#deployment)
- [Directory Structure](#directory-structure)
- [Contributing](#contributing)
- [Support](#support)

---

## 📖 Overview

The **CatSU GAD Portal** is a comprehensive management system designed to:

- **Centralize GAD data** - Manage all gender and development initiatives in one place
- **Decentralize processing** - Enable LGUs to manage and review GAD plans locally
- **Track progress** - Monitor accomplishment reports and strategic agenda implementation
- **Distribute guidelines** - Publish and manage updated GAD policies from PCW/DILG
- **Report analytics** - Generate insights and statistics on GAD initiatives

This system serves **administrators, LGU representatives, and end-users** with a user-friendly interface while maintaining data security and integrity.

---

## ✨ Features

### Public Features

- **📢 Announcements Hub**
  - View latest news and announcements
  - Filter by publication date
  - Responsive card layout

- **📊 Statistics Dashboard**
  - Display key GAD metrics
  - Interactive stat cards
  - Visual indicators

- **📈 Charts & Analytics**
  - Interactive dashboard charts
  - Data visualization
  - Performance tracking

- **🏆 Accomplishment Reports**
  - Browse completed GAD initiatives
  - Filter by year and college
  - Download reports

- **📁 Resource Library**
  - GAD guidelines and memoranda
  - Policy documents
  - Strategic plans and agendas
  - Searchable database

- **👥 Organizational Structure**
  - View team members
  - Role-based hierarchy
  - Contact information

- **🎯 Programs & Services**
  - Browse available programs
  - Detailed program information
  - Implementation timelines

### Admin Dashboard Features

#### **1. Statistics Management**
- Create, read, update, delete statistics
- Color-coded badges
- Icon support
- Dashboard display

#### **2. Banner Management**
- Upload header banners
- Set display order
- Schedule visibility
- Responsive images

#### **3. Accomplishment Reports**
- Full CRUD operations
- Attach PDF/DOCX documents
- Filter by year and college
- Track report status

#### **4. Chart Management**
- Create data visualization charts
- Set chart types and data
- Dashboard integration
- Update frequency control

#### **5. Announcements Management**
- Create and publish announcements
- Image upload support
- Featured announcements
- Publish scheduling

#### **6. Organization Members**
- Manage team structure
- Role-based grouping
- Profile management
- Photo uploads

#### **7. Programs Management**
- Full program CRUD
- Program descriptions
- Timeline tracking
- Beneficiary management

#### **8. Documents Management**
- Upload and organize documents
- Category-based classification
- Public access control
- Download tracking

#### **9. NEW - GAD Submissions** (2026 Update A)
- LGU-based GAD processing
- Workflow status tracking (Draft → Submitted → Under Review → Approved/Rejected)
- Document attachment support
- Remarks and feedback
- Pagination and filtering

#### **10. NEW - GAD Agendas** (2026 Update B)
- Strategic plan management (2026-2031)
- Objectives and strategies definition
- Organization/LGU assignment
- Status tracking (Active/Inactive)

#### **11. NEW - GAD Guidelines** (2026 Update C)
- Policy and guideline distribution
- Category management (Memorandum, Circular, Event Guide, Policy)
- Document library
- Release date tracking
- Downloadable resources

---

## 🛠 Technology Stack

### Backend
- **Framework**: Laravel 12.0+
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+ (configurable)
- **Authentication**: Laravel Breeze
- **Mail Service**: SendGrid

### Frontend
- **CSS Framework**: Bulma 0.9.4
- **Icons**: Font Awesome 6.4.0
- **JavaScript**: Alpine.js 3.x
- **Charts**: Chart.js 4.4.0
- **Build Tool**: Vite 7.0+
- **CSS Preprocessor**: Tailwind CSS 4.0

### Development Tools
- **Package Manager**: Composer + NPM
- **Testing**: PHPUnit 11.5+
- **Code Quality**: Laravel Pint
- **Development Server**: Laravel Sail / PHP CLI

---

## 📦 Project Modules

### Core Modules

1. **Home Dashboard**
   - Public landing page
   - Statistics display
   - Quick links
   - Featured content

2. **About Section**
   - Mission & Vision
   - Background information
   - Organizational chart
   - Laws & issuances
   - Definitions & terms

3. **GAD Planning & Budgeting**
   - Resource information
   - Planning guidelines
   - Budget allocation info

### Data Management Modules

4. **Statistics Module**
   - Dashboard metrics
   - Color-coded display
   - Icon support

5. **Announcements Module**
   - News publishing
   - Date filtering
   - Featured posts

6. **Accomplishment Reports**
   - Report management
   - Year-based filtering
   - Document storage

7. **Organization Structure**
   - Team hierarchy
   - Role grouping
   - Member profiles

8. **Programs Module**
   - Program listing
   - Detailed descriptions
   - Timeline tracking

9. **Documents Module**
   - File management
   - Category organization
   - Public access control

### NEW - GAD 2026 Modules

10. **GAD Submissions** (LGU Processing)
    - Decentralized workflow
    - Status tracking
    - Document management

11. **GAD Agendas** (Strategic Planning)
    - Long-term planning (2026-2031)
    - Objectives & strategies
    - Status management

12. **GAD Guidelines** (Policy Distribution)
    - Guideline management
    - Policy distribution
    - Document library

---

## 💻 System Requirements

### Minimum Requirements
- **PHP**: 8.2 or higher
- **MySQL**: 8.0 or higher (or compatible)
- **Node.js**: 18.0 or higher
- **Composer**: 2.0 or higher
- **Disk Space**: 1GB minimum
- **RAM**: 512MB minimum

### Recommended Requirements
- **PHP**: 8.3+
- **MySQL**: 8.0+
- **Node.js**: 20+
- **Disk Space**: 2GB+
- **RAM**: 2GB+
- **Web Server**: Apache 2.4 or Nginx

### Optional Services
- **Mail Service**: SendGrid (for email notifications)
- **Caching**: Redis (for performance optimization)
- **CDN**: For static file delivery

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Fr4nzJ/catsugad.git
cd catsugad
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment example
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

```bash
# Create database
# MySQL: CREATE DATABASE catsugad;

# Run migrations
php artisan migrate

# (Optional) Seed demo data
php artisan db:seed
```

### 5. Storage Configuration

```bash
# Link public storage
php artisan storage:link

# Create storage directories
mkdir -p storage/app/public/announcements
mkdir -p storage/app/public/banners
mkdir -p storage/app/public/gad-submissions
mkdir -p storage/app/public/gad-guidelines
```

### 6. Build Frontend Assets

```bash
# Development build
npm run dev

# Production build
npm run build
```

### 7. Start Development Server

```bash
# Method 1: Built-in PHP server
php artisan serve

# Method 2: Full development environment (includes queue and logs)
composer run dev
```

**Access the application**: http://localhost:8000

---

## ⚙️ Configuration

### Environment Variables

Edit `.env` file with your configuration:

```env
# Application
APP_NAME="CatSU GAD"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=catsugad
DB_USERNAME=root
DB_PASSWORD=

# Mail (SendGrid)
MAIL_MAILER=sendgrid
MAIL_FROM_ADDRESS=noreply@catsugad.edu.ph
SENDGRID_API_KEY=your_sendgrid_key

# Session
SESSION_DOMAIN=null
SESSION_SECURE_COOKIES=false

# Cache & Queue (optional)
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Admin Login

The system uses Laravel Breeze for authentication. Create an admin account:

```bash
php artisan tinker
```

Then create a user:

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@catsugad.edu.ph',
    'password' => Hash::make('password123'),
]);
```

---

## 📖 Usage

### Accessing the System

**Public Site**
- URL: `http://localhost:8000`
- Accessible to everyone
- No authentication required

**Admin Dashboard**
- URL: `http://localhost:8000/admin/login`
- Login with credentials
- Admin access only

### Admin Dashboard Navigation

1. **Dashboard** - Main overview
2. **Management Section**
   - Statistics
   - Banners
   - Accomplishment Reports
   - Charts
   - Announcements
   - Organization Members
   - Programs
   - Documents

3. **GAD Modules Section** (NEW)
   - GAD Submissions
   - GAD Agendas
   - GAD Guidelines

### Basic CRUD Operations

**Create**: Click "Add [Item]" button → Fill form → Submit

**Read**: View list in table/cards format

**Update**: Click edit button → Modify → Save

**Delete**: Click delete button → Confirm → Item removed

---

## 🗄️ Database Schema

### Core Tables

#### Users
```sql
- id, name, email, password, timestamps
```

#### Statistics
```sql
- id, value, label, description, icon, color, timestamps
```

#### Page Banners
```sql
- id, title, description, image_path, sort_order, timestamps
```

#### Announcements
```sql
- id, title, content, image_path, published_at, timestamps
```

#### Accomplishment Reports
```sql
- id, title, college, fiscal_year, status, remarks, document_path, timestamps
```

#### Charts
```sql
- id, title, chart_type, chart_data, timestamps
```

#### Organization Members
```sql
- id, name, position, role_group, bio, image_path, sort_order, timestamps
```

#### Programs
```sql
- id, program_name, description, start_date, end_date, status, timestamps
```

#### Documents
```sql
- id, title, category, file_path, description, timestamps
```

#### GAD Submissions (NEW)
```sql
- id, title, lgu_name, fiscal_year, status, remarks, document_path, timestamps
```

#### GAD Agendas (NEW)
```sql
- id, agenda_title, organization, start_year, end_year, objectives, strategies, status, timestamps
```

#### GAD Guidelines (NEW)
```sql
- id, title, description, category, release_date, file_path, release_year, timestamps
```

---

## 🌐 Deployment

### Current Status

**Repository**: https://github.com/Fr4nzJ/catsugad  
**Status**: Development/Local Only  
**Live Deployment**: ❌ Not currently deployed online

### Deployment Guide

The application **has not been deployed online yet**. To deploy in the future, follow these steps:

#### Option 1: Traditional Shared Hosting

**Requirements:**
- PHP 8.2+ support
- MySQL database
- SSH access
- Composer pre-installed or install via SSH

**Steps:**

1. Upload files via FTP/SFTP
2. SSH into server and run:
   ```bash
   composer install --no-dev
   npm install --production
   npm run build
   php artisan migrate --force
   php artisan storage:link
   ```
3. Configure `.env` with production values
4. Set `APP_ENV=production` and `APP_DEBUG=false`
5. Configure web server to serve `public/` directory
6. Set proper file permissions: `chmod 755 storage bootstrap/cache`

#### Option 2: Cloud Platforms (Recommended)

**Heroku**:
```bash
heroku create catsugad
heroku addons:create heroku-postgresql:hobby-dev
git push heroku main
heroku run php artisan migrate
```

**AWS / DigitalOcean / Linode**:
- Use Laravel-specific deployment guides
- Configure auto-scaling
- Set up CDN for static files
- Enable HTTPS/SSL

**Laravel Forge / Vapor**:
- One-click deployment
- Automatic backups
- Built-in monitoring

#### Option 3: Docker Containerization

```dockerfile
FROM php:8.2-apache
# ... see Docker setup guide
```

Deploy to:
- Docker Hub
- AWS ECS
- Google Cloud Run
- Azure Container Instances

### Pre-Deployment Checklist

- [ ] `.env` configured for production
- [ ] `APP_KEY` generated
- [ ] Database migrated
- [ ] `APP_DEBUG=false`
- [ ] HTTPS/SSL enabled
- [ ] Email service configured (SendGrid)
- [ ] Storage linked and permissions set
- [ ] Backups configured
- [ ] Monitoring enabled
- [ ] Rate limiting configured

---

## 📁 Directory Structure

```
catsugad/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Web controllers
│   │   ├── Controllers/Admin/   # Admin controllers
│   │   └── Middleware/          # Custom middleware
│   ├── Models/                  # Eloquent models
│   ├── Casts/                   # Custom casts
│   └── Providers/               # Service providers
├── bootstrap/
│   └── app.php                  # Bootstrap application
├── config/                      # Configuration files
├── database/
│   ├── migrations/              # Database migrations
│   ├── factories/               # Model factories
│   └── seeders/                 # Database seeders
├── public/
│   ├── index.php                # Entry point
│   ├── css/                     # Compiled CSS
│   ├── js/                      # Compiled JS
│   ├── images/                  # Public images
│   └── build/                   # Vite build output
├── resources/
│   ├── css/                     # Source stylesheets
│   ├── js/                      # Source scripts
│   └── views/
│       ├── layouts/             # Layout templates
│       ├── admin/               # Admin views
│       └── ...                  # Public views
├── routes/
│   ├── web.php                  # Web routes
│   └── console.php              # Console commands
├── storage/
│   ├── app/public/              # Public file uploads
│   ├── framework/               # Framework cache
│   └── logs/                    # Application logs
├── tests/
│   ├── Feature/                 # Feature tests
│   └── Unit/                    # Unit tests
├── .env.example                 # Example environment
├── composer.json                # PHP dependencies
├── package.json                 # Node dependencies
├── vite.config.js              # Vite configuration
├── phpunit.xml                 # PHPUnit configuration
└── README.md                   # This file
```

---

## 🤝 Contributing

Contributions are welcome! To contribute:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** changes (`git commit -m 'Add amazing feature'`)
4. **Push** to branch (`git push origin feature/amazing-feature`)
5. **Open** a Pull Request

### Development Guidelines

- Follow Laravel conventions
- Use PSR-12 code style
- Add tests for new features
- Update documentation
- Test on multiple browsers

---

## 🧪 Testing

Run tests with:

```bash
# Run all tests
npm test

# Run specific test file
npm test tests/Feature/ControllerTest.php

# Run with coverage
npm test -- --coverage
```

---

## 📝 Documentation Files

- [GAD_MODULES_IMPLEMENTATION.md](GAD_MODULES_IMPLEMENTATION.md) - 2026 GAD module details
- [IMPLEMENTATION_GUIDE.md](IMPLEMENTATION_GUIDE.md) - Module implementation guide
- [ACCOMPLISHMENT_REPORTS_SETUP.md](ACCOMPLISHMENT_REPORTS_SETUP.md) - Accomplishment reports setup
- [ROUTES_IMPLEMENTATION_COMPLETE.md](ROUTES_IMPLEMENTATION_COMPLETE.md) - Route documentation
- [TESTING_AND_API_REFERENCE.md](TESTING_AND_API_REFERENCE.md) - Testing guide
- [BLADE_SNIPPETS.md](BLADE_SNIPPETS.md) - Blade template snippets

---

## 🐛 Bug Reports & Issues

To report a bug or request a feature:

1. Check existing issues on GitHub
2. Create a new issue with:
   - Clear title
   - Detailed description
   - Steps to reproduce
   - Expected vs actual behavior
   - Screenshots (if applicable)

---

## 📧 Support

For support, questions, or inquiries:

- **Email**: gad@catsugad.edu.ph
- **GitHub**: https://github.com/Fr4nzJ/catsugad/issues
- **Repository**: https://github.com/Fr4nzJ/catsugad

---

## 📄 License

This project is open-source software licensed under the MIT license. See the LICENSE file for details.

---

## 👥 Authors

- **Developer**: Fr4nzJ (GitHub)
- **Institution**: Catanduanes State University (CatSU)
- **Version**: 1.0.0 (with 2026 GAD Updates)
- **Last Updated**: April 29, 2026

---

## 🎯 Project Status

| Status | Details |
|--------|---------|
| **Development** | ✅ Active |
| **Testing** | ✅ In Progress |
| **Documentation** | ✅ Complete |
| **Deployment** | ❌ Not Online |
| **Maintenance** | ✅ Ongoing |
| **Latest Features** | 2026 GAD Modules Integrated |

---

## 📌 Changelog

### Version 1.0.0 (Current)
- ✅ Core modules implemented
- ✅ Admin dashboard functional
- ✅ Public website live (locally)
- ✅ 2026 GAD modules integrated
- ✅ Full CRUD for all data types
- ✅ Comprehensive documentation

### Future Roadmap
- [ ] Online deployment
- [ ] Mobile app
- [ ] Advanced analytics dashboard
- [ ] Real-time notifications
- [ ] API endpoints
- [ ] Multi-language support
- [ ] Advanced reporting tools

---

## 🙏 Acknowledgments

- **Laravel Framework** - For the robust web framework
- **Bulma CSS** - For responsive UI framework
- **Font Awesome** - For beautiful icons
- **Chart.js** - For data visualization
- **SendGrid** - For email services
- **Catanduanes State University** - For the GAD initiative

---

**For more information, visit**: https://github.com/Fr4nzJ/catsugad

---

*Last Updated: April 29, 2026 | Version: 1.0.0*

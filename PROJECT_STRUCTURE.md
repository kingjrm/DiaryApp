# DiaryApp - Project Structure

## Overview

DiaryApp has been reorganized with a clean, scalable structure following MVC principles. The application no longer uses the `/public` folder - instead, all requests route through a single `index.php` entry point at the root level.

## Directory Structure

```
DiaryApp/
├── index.php                 # Main entry point - all requests route through here
├── .htaccess                 # URL rewriting rules (Apache)
├── .env                      # Environment variables (database, mail, etc.)
├── README.md                 # This file
│
├── config/                   # Application configuration
│   ├── app.php              # Core app settings, session, CSRF protection
│   ├── database.php         # Database connection
│   └── mail.php             # Email/SMTP configuration
│
├── app/                      # Application logic
│   ├── controllers/         # Request handlers
│   │   ├── AuthController.php
│   │   ├── DiaryController.php
│   │   ├── MoodController.php
│   │   ├── UploadController.php
│   │   └── OTPController.php
│   │
│   ├── models/              # Data models & database interaction
│   │   ├── User.php
│   │   ├── Diary.php
│   │   ├── Image.php
│   │   ├── Mood.php
│   │   ├── OTP.php
│   │   └── UserPreferences.php
│   │
│   └── views/               # HTML templates
│       ├── landing/         # Landing page
│       │   └── index.php
│       ├── auth/            # Authentication pages
│       │   ├── login.php
│       │   ├── register.php
│       │   └── verify-otp.php
│       ├── diary/           # Diary pages
│       │   ├── index.php    # Main diary view
│       │   ├── view.php     # View single entry
│       │   ├── edit.php     # Edit entry
│       │   ├── create.php   # Create new entry
│       │   └── calendar.php # Calendar view
│       └── components/      # Reusable components
│           ├── header.php
│           ├── diary_header.php
│           └── footer.php
│
├── routes/                  # Route definitions
│   ├── web.php             # Web page routes
│   └── api.php             # AJAX/API routes
│
├── middleware/              # Middleware classes
│   └── auth.php            # Authentication middleware
│
├── helpers/                 # Utility files
│   ├── functions.php       # Common helper functions
│   └── Router.php          # Request routing class
│
├── storage/                # Application storage
│   ├── sessions/           # Session files
│   ├── logs/               # Application logs
│   ├── cache/              # Cached data
│   └── temp_uploads/       # Temporary file uploads
│
├── public/                 # Static assets (CSS, JS, images)
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/            # User-uploaded images
│
└── vendor/                 # Composer dependencies (PHPMailer, etc.)
```

## How It Works

### Entry Point Flow

1. **Request** → `index.php` (root level)
2. **Configuration** → Loads config files and environment
3. **Routing** → Matches URL to routes defined in `/routes`
4. **Controller** → Executes appropriate controller method
5. **View** → Renders template with data
6. **Response** → Sends HTML/JSON to client

### URL Structure

With the new structure, URLs follow this pattern:

```
http://localhost/DiaryApp/index.php                   → Landing page
http://localhost/DiaryApp/index.php?url=/login        → Login page
http://localhost/DiaryApp/index.php?url=/diary        → Main diary
http://localhost/DiaryApp/index.php?url=/diary/create → Create entry
http://localhost/DiaryApp/index.php?url=/diary/view/5 → View entry #5
http://localhost/DiaryApp/index.php?url=/diary/edit/5 → Edit entry #5
http://localhost/DiaryApp/index.php?url=/api/autosave → Auto-save endpoint
```

**Note**: For clean URLs without `index.php`, see [URL_STRUCTURE.md](URL_STRUCTURE.md) for optional `.htaccess` configuration.

### Configuration

All configuration is centralized in the `.env` file:

```env
APP_URL=http://localhost/DiaryApp
APP_SECRET=your_secret_key
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=diary_app
UPLOAD_PATH=/path/to/uploads
TEMP_UPLOAD_PATH=/path/to/temp_uploads
MAX_FILE_SIZE=5242880
ALLOWED_EXTENSIONS=jpg,jpeg,png,gif
SESSION_LIFETIME=3600
```

## Key Components

### Routes (`/routes`)

- **web.php** - Standard web routes (pages)
- **api.php** - AJAX/JSON endpoints

Routes are simple arrays mapping URLs to controllers and methods:

```php
'/diary/view/:id' => ['controller' => 'DiaryController', 'method' => 'view', 'params' => [id]]
```

### Middleware (`/middleware`)

- **auth.php** - Authentication and CSRF protection
  - `AuthMiddleware::requireAuth()` - Ensure user is logged in
  - `AuthMiddleware::verifyCsrf()` - Validate CSRF tokens
  - `AuthMiddleware::generateCsrfToken()` - Create CSRF token

### Helpers (`/helpers`)

- **functions.php** - Common utilities
  - `view()` - Load and render a view file
  - `redirect()` - HTTP redirect
  - `isAuthenticated()` - Check if user logged in
  - `escape()` - HTML escape output
  - Session helpers (session(), setSession(), flashMessage())

- **Router.php** - Request routing class
  - Parses incoming URLs
  - Matches routes using pattern matching
  - Supports dynamic routes like `/diary/view/{id}`

## Security Features

1. **CSRF Protection** - Every state-changing request verified
2. **Session Security** - Sessions stored server-side in `/storage/sessions`
3. **XSS Prevention** - Output escaped with `htmlspecialchars()`
4. **Input Validation** - Filters applied to all user input
5. **SQL Injection Prevention** - Prepared statements in models
6. **File Upload Security** - File type/size validation

## Setting Up the Application

### 1. Apache Configuration

Ensure `.htaccess` is enabled in your Apache config:

```apache
<Directory /var/www/DiaryApp>
    AllowOverride All
</Directory>
```

### 2. Environment Setup

Create `.env` file in root with your settings:

```bash
cp .env.example .env
```

### 3. Database Setup

```bash
mysql -u root < schema.sql
```

### 4. Permissions

Ensure proper permissions:

```bash
chmod 755 storage/
chmod 777 storage/sessions/
chmod 777 storage/logs/
chmod 777 public/uploads/
chmod 777 storage/temp_uploads/
```

## Development

### Adding a New Feature

1. **Create Controller** - Add method to handle logic
2. **Create Model** - Add database interactions
3. **Create Views** - Add HTML templates
4. **Add Routes** - Register in `/routes/web.php` or `/routes/api.php`
5. **Add Views** - Create template files

### Example: Adding a New Page

```php
// 1. routes/web.php
'/blog' => ['controller' => 'BlogController', 'method' => 'index'],

// 2. app/controllers/BlogController.php
public function index() {
    $posts = $this->blogModel->getAll();
    view('blog/index', ['posts' => $posts]);
}

// 3. app/views/blog/index.php
<?php foreach($posts as $post): ?>
    <article><?php echo escape($post['title']); ?></article>
<?php endforeach; ?>
```

## API Endpoints

All API endpoints are defined in `/routes/api.php`:

- `POST /api/autosave` - Save diary entry (auto)
- `POST /api/update-position` - Update card position
- `POST /api/delete-image` - Delete uploaded image
- `POST /api/submit-mood` - Submit mood check-in

## Troubleshooting

### 404 Errors

- Check `.htaccess` is in root directory
- Verify Apache `mod_rewrite` is enabled
- Check route is defined in `/routes/web.php` or `/routes/api.php`

### Session Issues

- Verify `/storage/sessions/` has write permissions
- Check `SESSION_LIFETIME` in `.env`
- Clear browser cookies if needed

### Database Errors

- Verify credentials in `.env`
- Ensure database is running
- Check `/storage/logs/` for detailed errors

## Performance

- Static assets (CSS, JS, images) are cached in browser
- Database queries should use prepared statements
- Consider adding query caching for frequently accessed data
- Monitor logs in `/storage/logs/` for performance issues

## Maintenance

- Regularly clear `/storage/logs/`
- Monitor `/storage/sessions/` - old sessions can be deleted
- Backup `/public/uploads/` regularly
- Keep dependencies updated: `composer update`

---

**Last Updated**: May 2024
**Version**: 2.0 (Reorganized)

# Quick Start Guide

## Getting Started with DiaryApp

### Prerequisites

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache with `mod_rewrite` enabled
- Composer (for dependencies)

### Installation Steps

#### 1. Clone or Download the Project

```bash
cd /xampp/htdocs
# Assuming you already have the project at DiaryApp
```

#### 2. Install Dependencies

```bash
cd DiaryApp
composer install
```

#### 3. Create Environment File

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Edit `.env` and update with your settings. The default is set for direct `index.php` access:

```env
APP_URL=http://localhost/DiaryApp/index.php
APP_SECRET=your-random-secret-key-here
DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=diary_app
UPLOAD_PATH=storage/uploads
TEMP_UPLOAD_PATH=storage/temp_uploads
MAX_FILE_SIZE=5242880
ALLOWED_EXTENSIONS=jpg,jpeg,png,gif
SESSION_LIFETIME=3600
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USER=your_email@example.com
MAIL_PASS=your_password
```

**Note**: If you want clean URLs without `index.php`, see the [URL_STRUCTURE.md](URL_STRUCTURE.md) guide.

#### 4. Set Up Database

```bash
mysql -u root -p < schema.sql
```

Or manually:

```sql
mysql> CREATE DATABASE diary_app;
mysql> USE diary_app;
mysql> SOURCE schema.sql;
```

#### 5. Set Folder Permissions

```bash
chmod 755 storage/
chmod 777 storage/sessions/
chmod 777 storage/logs/
chmod 777 storage/temp_uploads/
chmod 777 storage/cache/
chmod 777 public/uploads/
```

#### 6. Verify Apache Configuration

Edit Apache config to enable `.htaccess` (optional, for clean URLs):

```apache
<Directory /xampp/htdocs/DiaryApp>
    AllowOverride All
    Require all granted
</Directory>
```

Enable `mod_rewrite` (optional):

```bash
# On Windows (XAMPP):
# Uncomment in apache/conf/httpd.conf:
# LoadModule rewrite_module modules/mod_rewrite.so
```

#### 7. Access the Application

Navigate to: **http://localhost/DiaryApp/index.php**

You should see the landing page with login/register options.

**Alternative URL Formats** (see [URL_STRUCTURE.md](URL_STRUCTURE.md) for details):
- With query params: `http://localhost/DiaryApp/index.php?url=/login`
- Without index.php: `http://localhost/DiaryApp/login` (requires `.htaccess`)

### First Steps as a User

1. **Register** - Create a new account
2. **Verify OTP** - Check your email for verification code
3. **Create Entry** - Write your first diary entry
4. **Customize** - Add mood, styling, images to entries
5. **Explore** - Use search, calendar, and filters to find entries

## Folder Structure Overview

```
DiaryApp/
├── index.php          ← Main entry point - start here
├── app/               ← Application code (controllers, models, views)
├── config/            ← Configuration files
├── routes/            ← URL routes definition
├── middleware/        ← Authentication, CSRF, etc.
├── helpers/           ← Utility functions
├── storage/           ← Sessions, logs, uploads
├── public/            ← Static assets (CSS, JS, images)
└── vendor/            ← Dependencies (PHPMailer, etc.)
```

## Common Commands

### Clear Sessions

```bash
rm storage/sessions/sess_*
```

### View Logs

```bash
tail -f storage/logs/app.log
```

### Reset Database

```bash
mysql -u root -p diary_app < schema.sql
```

## Troubleshooting

### White Screen / 500 Error

- Check `/storage/logs/` for error details
- Verify `.env` file exists and has correct database credentials
- Enable PHP error display in `config/app.php`

### "Route Not Found" (404)

- Verify `.htaccess` is in root directory
- Check Apache `mod_rewrite` is enabled
- Confirm route exists in `/routes/web.php` or `/routes/api.php`

### Can't Upload Images

- Check `/public/uploads/` permissions (should be 777)
- Verify `MAX_FILE_SIZE` in `.env` is not too small
- Check file extension is in `ALLOWED_EXTENSIONS`

### Session Not Persisting

- Verify `/storage/sessions/` has write permissions
- Check `SESSION_LIFETIME` in `.env`
- Clear browser cookies and try again

### Mail Not Sending

- Verify SMTP credentials in `.env`
- Check firewall isn't blocking SMTP port
- Review `/storage/logs/` for mail errors

## Development Tips

### Adding a New Page

1. Create controller method in `app/controllers/`
2. Create view in `app/views/`
3. Add route in `routes/web.php`

Example:

```php
// routes/web.php
'/about' => ['controller' => 'PageController', 'method' => 'about'],

// app/controllers/PageController.php
public function about() {
    view('pages/about');
}

// app/views/pages/about.php
<h1>About DiaryApp</h1>
```

### Debugging

Enable debugging in `config/app.php`:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

Check logs:

```bash
tail -50 storage/logs/app.log
```

## Architecture

DiaryApp follows the **MVC (Model-View-Controller)** pattern:

- **Models** - Database interaction (`app/models/`)
- **Views** - HTML templates (`app/views/`)
- **Controllers** - Business logic (`app/controllers/`)

All requests route through `index.php` → Router → Controller → View

## Security Notes

- ✅ CSRF protection on all forms
- ✅ Password hashing with bcrypt
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS prevention (HTML escaping)
- ✅ File upload validation
- ✅ Session security

## Performance

- Sessions stored server-side
- Database queries optimized
- Static assets cached by browser
- Consider adding query caching for production

## Support & Documentation

For more details, see:
- `PROJECT_STRUCTURE.md` - Detailed project structure
- `README.md` - General information
- Code comments in controllers and models

---

**Happy journaling! 📝**

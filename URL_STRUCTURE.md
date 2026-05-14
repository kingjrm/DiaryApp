# URL Structure Guide

## With `index.php` in URL (Default Configuration)

This is the configuration you've chosen. All URLs include `index.php` with query parameters:

```
http://localhost/DiaryApp/index.php                          → Landing page
http://localhost/DiaryApp/index.php?url=/login               → Login page
http://localhost/DiaryApp/index.php?url=/register            → Register page
http://localhost/DiaryApp/index.php?url=/diary               → Diary home
http://localhost/DiaryApp/index.php?url=/diary/create        → Create entry
http://localhost/DiaryApp/index.php?url=/diary/view/5        → View entry #5
http://localhost/DiaryApp/index.php?url=/diary/edit/5        → Edit entry #5
http://localhost/DiaryApp/index.php?url=/diary/search        → Search entries
http://localhost/DiaryApp/index.php?url=/api/autosave        → Auto-save API
```

## Configuration

Your `.env` file is set to:
```env
APP_URL=http://localhost/DiaryApp/index.php
```

## Optional: Clean URLs (requires .htaccess)

If you want to remove `index.php` from URLs, you can:

1. Ensure Apache `mod_rewrite` is enabled
2. Enable the rewrite rules in `.htaccess`
3. Change `.env` to:
```env
APP_URL=http://localhost/DiaryApp
```

Then URLs become:
```
http://localhost/DiaryApp/login
http://localhost/DiaryApp/diary
http://localhost/DiaryApp/diary/view/5
```

## How It Works

The system automatically detects the URL format and routes accordingly:

1. **With Query Parameter** (your current setup)
   - URL: `index.php?url=/login`
   - Router reads: `$_GET['url']` parameter
   - Works everywhere, no `.htaccess` needed ✅

2. **With Rewrite Rules** (if you enable .htaccess)
   - URL: `index.php/login` or `/login`
   - Router reads: `REQUEST_URI`
   - Cleaner, requires `.htaccess` setup

## Using the `url()` Helper

In your templates, use the `url()` helper function for consistency:

```php
<!-- In views -->
<a href="<?php echo url('login'); ?>">Log In</a>
<a href="<?php echo url('diary/view/5'); ?>">View Entry</a>
```

This automatically handles the correct URL format based on your `.env` configuration.

## Backend Redirects

Controllers use the same logic:

```php
// In controllers
header('Location: ' . APP_URL . '/login');
// This works correctly with query parameters
```

---

**Your current setup**: `index.php` is visible in URLs with query parameters  
**Alternative setup**: Clean URLs (requires `.htaccess` and server configuration)

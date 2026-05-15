# URL Structure Guide

## Clean URLs with direct auth pages

This is the configuration you're using now. Auth pages are direct `.php` wrappers, while the rest of the app is routed from the root entry point:

```
http://localhost/DiaryApp/                 → Landing page
http://localhost/DiaryApp/login.php        → Login page
http://localhost/DiaryApp/register.php     → Register page
http://localhost/DiaryApp/verify-otp.php    → OTP verification page
http://localhost/DiaryApp/diary             → Diary home
http://localhost/DiaryApp/diary/create     → Create entry
http://localhost/DiaryApp/diary/view/5     → View entry #5
http://localhost/DiaryApp/diary/edit/5     → Edit entry #5
http://localhost/DiaryApp/diary/search     → Search entries
http://localhost/DiaryApp/api/autosave     → Auto-save API
```

## Configuration

Your `.env` file is set to:
```env
APP_URL=http://localhost/DiaryApp
```

## How It Works

The app now uses two URL styles:

1. **Direct auth pages**
   - URL: `login.php`, `register.php`, `verify-otp.php`
   - These wrappers include the matching views directly.

2. **Router-driven app pages**
   - URL: `/diary`, `/diary/create`, `/api/autosave`
   - The root `index.php` and `url()` helper keep these functional.

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
header('Location: ' . authPageUrl('login'));
// This redirects to login.php
```

---

**Your current setup**: clean base URL with direct auth pages  
**App pages**: still routed through the root `index.php`

# 🚀 DITASCOM Hostinger Deployment - Complete Step-by-Step Guide

## 📋 Table of Contents
1. [Before You Start](#before-you-start)
2. [Step 1: Prepare Your Files](#step-1-prepare-your-files)
3. [Step 2: Access Hostinger Control Panel](#step-2-access-hostinger-control-panel)
4. [Step 3: Create MySQL Database](#step-3-create-mysql-database)
5. [Step 4: Upload Files via File Manager](#step-4-upload-files-via-file-manager)
6. [Step 5: Configure Environment File](#step-5-configure-environment-file)
7. [Step 6: Set Up Database](#step-6-set-up-database)
8. [Step 7: Configure PHP Settings](#step-7-configure-php-settings)
9. [Step 8: Final Optimizations](#step-8-final-optimizations)
10. [Step 9: Test Your Website](#step-9-test-your-website)
11. [Troubleshooting](#troubleshooting)

---

## 🎯 Before You Start

### ✅ Requirements Checklist:
- [ ] Hostinger Single Web Hosting (or higher) account
- [ ] Domain name (or use Hostinger subdomain)
- [ ] PayMongo account with API keys
- [ ] Gmail account for SMTP (with App Password)
- [ ] Your DITASCOM project files ready

### 📦 What You'll Deploy:
- Laravel 12.x application
- MySQL database
- PayMongo payment integration
- Email notification system
- File upload functionality

---

## 📁 Step 1: Prepare Your Files

### 1.1 Create a Deployment Package

**On your local computer:**

1. **Open your project folder:**
   ```
   c:\Users\felix\Downloads\ditascom (3)\ditascom
   ```

2. **Create a ZIP file** with these folders/files:
   ```
   ✅ Include:
   - app/
   - bootstrap/
   - config/
   - database/ (migrations and seeders only)
   - public/
   - resources/
   - routes/
   - storage/ (framework folders only, empty logs)
   - vendor/ (if you have it)
   - artisan
   - composer.json
   - composer.lock
   - package.json
   - .env.example
   - env-production-template.txt
   
   ❌ Exclude:
   - node_modules/
   - .git/
   - tests/
   - storage/logs/*.log
   - .env (you'll create this on server)
   ```

3. **Compress to ZIP:**
   - Right-click the project folder
   - Select "Send to" > "Compressed (zipped) folder"
   - Name it: `ditascom-deployment.zip`

### 1.2 Alternative: Use Git (Recommended)

If your project is on GitHub:
- You'll clone it directly on Hostinger using SSH
- This is faster and cleaner

---

## 🖥️ Step 2: Access Hostinger Control Panel

### 2.1 Login to Hostinger

1. Go to: https://www.hostinger.com
2. Click **"Login"** (top right)
3. Enter your email and password
4. Click **"Hosting"** from the dashboard

### 2.2 Access hPanel

1. Find your hosting plan (Single Web Hosting)
2. Click **"Manage"** or **"Continue Setup"**
3. You're now in **hPanel** (Hostinger's control panel)

---

## 🗄️ Step 3: Create MySQL Database

### 3.1 Navigate to Databases

1. In hPanel, find **"Databases"** section
2. Click **"MySQL Databases"**

### 3.2 Create New Database

1. Click **"Create New Database"**
2. Fill in the form:
   ```
   Database Name: ditascom_db
   Username: ditascom_user
   Password: [Generate Strong Password]
   ```
3. Click **"Create"**

### 3.3 Save Database Credentials

**IMPORTANT:** Write these down immediately:
```
DB_HOST: localhost
DB_DATABASE: u123456789_ditascom_db
DB_USERNAME: u123456789_ditascom_user
DB_PASSWORD: [your generated password]
```

> **Note:** Hostinger adds a prefix (like `u123456789_`) to your database name and username.

---

## 📤 Step 4: Upload Files via File Manager

### 4.1 Access File Manager

1. In hPanel, find **"Files"** section
2. Click **"File Manager"**
3. Navigate to **`public_html`** folder

### 4.2 Clean public_html

1. Delete default files:
   - `index.html`
   - Any other default files
2. Keep `.htaccess` if it exists

### 4.3 Upload Your Files

**Option A: Upload ZIP File**

1. Click **"Upload Files"** button (top right)
2. Select your `ditascom-deployment.zip`
3. Wait for upload to complete
4. Right-click the ZIP file
5. Select **"Extract"**
6. Extract to `public_html`
7. Delete the ZIP file after extraction

**Option B: Use Git (Recommended)**

1. In File Manager, click **"Terminal"** or go to **"Advanced" > "SSH Access"**
2. Enable SSH if not enabled
3. Connect via SSH:
   ```bash
   ssh u123456789@your-domain.com
   ```
4. Navigate to public_html:
   ```bash
   cd public_html
   ```
5. Clone your repository:
   ```bash
   git clone https://github.com/yourusername/ditascom.git .
   ```

### 4.4 Install Composer Dependencies

**If you didn't upload vendor folder:**

1. Open **Terminal** in File Manager
2. Navigate to your project:
   ```bash
   cd public_html
   ```
3. Install dependencies:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

---

## ⚙️ Step 5: Configure Environment File

### 5.1 Create .env File

1. In File Manager, navigate to `public_html`
2. Find `env-production-template.txt`
3. Right-click and select **"Rename"**
4. Rename to: `.env`

### 5.2 Edit .env File

1. Right-click `.env`
2. Select **"Edit"**
3. Update these values:

```env
# Application
APP_NAME=DITASCOM
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database (use your saved credentials)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_ditascom_db
DB_USERNAME=u123456789_ditascom_user
DB_PASSWORD=your_database_password

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Email (Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-gmail-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# PayMongo (Use LIVE keys for production)
PAYMONGO_PUBLIC_KEY=pk_live_YOUR_LIVE_PUBLIC_KEY
PAYMONGO_SECRET_KEY=sk_live_YOUR_LIVE_SECRET_KEY
PAYMONGO_BASE_URL=https://api.paymongo.com/v1
CERTIFICATE_AMOUNT=50.00
```

4. Click **"Save"**

### 5.3 Generate Application Key

1. Open **Terminal**
2. Navigate to project:
   ```bash
   cd public_html
   ```
3. Generate key:
   ```bash
   php artisan key:generate
   ```

---

## 🗃️ Step 6: Set Up Database

### 6.1 Run Migrations

1. In Terminal:
   ```bash
   cd public_html
   php artisan migrate --force
   ```

2. You should see:
   ```
   Migration table created successfully.
   Migrating: 2024_01_01_000000_create_users_table
   Migrated:  2024_01_01_000000_create_users_table
   ...
   ```

### 6.2 Seed Admin User

1. Create the first admin account:
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```

2. **Default Admin Credentials:**
   ```
   Email: admin@ditascom.com
   Password: admin123
   ```
   
   ⚠️ **IMPORTANT:** Change this password immediately after first login!

### 6.3 Create Storage Link

1. Link storage folder:
   ```bash
   php artisan storage:link
   ```

---

## 🔧 Step 7: Configure PHP Settings

### 7.1 Check PHP Version

1. In hPanel, go to **"Advanced" > "PHP Configuration"**
2. Ensure PHP version is **8.2** or higher
3. If not, select PHP 8.2 from dropdown

### 7.2 Enable Required Extensions

Make sure these are enabled:
- ✅ `pdo_mysql`
- ✅ `mbstring`
- ✅ `openssl`
- ✅ `tokenizer`
- ✅ `xml`
- ✅ `ctype`
- ✅ `json`
- ✅ `bcmath`
- ✅ `fileinfo`
- ✅ `gd`

### 7.3 Increase PHP Limits

In PHP Configuration, set:
```
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

### 7.4 Set File Permissions

1. In File Manager, right-click these folders:
   - `storage/`
   - `bootstrap/cache/`
2. Select **"Permissions"**
3. Set to **755** (rwxr-xr-x)
4. Check **"Apply to subdirectories"**

---

## 🚀 Step 8: Final Optimizations

### 8.1 Cache Configuration

In Terminal:
```bash
cd public_html
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 8.2 Clear Any Old Caches

```bash
php artisan optimize:clear
```

### 8.3 Set Up Cron Jobs (Optional but Recommended)

1. In hPanel, go to **"Advanced" > "Cron Jobs"**
2. Add new cron job:
   ```
   Command: cd /home/u123456789/public_html && php artisan schedule:run >> /dev/null 2>&1
   Frequency: Every minute (* * * * *)
   ```

This enables Laravel's task scheduler for:
- Cleaning up old unpaid requests
- Sending scheduled notifications

---

## ✅ Step 9: Test Your Website

### 9.1 Access Your Website

1. Open browser
2. Go to: `https://your-domain.com`
3. You should see the DITASCOM homepage with calendar

### 9.2 Test Admin Login

1. Click **"Login"** button
2. Enter admin credentials:
   ```
   Email: admin@ditascom.com
   Password: admin123
   ```
3. You should be redirected to admin dashboard

### 9.3 Test User Registration

1. Logout from admin
2. Click **"Sign Up"**
3. Create a test parishioner account
4. Verify email works (check inbox)

### 9.4 Test Certificate Request

1. Login as parishioner
2. Click **"Request Certificate"**
3. Fill out form
4. Test payment flow (use PayMongo test mode first)

### 9.5 Test FAQ Page

1. Click **"FAQ"** button in header
2. Verify all 11 questions display
3. Test accordion functionality

---

## 🔍 Troubleshooting

### Issue 1: 500 Internal Server Error

**Causes:**
- Wrong file permissions
- Missing .env file
- PHP version too old

**Solutions:**
```bash
# Check Laravel logs
cat storage/logs/laravel.log

# Fix permissions
chmod -R 755 storage bootstrap/cache

# Regenerate key
php artisan key:generate

# Clear cache
php artisan optimize:clear
```

### Issue 2: Database Connection Error

**Error:** `SQLSTATE[HY000] [1045] Access denied`

**Solutions:**
1. Verify database credentials in `.env`
2. Check if database exists in Hostinger MySQL panel
3. Ensure you used the full database name with prefix (e.g., `u123456789_ditascom_db`)

### Issue 3: White Screen / Blank Page

**Causes:**
- APP_DEBUG=false hides errors
- PHP errors not logged

**Solutions:**
1. Temporarily set `APP_DEBUG=true` in `.env`
2. Refresh page to see actual error
3. Fix the error
4. Set `APP_DEBUG=false` again

### Issue 4: CSS/JS Not Loading

**Causes:**
- Wrong APP_URL in .env
- Mixed content (HTTP/HTTPS)

**Solutions:**
1. Set correct `APP_URL=https://your-domain.com` in `.env`
2. Clear cache: `php artisan optimize:clear`
3. Check if SSL certificate is active in Hostinger

### Issue 5: File Upload Fails

**Causes:**
- Storage not linked
- Wrong permissions
- PHP upload limits too low

**Solutions:**
```bash
# Create storage link
php artisan storage:link

# Fix permissions
chmod -R 755 storage

# Check PHP settings (increase if needed)
upload_max_filesize = 10M
post_max_size = 10M
```

### Issue 6: Email Not Sending

**Causes:**
- Wrong Gmail app password
- SMTP blocked by host

**Solutions:**
1. Generate new Gmail App Password:
   - Go to: https://myaccount.google.com/apppasswords
   - Generate new password
   - Update `MAIL_PASSWORD` in `.env`
2. Test email:
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) {
       $msg->to('your-email@gmail.com')->subject('Test');
   });
   ```

### Issue 7: PayMongo Webhook Not Working

**Causes:**
- Webhook URL not set in PayMongo dashboard
- CSRF protection blocking webhook

**Solutions:**
1. In PayMongo dashboard, set webhook URL:
   ```
   https://your-domain.com/paymongo/webhook
   ```
2. Verify route is excluded from CSRF in `app/Http/Middleware/VerifyCsrfToken.php`

---

## 📊 Post-Deployment Checklist

After deployment, verify:

- [ ] Homepage loads correctly
- [ ] Admin can login
- [ ] Parishioner can register
- [ ] Email verification works
- [ ] Certificate request form works
- [ ] File uploads work
- [ ] PayMongo payment works
- [ ] PDF generation works
- [ ] Email notifications send
- [ ] FAQ page displays correctly
- [ ] Calendar shows events
- [ ] Mobile responsive design works
- [ ] SSL certificate is active (HTTPS)
- [ ] All images load correctly

---

## 🔐 Security Checklist

- [ ] Change default admin password
- [ ] Set `APP_DEBUG=false` in production
- [ ] Use strong database password
- [ ] Use PayMongo LIVE keys (not test keys)
- [ ] Enable SSL certificate (HTTPS)
- [ ] Set up regular backups in Hostinger
- [ ] Keep Laravel and dependencies updated
- [ ] Monitor `storage/logs/laravel.log` for errors

---

## 📞 Getting Help

### Hostinger Support:
- Live Chat: Available 24/7 in hPanel
- Email: support@hostinger.com
- Knowledge Base: https://support.hostinger.com

### Laravel Issues:
- Check logs: `storage/logs/laravel.log`
- Laravel Docs: https://laravel.com/docs

### PayMongo Issues:
- PayMongo Support: support@paymongo.com
- PayMongo Docs: https://developers.paymongo.com

---

## 🎉 Congratulations!

Your DITASCOM application is now live on Hostinger! 

**Next Steps:**
1. Change default admin password
2. Create sub-admin accounts for parishes
3. Test all features thoroughly
4. Set up regular backups
5. Monitor logs for any issues

**Your website is now accessible at:**
```
https://your-domain.com
```

---

## 📝 Quick Command Reference

```bash
# Navigate to project
cd public_html

# Clear all caches
php artisan optimize:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Check Laravel version
php artisan --version

# List all routes
php artisan route:list

# Check database connection
php artisan db:show

# Generate app key
php artisan key:generate
```

---

**Document Version:** 1.0  
**Last Updated:** November 14, 2025  
**Application:** DITASCOM v1.0  
**Hosting:** Hostinger Single Web Hosting

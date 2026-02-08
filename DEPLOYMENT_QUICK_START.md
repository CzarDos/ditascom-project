# ⚡ DITASCOM Hostinger Deployment - Quick Start Guide

## 🎯 5-Minute Setup Overview

### Phase 1: Prepare (5 minutes)
1. ✅ ZIP your project files
2. ✅ Get PayMongo API keys ready
3. ✅ Get Gmail app password ready

### Phase 2: Hostinger Setup (10 minutes)
1. ✅ Login to Hostinger hPanel
2. ✅ Create MySQL database
3. ✅ Upload files to public_html
4. ✅ Create .env file

### Phase 3: Configuration (10 minutes)
1. ✅ Run migrations
2. ✅ Seed admin user
3. ✅ Set permissions
4. ✅ Cache configuration

### Phase 4: Test (5 minutes)
1. ✅ Access website
2. ✅ Test admin login
3. ✅ Test certificate request

**Total Time: ~30 minutes**

---

## 📋 Pre-Flight Checklist

Before starting, have these ready:

```
✅ Hostinger Account Login
✅ Domain Name (or use Hostinger subdomain)
✅ PayMongo Live API Keys:
   - Public Key: pk_live_...
   - Secret Key: sk_live_...
✅ Gmail Account with App Password
✅ Project Files (ZIP or Git URL)
```

---

## 🚀 Step-by-Step Commands

### 1️⃣ After Uploading Files to Hostinger

**Open Terminal in hPanel:**

```bash
# Navigate to your project
cd public_html

# Install dependencies (if vendor folder not uploaded)
composer install --optimize-autoloader --no-dev

# Copy environment file
cp env-production-template.txt .env

# Edit .env file (use File Manager editor)
# Update: DB credentials, APP_URL, MAIL settings, PAYMONGO keys

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Seed admin user
php artisan db:seed --class=AdminSeeder

# Create storage link
php artisan storage:link

# Set permissions
chmod -R 755 storage bootstrap/cache

# Cache everything for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 2️⃣ Default Admin Login

After setup, login with:
```
URL: https://your-domain.com/login
Email: admin@ditascom.com
Password: admin123
```

⚠️ **Change this password immediately!**

---

## 🔧 Essential .env Configuration

**Minimum required changes in .env:**

```env
# 1. Application URL
APP_URL=https://your-domain.com
APP_ENV=production
APP_DEBUG=false

# 2. Database (from Hostinger MySQL panel)
DB_DATABASE=u123456789_ditascom_db
DB_USERNAME=u123456789_ditascom_user
DB_PASSWORD=your_db_password

# 3. Email (Gmail)
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password

# 4. PayMongo (LIVE keys)
PAYMONGO_PUBLIC_KEY=pk_live_YOUR_KEY
PAYMONGO_SECRET_KEY=sk_live_YOUR_KEY
```

---

## 🎨 Visual Deployment Flow

```
┌─────────────────────────────────────────────────────┐
│  1. PREPARE FILES                                   │
│  └─> ZIP project or use Git                        │
└─────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────┐
│  2. HOSTINGER SETUP                                 │
│  ├─> Login to hPanel                                │
│  ├─> Create MySQL Database                          │
│  └─> Note credentials                               │
└─────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────┐
│  3. UPLOAD FILES                                    │
│  ├─> File Manager > public_html                     │
│  ├─> Upload ZIP or Git clone                        │
│  └─> Extract files                                  │
└─────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────┐
│  4. CONFIGURE                                       │
│  ├─> Create .env file                               │
│  ├─> Update database credentials                    │
│  ├─> Set PayMongo keys                              │
│  └─> Configure email                                │
└─────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────┐
│  5. TERMINAL COMMANDS                               │
│  ├─> php artisan key:generate                       │
│  ├─> php artisan migrate --force                    │
│  ├─> php artisan db:seed --class=AdminSeeder        │
│  └─> php artisan optimize                           │
└─────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────┐
│  6. TEST & VERIFY                                   │
│  ├─> Visit your-domain.com                          │
│  ├─> Test admin login                               │
│  ├─> Test certificate request                       │
│  └─> Test payment flow                              │
└─────────────────────────────────────────────────────┘
                        ↓
                   ✅ LIVE!
```

---

## 🆘 Common Issues & Quick Fixes

### Issue: 500 Error
```bash
# Check permissions
chmod -R 755 storage bootstrap/cache

# Clear cache
php artisan optimize:clear

# Check logs
tail -f storage/logs/laravel.log
```

### Issue: Database Connection Failed
```bash
# Verify credentials in .env match Hostinger MySQL panel
# Remember: Hostinger adds prefix like u123456789_
```

### Issue: CSS/JS Not Loading
```bash
# Update APP_URL in .env
APP_URL=https://your-domain.com

# Clear cache
php artisan optimize:clear
```

### Issue: Email Not Sending
```bash
# Get Gmail App Password:
# 1. Go to: https://myaccount.google.com/apppasswords
# 2. Generate new password
# 3. Update MAIL_PASSWORD in .env
```

---

## 📱 Mobile Access to hPanel

**On your phone:**
1. Download Hostinger app (iOS/Android)
2. Login with your credentials
3. Access File Manager and Terminal
4. Run commands on-the-go

---

## 🔐 Security Reminders

After deployment:
- [ ] Change admin password from default
- [ ] Set APP_DEBUG=false
- [ ] Use HTTPS (enable SSL in Hostinger)
- [ ] Use PayMongo LIVE keys (not test)
- [ ] Set strong database password
- [ ] Enable 2FA on Hostinger account

---

## 📞 Need Help?

**Hostinger Support:**
- 24/7 Live Chat in hPanel
- Email: support@hostinger.com

**Check Logs:**
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# PHP errors
tail -f /home/u123456789/logs/error_log
```

---

## ✅ Success Indicators

Your deployment is successful when:
- ✅ Homepage loads at your-domain.com
- ✅ Admin can login
- ✅ Certificate request form works
- ✅ File uploads work
- ✅ Emails send correctly
- ✅ PayMongo payment processes
- ✅ No errors in logs

---

## 🎉 You're Done!

**Your DITASCOM is now live!**

**Access Points:**
- Homepage: `https://your-domain.com`
- Admin Login: `https://your-domain.com/login`
- FAQ Page: `https://your-domain.com/faq`

**Default Credentials:**
```
Email: admin@ditascom.com
Password: admin123
```

**⚠️ CHANGE PASSWORD IMMEDIATELY!**

---

**For detailed instructions, see:** `HOSTINGER_STEP_BY_STEP.md`

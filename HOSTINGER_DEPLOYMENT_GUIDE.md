# DITASCOM Hostinger Deployment Guide

## Pre-Deployment Checklist ✅

### 1. System Requirements
- ✅ PHP 8.2+ (Compatible with Hostinger)
- ✅ MySQL Database
- ✅ Composer dependencies optimized
- ✅ Laravel 12.x framework

### 2. Environment Configuration
- ✅ Production environment template created
- ✅ Database sessions configured
- ✅ Email SMTP configured (Gmail)
- ✅ PayMongo payment integration ready

## Deployment Steps

### Step 1: Prepare Files for Upload
1. **Exclude development files** - Don't upload:
   - `node_modules/`
   - `.git/`
   - `tests/`
   - `storage/logs/*`
   - `.env` (create new on server)

2. **Include essential files**:
   - All `app/` files
   - `public/` directory
   - `database/migrations/`
   - `vendor/` (or run composer install on server)
   - `bootstrap/`
   - `config/`
   - `resources/`
   - `routes/`

### Step 2: Hostinger Setup
1. **Create MySQL Database** in Hostinger panel
2. **Note database credentials**:
   - Database name
   - Username
   - Password
   - Host (usually localhost)

### Step 3: Upload Files
1. **Upload to public_html** or subdomain folder
2. **Set correct file permissions**:
   - `storage/` folders: 755
   - `bootstrap/cache/`: 755
   - `public/`: 755

### Step 4: Environment Configuration
1. **Copy `env-production-template.txt` to `.env`**
2. **Update database credentials**:
   ```
   DB_HOST=localhost
   DB_DATABASE=your_hostinger_db_name
   DB_USERNAME=your_hostinger_db_user
   DB_PASSWORD=your_hostinger_db_password
   ```
3. **Generate APP_KEY**:
   ```bash
   php artisan key:generate
   ```

### Step 5: Database Setup
1. **Run migrations**:
   ```bash
   php artisan migrate --force
   ```
2. **Seed admin user**:
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```

### Step 6: Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Step 7: Storage Link
```bash
php artisan storage:link
```

## Security Configurations ✅

### 1. Environment Security
- ✅ `APP_DEBUG=false` in production
- ✅ `APP_ENV=production`
- ✅ Strong `APP_KEY` generated
- ✅ Database credentials secured

### 2. File Permissions
- ✅ Storage directories writable (755)
- ✅ Bootstrap cache writable (755)
- ✅ Config files protected

### 3. Email Security
- ✅ Gmail SMTP with app password
- ✅ TLS encryption enabled

## PayMongo Configuration

### For Production:
1. **Switch to live keys** in `.env`:
   ```
   PAYMONGO_PUBLIC_KEY=pk_live_YOUR_LIVE_KEY
   PAYMONGO_SECRET_KEY=sk_live_YOUR_LIVE_KEY
   ```
2. **Test payment flow** before going live

## Troubleshooting Common Issues

### 1. 500 Internal Server Error
- Check file permissions (755 for directories, 644 for files)
- Verify `.env` file exists and is configured
- Check `storage/logs/laravel.log` for errors

### 2. Database Connection Error
- Verify database credentials in `.env`
- Ensure database exists in Hostinger panel
- Check if migrations ran successfully

### 3. Email Not Sending
- Verify Gmail app password is correct
- Check SMTP settings match Gmail requirements
- Test with: `php artisan email:test your@email.com --type=approved`

### 4. Session Issues
- Ensure `sessions` table exists (run migrations)
- Check `SESSION_DRIVER=database` in `.env`
- Clear cache: `php artisan optimize:clear`

## Post-Deployment Testing

### 1. User Authentication
- ✅ Admin login works
- ✅ Sub-admin login works  
- ✅ Parishioner registration works
- ✅ Concurrent logins supported

### 2. Certificate Management
- ✅ Certificate creation works
- ✅ PDF generation works
- ✅ File uploads work
- ✅ Email notifications send

### 3. Payment Integration
- ✅ PayMongo integration works
- ✅ Payment webhooks receive properly
- ✅ Certificate requests process correctly

## Maintenance Commands

### Regular Maintenance:
```bash
# Clear caches
php artisan optimize:clear

# Update composer dependencies
composer install --optimize-autoloader --no-dev

# Run any new migrations
php artisan migrate --force
```

## Support Information

### System Status: ✅ READY FOR DEPLOYMENT
- All critical components tested
- Security configurations in place
- Database structure complete
- Email system functional
- Payment integration ready
- Concurrent login support enabled

### Contact for Issues:
- Check `storage/logs/laravel.log` for detailed error information
- Verify Hostinger PHP version is 8.2+
- Ensure all required PHP extensions are enabled

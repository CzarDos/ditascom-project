# Unpaid Certificate Requests Cleanup

## Overview

The system now filters out unpaid certificate requests from all dashboards and listings. However, these unpaid requests still exist in the database. This document explains how to clean them up.

## Why Unpaid Requests Exist

When a user starts a certificate request:
1. The request is created and saved to the database
2. User is redirected to PayMongo payment page
3. If user completes payment → `payment_status` = 'paid' ✅
4. If user abandons checkout → `payment_status` = 'unpaid' ❌

The unpaid requests are **hidden** from all views but remain in the database.

## Current Filtering

All these locations now filter to show only **paid requests**:
- ✅ Parishioner Dashboard
- ✅ Admin Dashboard Statistics
- ✅ Admin Certificate Requests Page

## Cleanup Command

A cleanup command has been created to remove old unpaid requests.

### Usage

```bash
# Delete unpaid requests older than 7 days (default)
php artisan requests:cleanup-unpaid

# Delete unpaid requests older than 30 days
php artisan requests:cleanup-unpaid --days=30

# Delete unpaid requests older than 1 day
php artisan requests:cleanup-unpaid --days=1
```

### What It Does

1. Searches for certificate requests where:
   - `payment_status` = 'unpaid'
   - `created_at` is older than specified days
2. Shows count of requests to be deleted
3. Asks for confirmation before deletion
4. Deletes the requests permanently

### Safety Features

- ✅ Requires confirmation before deletion
- ✅ Shows count before proceeding
- ✅ Only deletes unpaid requests (never touches paid ones)
- ✅ Uses date filter to avoid deleting recent abandoned checkouts

## Recommended Schedule

### Option 1: Manual Cleanup
Run the command manually when needed:
```bash
php artisan requests:cleanup-unpaid --days=7
```

### Option 2: Automated Cleanup (Scheduled)
Add to `app/Console/Kernel.php` in the `schedule()` method:

```php
protected function schedule(Schedule $schedule)
{
    // Clean up unpaid requests older than 7 days, runs daily at 2 AM
    $schedule->command('requests:cleanup-unpaid --days=7')
             ->daily()
             ->at('02:00');
}
```

Then ensure your cron job is set up:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Important Notes

⚠️ **Warning**: Deleted requests cannot be recovered. Make sure to:
- Use appropriate `--days` value (recommended: 7-30 days)
- Test on staging environment first
- Consider database backups before bulk deletions

✅ **Safe**: This command will never delete paid requests, only unpaid ones.

## Monitoring

To check how many unpaid requests exist:

```bash
# Via Tinker
php artisan tinker
>>> \App\Models\CertificateRequest::where('payment_status', 'unpaid')->count();

# Via MySQL/Database
SELECT COUNT(*) FROM certificate_requests WHERE payment_status = 'unpaid';
```

## Alternative: Keep for Analytics

If you want to keep unpaid requests for analytics (e.g., tracking abandoned checkouts), you can:
1. **Don't run the cleanup command**
2. Create reports on abandoned checkout rates
3. Archive old unpaid requests to a separate table instead of deleting

## Summary

- 🎯 **Problem Solved**: Unpaid requests no longer clutter dashboards
- 🧹 **Optional Cleanup**: Use the command to remove old unpaid requests
- ⚙️ **Flexible**: Choose manual or automated cleanup
- 🔒 **Safe**: Only affects unpaid requests, never paid ones

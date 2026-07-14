# Referral System - Quick Start Guide

## Installation

### 1. Run Migrations
```bash
php artisan migrate
```

This creates:
- Referral code column in users table
- Referrals tracking table
- Referral rewards table
- Referral settings table

### 2. Generate Codes for Existing Users (Optional)
```php
php artisan tinker
User::whereNull('referral_code')->each(fn($u) => $u->update(['referral_code' => User::generateReferralCode()]));
```

## Access Points

### User Panel
- **Dashboard**: `/referrals`
- View referral stats, share links, track rewards

### Admin Panel
- **Management**: `/admin/referrals`
- **Settings**: `/admin/referrals/settings`
- Configure reward criteria, amounts, and system settings

## Features

### For Users
✅ Unique referral code auto-generated
✅ Share via WhatsApp, Twitter, Facebook, Email
✅ Track referral status (Pending/Active/Rewarded)
✅ View earnings and reward history
✅ Copy referral link/code with one click

### For Admins
✅ View all referrals with filters
✅ Configure reward criteria (Registration/KYC/Transaction)
✅ Set reward amounts for referrer and referred user
✅ Manual reward processing
✅ Enable/disable system
✅ Comprehensive statistics

## How It Works

1. **User registers** with referral code (`?ref=CODE123`)
2. **System creates** referral record (status: pending)
3. **When criteria met** (e.g., KYC approved):
   - Status changes to active → rewarded
   - Both users receive configured rewards
4. **Rewards credited** automatically or manually by admin

## Default Settings

- **Reward Criteria**: KYC Approval
- **Referrer Reward**: ₹100
- **Referred User Reward**: ₹50
- **Reward Type**: Cash
- **System Status**: Enabled

## Key Files

### Migrations
- `2025_10_08_000001_add_referral_code_to_users_table.php`
- `2025_10_08_000002_create_referrals_table.php`
- `2025_10_08_000003_create_referral_rewards_table.php`
- `2025_10_08_000004_create_referral_settings_table.php`

### Models
- `app/Models/Referral.php`
- `app/Models/ReferralReward.php`
- `app/Models/ReferralSetting.php`

### Controllers
- `app/Http/Controllers/ReferralController.php` (User)
- `app/Http/Controllers/Admin/AdminReferralController.php` (Admin)

### Service
- `app/Services/ReferralService.php` (Core logic)

### Views
- `resources/views/referrals/index.blade.php` (User dashboard)
- `resources/views/admin/referrals/index.blade.php` (Admin dashboard)
- `resources/views/admin/referrals/settings.blade.php` (Settings)
- `resources/views/admin/referrals/show.blade.php` (Details)

## Customization

### Change Reward Amounts
Admin Panel → Referrals → Settings → Update amounts

### Change Reward Criteria
Admin Panel → Referrals → Settings → Select criteria:
- **Registration**: Immediate reward
- **KYC Approval**: After verification (recommended)
- **First Transaction**: After first investment

### Disable System
Admin Panel → Referrals → Settings → Toggle off

## Support

For issues or questions, check:
- Migration files for database structure
- ReferralService.php for business logic
- Routes in web.php for endpoints

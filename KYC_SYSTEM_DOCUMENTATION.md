# KYC System Documentation

## Overview
Complete KYC (Know Your Customer) verification system for user identity verification with admin approval workflow.

## Database Tables

### kyc_documents
- `id` - Primary key
- `user_id` - Foreign key to users table
- `document_type` - Enum: aadhaar, pan, driving_license, passport, voter_id
- `document_number` - Document identification number
- `document_front_path` - Path to front image/PDF
- `document_back_path` - Path to back image/PDF (optional)
- `selfie_path` - Path to selfie image (optional)
- `status` - Enum: pending, verified, rejected
- `remarks` - Admin comments/feedback
- `submitted_at` - Submission timestamp
- `verified_at` - Review timestamp
- `verified_by` - Foreign key to admin user
- `timestamps` - created_at, updated_at

### notifications
- Standard Laravel notifications table for database notifications

## User Routes

### KYC Application
**URL:** `/kyc-application`  
**Method:** GET  
**Auth:** Required + Verified Email  
**Description:** Shows KYC submission form or existing KYC status

### Submit KYC
**URL:** `/kyc-application`  
**Method:** POST  
**Auth:** Required + Verified Email  
**Validation:**
- document_type: required, valid enum value
- document_number: required, string, max 50 chars
- document_front: required, file (jpg, jpeg, png, pdf), max 5MB
- document_back: optional, file (jpg, jpeg, png, pdf), max 5MB
- selfie: optional, file (jpg, jpeg, png), max 5MB

### Check KYC Status
**URL:** `/kyc-status`  
**Method:** GET  
**Auth:** Required + Verified Email  
**Description:** View current KYC application status and documents

### Resubmit KYC
**URL:** `/kyc-resubmit`  
**Method:** POST  
**Auth:** Required + Verified Email  
**Description:** Deletes rejected KYC and allows resubmission

## Admin Routes

### KYC Dashboard
**URL:** `/admin/kyc`  
**Method:** GET  
**Auth:** Super Admin  
**Query Params:** `?status=all|pending|verified|rejected`  
**Description:** Lists all KYC applications with filtering

### View KYC Details
**URL:** `/admin/kyc/{id}`  
**Method:** GET  
**Auth:** Super Admin  
**Description:** View detailed KYC application with documents

### Approve KYC
**URL:** `/admin/kyc/{id}/approve`  
**Method:** POST  
**Auth:** Super Admin  
**Fields:**
- remarks: optional, string
**Description:** Approves KYC and sends notification to user

### Reject KYC
**URL:** `/admin/kyc/{id}/reject`  
**Method:** POST  
**Auth:** Super Admin  
**Validation:**
- remarks: required, string, max 500 chars
**Description:** Rejects KYC with reason and sends notification

## Super Admin Dashboard Integration

### Statistics Displayed
- Total KYC Applications
- Pending KYC (with quick link)
- Verified KYC
- Rejected KYC

### Recent KYC Table
Shows last 5 KYC submissions with:
- User information
- Document type
- Submission date
- Status badge
- Quick view link

### KYC Quick Actions Card
- Pending count
- Verified count
- "Manage All KYC" button

## Models

### KycDocument
**Location:** `app/Models/KycDocument.php`

**Relationships:**
- `user()` - BelongsTo User
- `verifier()` - BelongsTo User (admin who reviewed)

**Helper Methods:**
- `isPending()` - Check if status is pending
- `isVerified()` - Check if status is verified
- `isRejected()` - Check if status is rejected
- `getDocumentTypeLabel()` - Get human-readable document type
- `getStatusColor()` - Get status badge color

### User Model Extensions
**Location:** `app/Models/User.php`

**Relationships:**
- `kycDocuments()` - HasMany KycDocument
- `latestKyc()` - HasOne KycDocument (latest)

**Helper Methods:**
- `hasVerifiedKyc()` - Check if user has verified KYC

## Notifications

### KycStatusNotification
**Location:** `app/Notifications/KycStatusNotification.php`

**Channels:** 
- Mail (email notification)
- Database (in-app notification)

**Triggers:**
- KYC Approved
- KYC Rejected

**Email Content:**
- Approval: Congratulations message with dashboard link
- Rejection: Reason with resubmit link

## File Storage

### Storage Disk
Files are stored in `storage/app/public/kyc_documents/`

### Public Access
Symlink created: `public/storage` → `storage/app/public`

### File Types Accepted
- Images: JPG, JPEG, PNG
- Documents: PDF
- Max Size: 5MB per file

## Views

### User Views
- `resources/views/kyc/application.blade.php` - Submission form
- `resources/views/kyc/status.blade.php` - Status view

### Admin Views
- `resources/views/admin/kyc/index.blade.php` - KYC list
- `resources/views/admin/kyc/show.blade.php` - KYC details

### Dashboard Integration
- `resources/views/super-admin/dashboard.blade.php` - Stats and recent KYC

## Security Features

1. **Authentication Required** - All routes protected by auth middleware
2. **Email Verification** - Users must verify email before KYC
3. **Admin Authorization** - Super admin role required for approval
4. **File Validation** - Type and size restrictions
5. **CSRF Protection** - All forms protected
6. **Single Active KYC** - Prevents duplicate submissions

## Error Handling

### Notification Failures
Both approve and reject methods wrap notifications in try-catch blocks to prevent email failures from breaking the approval process. Errors are logged to Laravel log file.

### File Upload Errors
Validation errors are displayed to users with specific messages about file requirements.

## Testing Checklist

### User Flow
- [ ] User can access KYC form
- [ ] User can upload documents (front, back, selfie)
- [ ] User can submit KYC application
- [ ] User sees pending status after submission
- [ ] User cannot submit duplicate KYC
- [ ] User can view KYC status page
- [ ] User receives email on approval
- [ ] User receives email on rejection
- [ ] User can resubmit after rejection

### Admin Flow
- [ ] Admin sees KYC stats on dashboard
- [ ] Admin can view all KYC applications
- [ ] Admin can filter by status
- [ ] Admin can view KYC details
- [ ] Admin can see uploaded documents
- [ ] Admin can approve with optional remarks
- [ ] Admin can reject with required remarks
- [ ] Admin actions update status correctly
- [ ] Notifications are sent to users

## Configuration

### Email Setup
Configure in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Storage Setup
Run once after deployment:
```bash
php artisan storage:link
```

### Database Setup
Run migrations:
```bash
php artisan migrate
```

## Maintenance

### Clear Rejected KYC
Rejected KYC records are automatically deleted when user clicks "Resubmit KYC" button.

### View Logs
Check notification errors:
```bash
tail -f storage/logs/laravel.log
```

### Database Cleanup (Optional)
To remove old rejected KYC after 30 days:
```sql
DELETE FROM kyc_documents 
WHERE status = 'rejected' 
AND verified_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

## Future Enhancements

1. **OCR Integration** - Auto-extract document numbers
2. **Face Matching** - Compare selfie with document photo
3. **Document Verification API** - Verify document authenticity
4. **Bulk Actions** - Approve/reject multiple KYC at once
5. **Advanced Filters** - Search by user, date range, document type
6. **Export Reports** - Download KYC statistics as CSV/PDF
7. **Queue Notifications** - Use Laravel queues for email sending
8. **Real-time Updates** - WebSocket notifications for status changes
9. **Document Expiry** - Track and alert for expiring documents
10. **Audit Trail** - Detailed log of all KYC actions

## Support

For issues or questions:
- Check Laravel logs: `storage/logs/laravel.log`
- Verify database tables exist
- Ensure storage symlink is created
- Check file permissions on storage directory
- Verify email configuration

---

**Last Updated:** October 6, 2025  
**Version:** 1.0.0

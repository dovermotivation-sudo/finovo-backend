# KYC Validation Testing Guide

## Quick Test Instructions

### Step 1: Access KYC Form
1. Login as a regular user (not super admin)
2. Navigate to: `http://127.0.0.1:8000/kyc-application`
3. You should see the KYC application form

---

## Test Cases

### ✅ Test Case 1: Valid Aadhaar Number
**Steps:**
1. Select "Aadhaar Card" from Document Type dropdown
2. Notice the blue hint box appears with format information
3. Enter: `234567891234`
4. Upload a sample image for document front
5. Click "Submit KYC"

**Expected Result:** ✅ Form submits successfully

---

### ❌ Test Case 2: Invalid Aadhaar (Starts with 0)
**Steps:**
1. Select "Aadhaar Card"
2. Enter: `012345678901`
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ❌ Error message: "Invalid Aadhaar number format. It must be 12 digits and cannot start with 0 or 1. Example: 234567891234"

---

### ❌ Test Case 3: Invalid Aadhaar (Wrong Length)
**Steps:**
1. Select "Aadhaar Card"
2. Enter: `12345678901` (only 11 digits)
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ❌ Error message about invalid format

---

### ✅ Test Case 4: Valid PAN Card
**Steps:**
1. Select "PAN Card" from dropdown
2. Notice hint box shows PAN format
3. Enter: `ABCDE1234F` (will auto-convert to uppercase)
4. Upload document
5. Click "Submit KYC"

**Expected Result:** ✅ Form submits successfully

---

### ❌ Test Case 5: Invalid PAN (Lowercase)
**Steps:**
1. Select "PAN Card"
2. Try entering: `abcde1234f`
3. Notice it auto-converts to uppercase: `ABCDE1234F`

**Expected Result:** ✅ Auto-uppercase feature works, form should submit

---

### ❌ Test Case 6: Invalid PAN (Wrong Format)
**Steps:**
1. Select "PAN Card"
2. Enter: `ABC1234567` (wrong format)
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ❌ Error message: "Invalid PAN card format. It must be in format: ABCDE1234F (5 letters, 4 digits, 1 letter). Example: ABCDE1234F"

---

### ✅ Test Case 7: Valid Driving License
**Steps:**
1. Select "Driving License"
2. Enter: `MH0120200012345`
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ✅ Form submits successfully

---

### ❌ Test Case 8: Invalid Driving License
**Steps:**
1. Select "Driving License"
2. Enter: `MH012020001234` (only 14 characters instead of 15)
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ❌ Error message about invalid format

---

### ✅ Test Case 9: Valid Passport
**Steps:**
1. Select "Passport"
2. Enter: `A1234567`
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ✅ Form submits successfully

---

### ❌ Test Case 10: Invalid Passport
**Steps:**
1. Select "Passport"
2. Enter: `12345678` (no letter at start)
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ❌ Error message about invalid format

---

### ✅ Test Case 11: Valid Voter ID
**Steps:**
1. Select "Voter ID"
2. Enter: `ABC1234567`
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ✅ Form submits successfully

---

### ❌ Test Case 12: Invalid Voter ID
**Steps:**
1. Select "Voter ID"
2. Enter: `AB1234567` (only 2 letters instead of 3)
3. Upload document
4. Click "Submit KYC"

**Expected Result:** ❌ Error message about invalid format

---

## UI/UX Features to Verify

### 1. Dynamic Hint Box
- [ ] Hint box appears when document type is selected
- [ ] Hint box shows correct format for each document type
- [ ] Hint box has blue background and info icon
- [ ] Hint box shows example number

### 2. Auto-Uppercase
- [ ] PAN card input converts to uppercase automatically
- [ ] Driving License input converts to uppercase
- [ ] Passport input converts to uppercase
- [ ] Voter ID input converts to uppercase
- [ ] Aadhaar remains numeric (no uppercase needed)

### 3. Placeholder Text
- [ ] Placeholder changes based on document type
- [ ] Shows helpful example format

### 4. HTML5 Pattern Validation
- [ ] Browser shows validation message before form submit
- [ ] Red border appears on invalid input (browser default)

---

## Admin Testing

### Test Case 13: View Submitted KYC
**Steps:**
1. Login as super admin
2. Go to: `http://127.0.0.1:8000/admin/kyc`
3. Click on any submitted KYC

**Expected Result:** ✅ Can view KYC details with validated document numbers

---

### Test Case 14: Approve KYC
**Steps:**
1. On KYC detail page
2. Add optional remarks
3. Click "Approve KYC"

**Expected Result:** 
- ✅ KYC status changes to "Verified"
- ✅ User receives email notification
- ✅ Database notification created
- ✅ Redirected to KYC list with success message

---

### Test Case 15: Reject KYC
**Steps:**
1. On KYC detail page
2. Add required remarks (e.g., "Document not clear")
3. Click "Reject KYC"

**Expected Result:**
- ✅ KYC status changes to "Rejected"
- ✅ User receives email with rejection reason
- ✅ User can resubmit

---

## Sample Test Data

### Valid Test Numbers

```
Aadhaar: 234567891234, 987654321098, 567812349876
PAN: ABCDE1234F, ZYXWV9876K, PANCD5678M
Driving License: MH0120200012345, DL1420210098765, KA0320190054321
Passport: A1234567, Z9876543, K5432109
Voter ID: ABC1234567, XYZ9876543, MNP5432109
```

### Invalid Test Numbers

```
Aadhaar: 012345678901 (starts with 0), 123456789012 (starts with 1), 12345678901 (11 digits)
PAN: abcde1234f (lowercase), ABCD1234F (4 letters), ABCDE12345 (5 digits)
Driving License: mh0120200012345 (lowercase), MH012020001234 (14 chars)
Passport: 12345678 (no letter), AB123456 (2 letters)
Voter ID: AB1234567 (2 letters), ABCD1234567 (4 letters)
```

---

## Browser Testing

Test on multiple browsers to ensure validation works:
- [ ] Chrome
- [ ] Firefox
- [ ] Edge
- [ ] Safari (if available)

---

## Mobile Testing

Test on mobile devices:
- [ ] Form is responsive
- [ ] Hint box displays properly
- [ ] Auto-uppercase works on mobile keyboard
- [ ] File upload works on mobile

---

## Error Handling Testing

### Test Case 16: No Document Type Selected
**Steps:**
1. Leave document type empty
2. Enter document number
3. Try to submit

**Expected Result:** ❌ Browser validation: "Please select an item in the list"

---

### Test Case 17: No Document Number
**Steps:**
1. Select document type
2. Leave document number empty
3. Try to submit

**Expected Result:** ❌ Browser validation: "Please fill out this field"

---

### Test Case 18: No File Uploaded
**Steps:**
1. Fill all fields
2. Don't upload document front
3. Try to submit

**Expected Result:** ❌ Validation error: "The document front field is required"

---

## Performance Testing

- [ ] Form loads quickly
- [ ] JavaScript validation is instant
- [ ] File upload progress shows
- [ ] Server validation responds within 2 seconds

---

## Accessibility Testing

- [ ] All form fields have proper labels
- [ ] Error messages are screen-reader friendly
- [ ] Keyboard navigation works
- [ ] Tab order is logical

---

## Quick Manual Test Script

```bash
# 1. Clear caches
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# 2. Check routes exist
php artisan route:list --name=kyc

# 3. Check database tables
php artisan migrate:status

# 4. Test in browser
# Visit: http://127.0.0.1:8000/kyc-application
```

---

## Automated Testing (Future)

Create feature tests:
```php
// tests/Feature/KycValidationTest.php
public function test_valid_aadhaar_passes_validation()
{
    $response = $this->post('/kyc-application', [
        'document_type' => 'aadhaar',
        'document_number' => '234567891234',
        // ... other fields
    ]);
    
    $response->assertRedirect();
}

public function test_invalid_aadhaar_fails_validation()
{
    $response = $this->post('/kyc-application', [
        'document_type' => 'aadhaar',
        'document_number' => '012345678901',
        // ... other fields
    ]);
    
    $response->assertSessionHasErrors('document_number');
}
```

---

## Troubleshooting

### Issue: Hint box not appearing
**Solution:** Clear browser cache and check JavaScript console for errors

### Issue: Auto-uppercase not working
**Solution:** Ensure JavaScript is enabled in browser

### Issue: Validation not working
**Solution:** 
1. Clear Laravel caches: `php artisan config:clear`
2. Check browser console for JavaScript errors
3. Verify controller has latest validation rules

### Issue: Form submits with invalid data
**Solution:** Check if JavaScript validation is bypassed, server-side validation should still catch it

---

**Testing Completed:** [ ] Yes [ ] No  
**Date Tested:** _____________  
**Tested By:** _____________  
**Issues Found:** _____________

---

**Last Updated:** October 6, 2025  
**Version:** 1.0.0

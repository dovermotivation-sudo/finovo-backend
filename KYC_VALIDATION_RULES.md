# KYC Document Number Validation Rules

## Overview
The KYC system now includes strict validation for Indian government-issued document numbers to prevent submission of dummy or invalid numbers.

## Validation Rules by Document Type

### 1. Aadhaar Card
**Format:** 12 digits  
**Pattern:** `^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$`  
**Rules:**
- Must be exactly 12 digits
- Cannot start with 0 or 1
- Only numeric characters allowed

**Valid Examples:**
- `234567891234`
- `987654321098`
- `567812349876`

**Invalid Examples:**
- `123456789012` ❌ (starts with 1)
- `012345678901` ❌ (starts with 0)
- `12345678901` ❌ (only 11 digits)

---

### 2. PAN Card
**Format:** 5 letters + 4 digits + 1 letter (all uppercase)  
**Pattern:** `^[A-Z]{5}[0-9]{4}[A-Z]{1}$`  
**Rules:**
- First 5 characters must be uppercase letters
- Next 4 characters must be digits
- Last character must be an uppercase letter
- Total 10 characters

**Valid Examples:**
- `ABCDE1234F`
- `ZYXWV9876K`
- `PANCD5678M`

**Invalid Examples:**
- `abcde1234f` ❌ (lowercase letters)
- `ABCD1234F` ❌ (only 4 letters at start)
- `ABCDE12345` ❌ (5 digits instead of 4)
- `ABCDE1234` ❌ (missing last letter)

---

### 3. Driving License
**Format:** 2 letters + 2 digits + 11 digits  
**Pattern:** `^[A-Z]{2}[0-9]{2}[0-9]{11}$`  
**Rules:**
- First 2 characters are state code (uppercase letters)
- Next 2 characters are RTO code (digits)
- Last 11 characters are license number (digits)
- Total 15 characters

**Valid Examples:**
- `MH0120200012345`
- `DL1420210098765`
- `KA0320190054321`

**Invalid Examples:**
- `mh0120200012345` ❌ (lowercase state code)
- `MH120200012345` ❌ (only 1 digit for RTO)
- `MH012020001234` ❌ (only 10 digits in license number)

---

### 4. Passport
**Format:** 1 letter + 7 digits  
**Pattern:** `^[A-Z]{1}[0-9]{7}$`  
**Rules:**
- First character must be an uppercase letter
- Next 7 characters must be digits
- Total 8 characters

**Valid Examples:**
- `A1234567`
- `Z9876543`
- `K5432109`

**Invalid Examples:**
- `a1234567` ❌ (lowercase letter)
- `AB123456` ❌ (2 letters instead of 1)
- `A123456` ❌ (only 6 digits)
- `12345678` ❌ (no letter)

---

### 5. Voter ID
**Format:** 3 letters + 7 digits  
**Pattern:** `^[A-Z]{3}[0-9]{7}$`  
**Rules:**
- First 3 characters must be uppercase letters
- Next 7 characters must be digits
- Total 10 characters

**Valid Examples:**
- `ABC1234567`
- `XYZ9876543`
- `MNP5432109`

**Invalid Examples:**
- `abc1234567` ❌ (lowercase letters)
- `AB1234567` ❌ (only 2 letters)
- `ABC123456` ❌ (only 6 digits)
- `ABCD1234567` ❌ (4 letters instead of 3)

---

## User Experience Features

### 1. Dynamic Format Hints
When a user selects a document type, the form automatically displays:
- Format requirements with emoji icon 📋
- Example of valid document number
- Blue highlighted info box

### 2. Auto-Uppercase
For document types that require uppercase letters (PAN, Driving License, Passport, Voter ID), the input automatically converts to uppercase as the user types.

### 3. Input Placeholder
The placeholder text changes based on selected document type to guide users.

### 4. HTML5 Pattern Validation
Browser-level validation using HTML5 `pattern` attribute provides instant feedback before form submission.

### 5. Server-Side Validation
Backend validation in Laravel controller ensures data integrity even if client-side validation is bypassed.

### 6. Custom Error Messages
Clear, descriptive error messages tell users exactly what format is expected.

---

## Implementation Details

### Backend Validation (KycController.php)
```php
switch ($request->document_type) {
    case 'aadhaar':
        $rules['document_number'] = ['required', 'regex:/^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/'];
        break;
    case 'pan':
        $rules['document_number'] = ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'];
        break;
    // ... other cases
}
```

### Frontend Validation (JavaScript)
```javascript
function updateDocumentHint() {
    // Updates placeholder, pattern, and hint text
    // Applies auto-uppercase for specific document types
}
```

---

## Testing Scenarios

### Test Case 1: Valid Aadhaar
- Input: `234567891234`
- Expected: ✅ Form submits successfully

### Test Case 2: Invalid Aadhaar (starts with 0)
- Input: `012345678901`
- Expected: ❌ Error: "Invalid Aadhaar number format..."

### Test Case 3: Valid PAN
- Input: `ABCDE1234F`
- Expected: ✅ Form submits successfully

### Test Case 4: Invalid PAN (lowercase)
- Input: `abcde1234f`
- Expected: ❌ Error: "Invalid PAN card format..."

### Test Case 5: Valid Driving License
- Input: `MH0120200012345`
- Expected: ✅ Form submits successfully

### Test Case 6: Invalid Driving License (wrong length)
- Input: `MH012020001234`
- Expected: ❌ Error: "Invalid Driving License format..."

---

## Security Benefits

1. **Prevents Dummy Data**: Users cannot submit fake or random numbers
2. **Data Quality**: Ensures only properly formatted documents are stored
3. **Reduces Manual Review**: Admin doesn't waste time on obviously fake submissions
4. **Compliance**: Helps maintain regulatory compliance for KYC verification
5. **User Education**: Teaches users the correct format of their documents

---

## Future Enhancements

1. **Checksum Validation**: Add Verhoeff algorithm for Aadhaar checksum validation
2. **Real-time API Verification**: Integrate with government APIs to verify document authenticity
3. **Duplicate Detection**: Check if document number already exists in system
4. **Masked Display**: Show only last 4 digits of Aadhaar for privacy
5. **Document Expiry**: Track and validate passport/license expiry dates

---

## Common User Errors & Solutions

| Error | Cause | Solution |
|-------|-------|----------|
| "Cannot start with 0 or 1" | Invalid Aadhaar | Check your Aadhaar card - it should start with 2-9 |
| "Must be uppercase" | Lowercase PAN | PAN must be in CAPITAL LETTERS |
| "Wrong number of digits" | Incomplete number | Count the digits carefully - Aadhaar needs exactly 12 |
| "Invalid format" | Spaces or dashes | Remove all spaces and special characters |

---

**Last Updated:** October 6, 2025  
**Version:** 1.1.0

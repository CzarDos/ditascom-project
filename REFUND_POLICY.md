# Certificate Request Refund Policy

## Overview

This document outlines the refund policy for certificate requests in the DITASCOM system.

## Current Implementation

### Cancel Before Payment ✅ (Implemented)

**Scenario:** User cancels request on the payment page BEFORE completing payment

**Process:**
1. User clicks "Cancel Request" button on payment page
2. Confirmation dialog appears
3. If confirmed, the unpaid request is deleted from the database
4. User is redirected to dashboard with success message
5. **No refund needed** - User never paid

**User Experience:**
- Red "Cancel Request" button on payment page
- Clear confirmation message
- Can create a new request anytime

---

## Refund Options for Paid Requests

If you want to allow refunds for requests that have already been paid, you have three options:

### Option 1: No Refunds Policy (Recommended - Simplest)

**Policy Statement:**
> "All certificate request payments are final and non-refundable once payment is completed. Please ensure all information is correct before submitting payment."

**Implementation:**
- ✅ Already implemented - paid requests cannot be cancelled via the cancel button
- Add policy statement to payment page and terms of service
- Users can still contact admin for exceptional cases

**Pros:**
- Simple to manage
- No technical implementation needed
- Clear expectations for users
- Standard practice for digital services

**Cons:**
- Less flexible for users
- May require manual admin intervention for legitimate cases

---

### Option 2: Manual Refunds (Moderate Complexity)

**Process:**
1. User contacts administrator via email/support
2. Admin reviews the refund request
3. Admin processes refund manually through PayMongo dashboard
4. Admin updates request status in system

**Implementation Steps:**

1. **Add Refund Request Feature:**
   - Add "Request Refund" button for paid requests
   - User submits refund reason
   - Admin receives notification

2. **Admin Dashboard:**
   - View refund requests
   - Approve/Deny with reason
   - Manual refund via PayMongo dashboard

3. **PayMongo Dashboard Process:**
   - Login to PayMongo dashboard
   - Navigate to Payments
   - Find the payment
   - Click "Refund" button
   - Enter refund amount
   - Confirm refund

**Pros:**
- Full control over refunds
- Can evaluate each case individually
- No API integration needed

**Cons:**
- Manual work for admin
- Slower process
- Requires admin training

---

### Option 3: Automated Refunds (Complex - Requires Development)

**Process:**
1. User requests refund through system
2. Admin approves refund
3. System automatically processes refund via PayMongo API
4. User receives refund to original payment method

**Implementation Requirements:**

#### 1. Add Refund Status to Database

```sql
ALTER TABLE certificate_requests 
ADD COLUMN refund_status ENUM('none', 'requested', 'approved', 'denied', 'processed') DEFAULT 'none',
ADD COLUMN refund_requested_at TIMESTAMP NULL,
ADD COLUMN refund_reason TEXT NULL,
ADD COLUMN refund_processed_at TIMESTAMP NULL,
ADD COLUMN refund_amount DECIMAL(10,2) NULL,
ADD COLUMN paymongo_refund_id VARCHAR(255) NULL;
```

#### 2. Create Refund Service

```php
// app/Services/PayMongoRefundService.php
public function createRefund($paymentIntentId, $amount, $reason = null)
{
    $response = Http::withBasicAuth($this->secretKey, '')
        ->post("{$this->baseUrl}/refunds", [
            'data' => [
                'attributes' => [
                    'amount' => $amount * 100, // Convert to centavos
                    'payment_intent' => $paymentIntentId,
                    'reason' => $reason ?? 'requested_by_customer',
                    'notes' => 'Certificate request refund'
                ]
            ]
        ]);
    
    return $response->json();
}
```

#### 3. Add Controller Methods

```php
// Request refund (Parishioner)
public function requestRefund(Request $request, $id)
{
    $certRequest = CertificateRequest::where('user_id', auth()->id())->findOrFail($id);
    
    if ($certRequest->payment_status !== 'paid') {
        return back()->with('error', 'Only paid requests can be refunded.');
    }
    
    if ($certRequest->status === 'completed') {
        return back()->with('error', 'Completed requests cannot be refunded.');
    }
    
    $certRequest->update([
        'refund_status' => 'requested',
        'refund_requested_at' => now(),
        'refund_reason' => $request->input('reason')
    ]);
    
    // Notify admin
    
    return back()->with('success', 'Refund request submitted. Admin will review your request.');
}

// Process refund (Admin)
public function processRefund($id)
{
    $certRequest = CertificateRequest::findOrFail($id);
    
    if ($certRequest->refund_status !== 'approved') {
        return back()->with('error', 'Refund must be approved first.');
    }
    
    $refundService = new PayMongoRefundService();
    $result = $refundService->createRefund(
        $certRequest->paymongo_payment_intent_id,
        $certRequest->payment_amount,
        $certRequest->refund_reason
    );
    
    if ($result && isset($result['data'])) {
        $certRequest->update([
            'refund_status' => 'processed',
            'refund_processed_at' => now(),
            'refund_amount' => $certRequest->payment_amount,
            'paymongo_refund_id' => $result['data']['id']
        ]);
        
        return back()->with('success', 'Refund processed successfully.');
    }
    
    return back()->with('error', 'Failed to process refund.');
}
```

#### 4. Add Routes

```php
// Parishioner
Route::post('/parishioner/request/{id}/refund', 'requestRefund')->name('parishioner.certificate-request.refund');

// Admin
Route::post('/admin/certificate-requests/{id}/approve-refund', 'approveRefund');
Route::post('/admin/certificate-requests/{id}/deny-refund', 'denyRefund');
Route::post('/admin/certificate-requests/{id}/process-refund', 'processRefund');
```

**Pros:**
- Automated process
- Faster refunds
- Better user experience
- Audit trail

**Cons:**
- Complex implementation
- Requires testing
- PayMongo API integration
- More code to maintain

---

## Recommended Approach

### For Small to Medium Operations:
**Option 1 (No Refunds)** with exceptional case handling:
- Clear policy statement
- Users contact admin for exceptional cases
- Admin handles manually via PayMongo dashboard

### For Large Operations:
**Option 2 (Manual Refunds)** with request tracking:
- Users can submit refund requests through system
- Admin reviews and processes via dashboard
- Keeps track of refund requests

### For Enterprise Level:
**Option 3 (Automated Refunds)** for full automation

---

## Refund Policy Template

Add this to your Terms of Service and Payment Page:

```
REFUND POLICY

1. Cancellation Before Payment
   - You may cancel your certificate request at any time before completing payment.
   - No charges will be applied.

2. Refunds After Payment
   [Choose one:]
   
   OPTION A (No Refunds):
   - All payments are final and non-refundable once completed.
   - Please ensure all information is correct before submitting payment.
   - For exceptional circumstances, please contact our administrator.
   
   OPTION B (Manual Refunds):
   - Refund requests must be submitted within 24 hours of payment.
   - Refunds are subject to approval by the administrator.
   - Approved refunds will be processed within 5-7 business days.
   - Refunds will be returned to the original payment method.
   - Completed/downloaded certificates are not eligible for refunds.
   
   OPTION C (Automated Refunds):
   - You may request a refund within 24 hours of payment.
   - Refunds are subject to administrator approval.
   - Approved refunds are processed automatically within 1-2 business days.
   - Refunds will be returned to the original payment method.
   - Completed/downloaded certificates are not eligible for refunds.

3. Contact Information
   - For refund inquiries, contact: [admin email]
```

---

## Current Status

✅ **Implemented:**
- Cancel button on payment page (before payment)
- Prevents cancellation of paid requests
- Clear user messaging

⏳ **Not Implemented:**
- Refund policy for paid requests
- Refund request system
- Automated refund processing

## Next Steps

1. **Decide on refund policy** (Option 1, 2, or 3)
2. **Add policy statement** to payment page and terms
3. **Implement chosen option** if needed
4. **Train administrators** on refund process
5. **Update user documentation**

---

## Testing Refunds

### PayMongo Test Mode
When testing refunds in PayMongo test mode:
- Use test API keys
- Test refunds work the same as live refunds
- No real money is involved

### Test Scenarios
1. Cancel before payment ✅
2. Attempt to cancel after payment (should be blocked) ✅
3. Manual refund via PayMongo dashboard
4. Automated refund via API (if implemented)

---

## Important Notes

⚠️ **PayMongo Refund Limitations:**
- Refunds can take 5-10 business days to appear in customer's account
- Partial refunds are supported
- Full refunds are supported
- Refunds are only available for successful payments
- Some payment methods may have different refund timelines

⚠️ **Legal Considerations:**
- Consult with legal counsel for your refund policy
- Comply with local consumer protection laws
- Clearly communicate policy to users
- Keep records of all refund transactions

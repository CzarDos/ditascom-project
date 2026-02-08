# PayMongo Payment Gateway Integration Guide

## Overview
This guide documents the PayMongo payment gateway integration for the DITASCOM certificate request system. The integration enables secure online payments for certificate requests using PayMongo's checkout session API.

## Features Implemented

### 1. **Payment Flow**
- After submitting a certificate request, users are redirected to a payment page
- Users click "Proceed to Secure Payment" and are redirected to PayMongo's hosted checkout page
- PayMongo supports multiple payment methods:
  - Credit/Debit Cards (Visa, Mastercard)
  - GCash
  - PayMaya
  - GrabPay
- After successful payment, users are redirected back to a success page
- Payment status is verified and updated in the database

### 2. **Certificate Pricing**
- Fixed price: **₱50.00 per certificate**
- Configurable via `.env` file (`CERTIFICATE_AMOUNT`)

### 3. **Payment Tracking**
- Each certificate request tracks:
  - Payment status (paid/unpaid)
  - Payment amount
  - PayMongo checkout session ID
  - PayMongo payment intent ID
  - Payment reference number
  - Payment timestamp

## Files Created/Modified

### New Files
1. **`config/paymongo.php`** - PayMongo configuration file
2. **`app/Services/PayMongoService.php`** - Service class for PayMongo API interactions
3. **`app/Http/Controllers/PayMongoWebhookController.php`** - Webhook handler for payment events
4. **`database/migrations/2025_11_11_161105_add_paymongo_fields_to_certificate_requests_table.php`** - Database migration

### Modified Files
1. **`app/Models/CertificateRequest.php`** - Added PayMongo fields to fillable and casts
2. **`app/Http/Controllers/Parishioner/CertificateRequestController.php`** - Updated payment logic
3. **`resources/views/parishioner/payment.blade.php`** - Updated payment UI
4. **`routes/web.php`** - Added webhook route
5. **`.env.example`** - Added PayMongo configuration

## Configuration

### Environment Variables
Add these to your `.env` file:

```env
# PayMongo Configuration
PAYMONGO_PUBLIC_KEY=pk_test_hmn7wsCgxQysD7Yi5e7Lu5Kq
PAYMONGO_SECRET_KEY=sk_test_7yKeDKk5WRq6oekBScrRgDwd
PAYMONGO_BASE_URL=https://api.paymongo.com/v1
CERTIFICATE_AMOUNT=50.00
```

### Database Migration
The migration adds the following fields to `certificate_requests` table:
- `paymongo_checkout_id` - Stores PayMongo checkout session ID
- `paymongo_payment_intent_id` - Stores PayMongo payment intent ID
- `payment_paid_at` - Timestamp when payment was completed

Run the migration:
```bash
php artisan migrate
```

## API Endpoints

### Payment Routes
- **POST** `/parishioner/request/pay/{id}` - Creates PayMongo checkout session
- **GET** `/parishioner/request/payment/{id}` - Shows payment page
- **GET** `/parishioner/request/payment-success/{id}` - Payment success callback

### Webhook Route
- **POST** `/paymongo/webhook` - Receives PayMongo webhook events (no auth required)

## PayMongo Service Methods

### `createCheckoutSession($data)`
Creates a new checkout session for payment.

**Parameters:**
```php
[
    'line_items' => [
        [
            'currency' => 'PHP',
            'amount' => 5000, // Amount in centavos (₱50.00)
            'description' => 'Baptismal Certificate',
            'name' => 'Baptismal Certificate Request',
            'quantity' => 1,
        ]
    ],
    'payment_method_types' => ['card', 'gcash', 'paymaya', 'grab_pay'],
    'success_url' => 'https://yoursite.com/payment-success/1',
    'cancel_url' => 'https://yoursite.com/payment/1',
    'description' => 'Payment for Baptismal Certificate',
    'reference_number' => 'REQ-0001',
    'metadata' => [
        'certificate_request_id' => 1,
        'user_id' => 5,
        'certificate_type' => 'baptismal',
    ],
]
```

**Returns:** Checkout session data with `checkout_url`

### `retrieveCheckoutSession($checkoutSessionId)`
Retrieves checkout session details to verify payment status.

### `expireCheckoutSession($checkoutSessionId)`
Expires an active checkout session.

## Webhook Configuration

### Setting Up Webhooks in PayMongo Dashboard

1. Go to [PayMongo Dashboard](https://dashboard.paymongo.com/developers/webhooks)
2. Click "Add Webhook"
3. Enter your webhook URL: `https://yourdomain.com/paymongo/webhook`
4. Select events to listen for:
   - `checkout_session.payment.paid`
   - `payment.paid`
   - `payment.failed`
5. Save the webhook

### Webhook Events Handled

**`checkout_session.payment.paid`** / **`payment.paid`**
- Updates certificate request payment status to "paid"
- Records payment timestamp
- Generates payment reference number
- Stores payment intent ID

**`payment.failed`**
- Logs payment failure
- Can trigger email notification to user

## Payment Flow Diagram

```
1. User submits certificate request
   ↓
2. Redirected to payment page (/parishioner/request/payment/{id})
   ↓
3. User clicks "Proceed to Secure Payment"
   ↓
4. Backend creates PayMongo checkout session
   ↓
5. User redirected to PayMongo hosted checkout page
   ↓
6. User completes payment on PayMongo
   ↓
7. PayMongo redirects to success URL (/parishioner/request/payment-success/{id})
   ↓
8. Backend verifies payment with PayMongo API
   ↓
9. Payment status updated in database
   ↓
10. Success page displayed to user
```

## Testing

### Test Cards (PayMongo Test Mode)
Use these test card numbers in test mode:

**Successful Payment:**
- Card Number: `4343434343434345`
- Expiry: Any future date
- CVC: Any 3 digits

**Failed Payment:**
- Card Number: `4571736000000075`
- Expiry: Any future date
- CVC: Any 3 digits

### Test GCash/PayMaya
In test mode, PayMongo provides mock payment pages for e-wallets.

## Security Considerations

1. **API Keys**: Never commit `.env` file with real API keys
2. **Webhook Verification**: Consider implementing webhook signature verification
3. **HTTPS Required**: PayMongo requires HTTPS for production webhooks
4. **CSRF Protection**: All payment routes use Laravel's CSRF protection

## Troubleshooting

### Payment not updating after successful payment
- Check webhook is properly configured in PayMongo dashboard
- Verify webhook URL is accessible (not behind auth)
- Check Laravel logs: `storage/logs/laravel.log`

### Checkout session creation fails
- Verify API keys are correct in `.env`
- Check amount is in centavos (multiply by 100)
- Ensure all required fields are provided

### Webhook not receiving events
- Verify webhook URL is publicly accessible
- Check PayMongo dashboard for webhook delivery logs
- Ensure route is not protected by auth middleware

## Production Deployment Checklist

- [ ] Replace test API keys with production keys
- [ ] Update `PAYMONGO_PUBLIC_KEY` in `.env`
- [ ] Update `PAYMONGO_SECRET_KEY` in `.env`
- [ ] Configure webhook URL in PayMongo production dashboard
- [ ] Ensure site is using HTTPS
- [ ] Test payment flow end-to-end
- [ ] Set up email notifications for payment events
- [ ] Monitor webhook delivery in PayMongo dashboard

## Support Resources

- [PayMongo API Documentation](https://developers.paymongo.com/docs)
- [PayMongo Checkout Sessions](https://developers.paymongo.com/docs/checkout)
- [PayMongo Webhooks](https://developers.paymongo.com/docs/webhooks)
- [PayMongo Dashboard](https://dashboard.paymongo.com)

## Notes

- All amounts in PayMongo API must be in centavos (smallest currency unit)
- Checkout sessions expire after 1 hour of inactivity
- PayMongo charges a transaction fee (check their pricing page)
- Test mode and live mode have separate API keys and dashboards

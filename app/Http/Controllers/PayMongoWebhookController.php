<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CertificateRequest;
use App\Services\PayMongoService;

class PayMongoWebhookController extends Controller
{
    /**
     * Handle PayMongo webhook events
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        // Log the webhook payload for debugging
        Log::info('PayMongo Webhook Received', $request->all());

        $payload = $request->all();

        // Verify webhook signature (optional but recommended)
        // $this->verifyWebhookSignature($request);

        // Get event type
        $eventType = $payload['data']['attributes']['type'] ?? null;

        // Handle different event types
        switch ($eventType) {
            case 'checkout_session.payment.paid':
                $this->handlePaymentPaid($payload);
                break;

            case 'payment.paid':
                $this->handlePaymentPaid($payload);
                break;

            case 'payment.failed':
                $this->handlePaymentFailed($payload);
                break;

            default:
                Log::info('Unhandled PayMongo webhook event: ' . $eventType);
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * Handle successful payment
     *
     * @param array $payload
     * @return void
     */
    protected function handlePaymentPaid($payload)
    {
        try {
            // Extract metadata from the payload
            $metadata = $payload['data']['attributes']['data']['attributes']['metadata'] ?? [];
            $certificateRequestId = $metadata['certificate_request_id'] ?? null;

            if (!$certificateRequestId) {
                Log::error('Certificate request ID not found in webhook metadata');
                return;
            }

            // Find the certificate request
            $certificateRequest = CertificateRequest::find($certificateRequestId);

            if (!$certificateRequest) {
                Log::error('Certificate request not found: ' . $certificateRequestId);
                return;
            }

            // Check if already marked as paid
            if ($certificateRequest->payment_status === 'paid') {
                Log::info('Certificate request already marked as paid: ' . $certificateRequestId);
                return;
            }

            // Update payment status
            $certificateRequest->payment_status = 'paid';
            $certificateRequest->payment_paid_at = now();
            
            // Store payment intent ID if available
            $paymentIntentId = $payload['data']['attributes']['data']['id'] ?? null;
            if ($paymentIntentId) {
                $certificateRequest->paymongo_payment_intent_id = $paymentIntentId;
            }

            // Generate payment reference
            $certificateRequest->payment_reference = 'PAY-' . strtoupper(substr(md5($certificateRequestId . time()), 0, 10));

            $certificateRequest->save();

            Log::info('Payment marked as paid for certificate request: ' . $certificateRequestId);

            // TODO: Send email notification to user about successful payment
            // if ($certificateRequest->user && $certificateRequest->user->email) {
            //     $certificateRequest->user->notify(new PaymentSuccessNotification($certificateRequest));
            // }

        } catch (\Exception $e) {
            Log::error('Error handling payment paid webhook: ' . $e->getMessage());
        }
    }

    /**
     * Handle failed payment
     *
     * @param array $payload
     * @return void
     */
    protected function handlePaymentFailed($payload)
    {
        try {
            $metadata = $payload['data']['attributes']['data']['attributes']['metadata'] ?? [];
            $certificateRequestId = $metadata['certificate_request_id'] ?? null;

            if (!$certificateRequestId) {
                return;
            }

            $certificateRequest = CertificateRequest::find($certificateRequestId);

            if (!$certificateRequest) {
                return;
            }

            Log::info('Payment failed for certificate request: ' . $certificateRequestId);

            // TODO: Send email notification to user about failed payment
            // if ($certificateRequest->user && $certificateRequest->user->email) {
            //     $certificateRequest->user->notify(new PaymentFailedNotification($certificateRequest));
            // }

        } catch (\Exception $e) {
            Log::error('Error handling payment failed webhook: ' . $e->getMessage());
        }
    }

    /**
     * Verify webhook signature (optional)
     *
     * @param Request $request
     * @return bool
     */
    protected function verifyWebhookSignature(Request $request)
    {
        // PayMongo webhook signature verification
        // Implement this based on PayMongo's webhook signature verification docs
        // https://developers.paymongo.com/docs/webhooks

        return true;
    }
}

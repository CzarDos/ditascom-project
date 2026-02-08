<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayMongoService
{
    protected $secretKey;
    protected $publicKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('paymongo.secret_key');
        $this->publicKey = config('paymongo.public_key');
        $this->baseUrl = config('paymongo.base_url');
    }

    /**
     * Create a PayMongo checkout session
     *
     * @param array $data
     * @return array|null
     */
    public function createCheckoutSession($data)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/checkout_sessions", [
                    'data' => [
                        'attributes' => [
                            'send_email_receipt' => true,
                            'show_description' => true,
                            'show_line_items' => true,
                            'line_items' => $data['line_items'],
                            'payment_method_types' => $data['payment_method_types'] ?? [
                                'card',
                                'gcash',
                                'paymaya',
                                'grab_pay',
                                'qrph',
                            ],
                            'success_url' => $data['success_url'],
                            'cancel_url' => $data['cancel_url'],
                            'description' => $data['description'] ?? 'Certificate Request Payment',
                            'reference_number' => $data['reference_number'] ?? null,
                            'metadata' => $data['metadata'] ?? [],
                        ],
                    ],
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PayMongo checkout session creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PayMongo checkout session error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieve a checkout session
     *
     * @param string $checkoutSessionId
     * @return array|null
     */
    public function retrieveCheckoutSession($checkoutSessionId)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get("{$this->baseUrl}/checkout_sessions/{$checkoutSessionId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('PayMongo retrieve session error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Expire a checkout session
     *
     * @param string $checkoutSessionId
     * @return array|null
     */
    public function expireCheckoutSession($checkoutSessionId)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/checkout_sessions/{$checkoutSessionId}/expire");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('PayMongo expire session error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a payment intent (for direct card payments)
     *
     * @param array $data
     * @return array|null
     */
    public function createPaymentIntent($data)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/payment_intents", [
                    'data' => [
                        'attributes' => [
                            'amount' => $data['amount'], // Amount in centavos
                            'payment_method_allowed' => $data['payment_method_allowed'] ?? ['card'],
                            'payment_method_options' => [
                                'card' => [
                                    'request_three_d_secure' => 'any',
                                ],
                            ],
                            'currency' => 'PHP',
                            'description' => $data['description'] ?? 'Certificate Request Payment',
                            'statement_descriptor' => 'DITASCOM',
                            'metadata' => $data['metadata'] ?? [],
                        ],
                    ],
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PayMongo payment intent creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PayMongo payment intent error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieve a payment intent
     *
     * @param string $paymentIntentId
     * @return array|null
     */
    public function retrievePaymentIntent($paymentIntentId)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get("{$this->baseUrl}/payment_intents/{$paymentIntentId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('PayMongo retrieve payment intent error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get public key for frontend
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}

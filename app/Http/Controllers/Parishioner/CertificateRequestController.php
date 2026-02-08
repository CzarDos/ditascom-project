<?php

namespace App\Http\Controllers\Parishioner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayMongoService;

class CertificateRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'certificate_type' => 'required|string',
            'request_for' => 'required|string|in:self,others',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact_number' => 'required|string|regex:/^[0-9]{11}$/|size:11',
            'email' => 'required|email',
            'current_address' => 'required|string',
            'date_of_birth' => 'required|date',
            'purpose' => 'required|string',
            'owner_first_name' => 'nullable|string',
            'owner_last_name' => 'nullable|string',
            'owner_date_of_birth' => 'nullable|date',
            'relationship' => 'nullable|string',
            'third_party_reason' => 'nullable|string',
            'id_photo_path' => 'nullable|file|mimes:jpg,png|max:2048',
            'father_first_name' => 'required|string',
            'father_last_name' => 'required|string',
            'mother_first_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'registered_parish' => 'required|string',
            'id_front_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'id_back_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'additional_photos.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        $certificateRequest = new \App\Models\CertificateRequest();
        $certificateRequest->user_id = auth()->id();
        
        // Handle regular fields
        foreach ($validated as $key => $value) {
            if (!in_array($key, ['id_photo_path', 'id_front_photo', 'id_back_photo', 'additional_photos'])) {
                $certificateRequest->$key = $value;
            }
        }
        
        // Handle file uploads
        if ($request->hasFile('id_photo_path')) {
            $path = $request->file('id_photo_path')->store('id_photos', 'public');
            $certificateRequest->id_photo_path = $path;
        }
        
        if ($request->hasFile('id_front_photo')) {
            $path = $request->file('id_front_photo')->store('id_photos', 'public');
            $certificateRequest->id_front_photo = $path;
        }
        
        if ($request->hasFile('id_back_photo')) {
            $path = $request->file('id_back_photo')->store('id_photos', 'public');
            $certificateRequest->id_back_photo = $path;
        }
        
        // Handle additional photos
        if ($request->hasFile('additional_photos')) {
            $additionalPhotos = [];
            foreach ($request->file('additional_photos') as $file) {
                $path = $file->store('id_photos', 'public');
                $additionalPhotos[] = $path;
            }
            $certificateRequest->additional_photos = $additionalPhotos;
        }
        $certificateRequest->status = 'pending';
        $certificateRequest->payment_status = 'unpaid';
        $certificateRequest->payment_amount = config('paymongo.certificate_amount');
        $certificateRequest->save();
        return redirect()->route('parishioner.certificate-request.payment', ['id' => $certificateRequest->id]);
    }

    public function showPayment($id)
    {
        $certificateRequest = \App\Models\CertificateRequest::findOrFail($id);
        
        // Check if already paid
        if ($certificateRequest->payment_status === 'paid') {
            return redirect()->route('parishioner.dashboard')
                ->with('info', 'This request has already been paid.');
        }
        
        return view('parishioner.payment', ['request' => $certificateRequest]);
    }

    public function paymentSuccess($id)
    {
        $certificateRequest = \App\Models\CertificateRequest::findOrFail($id);
        
        // Verify payment with PayMongo
        if ($certificateRequest->paymongo_checkout_id && $certificateRequest->payment_status !== 'paid') {
            $paymongoService = new PayMongoService();
            $checkoutSession = $paymongoService->retrieveCheckoutSession($certificateRequest->paymongo_checkout_id);
            
            // Check if payment was successful
            if ($checkoutSession && isset($checkoutSession['data']['attributes']['payment_intent'])) {
                $paymentIntent = $checkoutSession['data']['attributes']['payment_intent'];
                
                if ($paymentIntent['attributes']['status'] === 'succeeded') {
                    // Update payment status
                    $certificateRequest->payment_status = 'paid';
                    $certificateRequest->payment_paid_at = now();
                    $certificateRequest->paymongo_payment_intent_id = $paymentIntent['id'];
                    $certificateRequest->payment_reference = 'PAY-' . strtoupper(substr(md5($certificateRequest->id . time()), 0, 10));
                    $certificateRequest->save();
                }
            }
        }
        
        return view('parishioner.payment-success', ['request' => $certificateRequest]);
    }

    public function pay(Request $request, $id)
    {
        $certificateRequest = \App\Models\CertificateRequest::findOrFail($id);
        
        // Check if already paid
        if ($certificateRequest->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been paid.'
            ], 400);
        }
        
        $paymongoService = new PayMongoService();
        
        // Calculate amount in centavos (PayMongo requires amount in smallest currency unit)
        $amountInCentavos = $certificateRequest->payment_amount * 100;
        
        // Create checkout session
        $checkoutData = [
            'line_items' => [
                [
                    'currency' => 'PHP',
                    'amount' => (int) $amountInCentavos,
                    'description' => ucfirst($certificateRequest->certificate_type) . ' Certificate',
                    'name' => ucfirst($certificateRequest->certificate_type) . ' Certificate Request',
                    'quantity' => 1,
                ]
            ],
            'payment_method_types' => ['card', 'gcash', 'paymaya', 'grab_pay', 'qrph'],
            'success_url' => route('parishioner.certificate-request.payment-success', ['id' => $certificateRequest->id]),
            'cancel_url' => route('parishioner.certificate-request.payment', ['id' => $certificateRequest->id]),
            'description' => 'Payment for ' . ucfirst($certificateRequest->certificate_type) . ' Certificate',
            'reference_number' => 'REQ-' . str_pad($certificateRequest->id, 4, '0', STR_PAD_LEFT),
            'metadata' => [
                'certificate_request_id' => $certificateRequest->id,
                'user_id' => $certificateRequest->user_id,
                'certificate_type' => $certificateRequest->certificate_type,
            ],
        ];
        
        $checkoutSession = $paymongoService->createCheckoutSession($checkoutData);
        
        if ($checkoutSession && isset($checkoutSession['data'])) {
            // Save checkout session ID
            $certificateRequest->paymongo_checkout_id = $checkoutSession['data']['id'];
            $certificateRequest->save();
            
            // Return checkout URL
            return response()->json([
                'success' => true,
                'checkout_url' => $checkoutSession['data']['attributes']['checkout_url']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to create payment session. Please try again.'
        ], 500);
    }

    public function dashboard()
    {
        // Only show paid requests to prevent clutter from abandoned checkouts
        $requests = \App\Models\CertificateRequest::where('user_id', auth()->id())
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('parishioner.dashboard', compact('requests'));
    }

    public function show($id)
    {
        $request = \App\Models\CertificateRequest::where('user_id', auth()->id())->findOrFail($id);
        return view('parishioner.request-details', compact('request'));
    }

    public function update(Request $req, $id)
    {
        $certificateRequest = \App\Models\CertificateRequest::where('user_id', auth()->id())->findOrFail($id);
        if ($certificateRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be updated.');
        }
        $validated = $req->validate([
            'certificate_type' => 'required|string',
            'request_for' => 'required|string|in:self,others',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact_number' => 'required|string|regex:/^[0-9]{11}$/|size:11',
            'email' => 'required|email',
            'current_address' => 'required|string',
            'date_of_birth' => 'required|date',
            'purpose' => 'required|string',
            'owner_first_name' => 'nullable|string',
            'owner_last_name' => 'nullable|string',
            'owner_date_of_birth' => 'nullable|date',
            'relationship' => 'nullable|string',
            'third_party_reason' => 'nullable|string',
            'father_first_name' => 'required|string',
            'father_last_name' => 'required|string',
            'mother_first_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'registered_parish' => 'required|string',
            'id_photo_path' => 'nullable|file|mimes:jpg,png|max:2048',
            'id_front_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'id_back_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'additional_photos.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        // Handle regular fields
        foreach ($validated as $key => $value) {
            if (!in_array($key, ['id_photo_path', 'id_front_photo', 'id_back_photo', 'additional_photos'])) {
                $certificateRequest->$key = $value;
            }
        }
        
        // Handle file uploads
        if ($req->hasFile('id_photo_path')) {
            $path = $req->file('id_photo_path')->store('id_photos', 'public');
            $certificateRequest->id_photo_path = $path;
        }
        
        if ($req->hasFile('id_front_photo')) {
            $path = $req->file('id_front_photo')->store('id_photos', 'public');
            $certificateRequest->id_front_photo = $path;
        }
        
        if ($req->hasFile('id_back_photo')) {
            $path = $req->file('id_back_photo')->store('id_photos', 'public');
            $certificateRequest->id_back_photo = $path;
        }
        
        // Handle additional photos
        if ($req->hasFile('additional_photos')) {
            $additionalPhotos = [];
            foreach ($req->file('additional_photos') as $file) {
                $path = $file->store('id_photos', 'public');
                $additionalPhotos[] = $path;
            }
            $certificateRequest->additional_photos = $additionalPhotos;
        }
        $certificateRequest->save();
        return redirect()->route('parishioner.certificate-request.show', $certificateRequest->id)->with('success', 'Request updated successfully.');
    }

    public function cancel($id)
    {
        $certificateRequest = \App\Models\CertificateRequest::where('user_id', auth()->id())->findOrFail($id);
        
        // Only allow cancellation of unpaid requests
        if ($certificateRequest->payment_status === 'paid') {
            return redirect()->route('parishioner.dashboard')
                ->with('error', 'Cannot cancel a paid request. Please contact the administrator for refund requests.');
        }
        
        // Delete the unpaid request
        $certificateRequest->delete();
        
        return redirect()->route('parishioner.dashboard')
            ->with('success', 'Certificate request cancelled successfully. No payment was made.');
    }

    public function destroy($id)
    {
        $certificateRequest = \App\Models\CertificateRequest::where('user_id', auth()->id())->findOrFail($id);
        if ($certificateRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be deleted.');
        }
        $certificateRequest->delete();
        return redirect()->route('parishioner.dashboard')->with('success', 'Request deleted successfully.');
    }

    public function download($id)
    {
        $request = \App\Models\CertificateRequest::where('user_id', auth()->id())->findOrFail($id);
        if ($request->status !== 'approved') {
            abort(403, 'Certificate not available for download.');
        }
        return view('parishioner.certificate', compact('request'));
    }
} 
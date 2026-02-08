<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use Illuminate\Http\Request;
use App\Notifications\CertificateApprovedNotification;
use App\Notifications\CertificateDeclinedNotification;
use App\Notifications\CertificateReadyNotification;

class CertificateRequestController extends Controller
{
    public function index(Request $request)
    {
        // Only show paid requests (exclude abandoned unpaid checkouts)
        $query = CertificateRequest::with('user')
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc');

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('certificate_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Handle status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $requests = $query->get();
            
        // Stats only for paid requests
        $stats = [
            'total' => CertificateRequest::where('payment_status', 'paid')->count(),
            'pending' => CertificateRequest::where('payment_status', 'paid')->where('status', 'pending')->count(),
            'approved' => CertificateRequest::where('payment_status', 'paid')->where('status', 'approved')->count(),
            'declined' => CertificateRequest::where('payment_status', 'paid')->where('status', 'declined')->count(),
        ];
        
        return view('admin.certificate_requests', compact('requests', 'stats'));
    }

    public function show($id)
    {
        $request = CertificateRequest::with('user')->findOrFail($id);
        return view('admin.certificate_request_details', compact('request'));
    }

    public function approve(Request $request, $id)
    {
        $certRequest = CertificateRequest::findOrFail($id);
        
        $certRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
            'processed_by' => auth()->id(),
            'admin_remarks' => $request->input('admin_remarks'),
        ]);
        
        // Send email notification to parishioner
        if ($certRequest->user && $certRequest->user->email) {
            $certRequest->user->notify(new CertificateApprovedNotification($certRequest));
        }
        
        return redirect()->back()->with('success', 'Request approved successfully. Email notification sent to parishioner.');
    }

    public function decline(Request $request, $id)
    {
        $certRequest = CertificateRequest::findOrFail($id);
        
        $certRequest->update([
            'status' => 'declined',
            'processed_by' => auth()->id(),
            'admin_remarks' => $request->input('admin_remarks'),
        ]);
        
        // Send email notification to parishioner
        if ($certRequest->user && $certRequest->user->email) {
            $certRequest->user->notify(new CertificateDeclinedNotification($certRequest));
        }
        
        return redirect()->back()->with('success', 'Request declined. Email notification sent to parishioner.');
    }

    // Mark as processing (admin is working on it)
    public function markProcessing($id)
    {
        $certRequest = CertificateRequest::findOrFail($id);
        
        $certRequest->update([
            'status' => 'processing',
            'processed_by' => auth()->id(),
        ]);
        
        return redirect()->back()->with('success', 'Request marked as processing.');
    }

    // Upload certificate and mark as ready
    public function uploadCertificate(Request $request, $id)
    {
        $request->validate([
            'certificate_file' => 'required|file|mimes:pdf|max:5120', // 5MB max
        ]);

        $certRequest = CertificateRequest::findOrFail($id);
        
        // Store the certificate file
        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            $filename = 'certificate_' . $certRequest->id . '_' . time() . '.pdf';
            $path = $file->storeAs('certificates', $filename, 'public');
            
            $certRequest->update([
                'certificate_file_path' => $path,
                'status' => 'ready',
                'processed_by' => auth()->id(),
            ]);
            
            // Send email notification to parishioner
            if ($certRequest->user && $certRequest->user->email) {
                $certRequest->user->notify(new CertificateReadyNotification($certRequest));
            }
        }
        
        return redirect()->back()->with('success', 'Certificate uploaded successfully. Email notification sent to parishioner.');
    }

    // Mark as completed (parishioner has downloaded)
    public function markCompleted($id)
    {
        $certRequest = CertificateRequest::findOrFail($id);
        
        $certRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Request marked as completed.');
    }
} 
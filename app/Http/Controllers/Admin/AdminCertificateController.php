<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaptismalCertificate;
use App\Models\DeathCertificate;
use App\Models\ConfirmationCertificate;
use App\Models\User;
use App\Models\CertificateRequest;
use Illuminate\Http\Request;

class AdminCertificateController extends Controller
{
    public function dashboard()
    {
        // Count parishes (sub-administrators)
        $totalParishes = User::where('role', 'sub-administrator')->count();
        
        // Count only paid certificate requests (exclude abandoned unpaid requests)
        $totalRequests = CertificateRequest::where('payment_status', 'paid')->count();
        
        // Count parishioners (users with role 'parishioner')
        $totalParishioners = User::where('role', 'parishioner')->count();
        
        // Count certificates by type
        $baptismalCount = BaptismalCertificate::count();
        $deathCount = DeathCertificate::count();
        $confirmationCount = ConfirmationCertificate::count();
        $totalCertificates = $baptismalCount + $deathCount + $confirmationCount;
        
        return view('admin.dashboard', compact(
            'totalParishes',
            'totalRequests',
            'totalParishioners',
            'totalCertificates',
            'baptismalCount',
            'deathCount',
            'confirmationCount'
        ));
    }
    public function baptism(Request $request)
    {
        $query = BaptismalCertificate::with('subadmin');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('cert_id', 'LIKE', "%{$search}%")
                  ->orWhere('parish', 'LIKE', "%{$search}%")
                  ->orWhere('mothers_full_name', 'LIKE', "%{$search}%")
                  ->orWhere('fathers_full_name', 'LIKE', "%{$search}%");
            });
        }
        
        $certificates = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.certificates.baptism', compact('certificates'));
    }

    public function death(Request $request)
    {
        $query = DeathCertificate::with('subadmin');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('cert_id', 'LIKE', "%{$search}%")
                  ->orWhere('parish', 'LIKE', "%{$search}%");
            });
        }
        
        $certificates = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.certificates.death', compact('certificates'));
    }

    public function confirmation(Request $request)
    {
        $query = ConfirmationCertificate::with('subadmin');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('cert_id', 'LIKE', "%{$search}%")
                  ->orWhere('parish', 'LIKE', "%{$search}%");
            });
        }
        
        $certificates = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.certificates.confirmation', compact('certificates'));
    }

    public function downloadBaptismalCertificate($id)
    {
        $certificate = BaptismalCertificate::with('subadmin')->findOrFail($id);
        
        // Create a mock certificate request for PDF generation
        $certRequest = (object)[
            'purpose' => 'For whatever legal purpose it may serve'
        ];
        
        $pdf = \PDF::loadView('admin.certificate_generator.baptismal_pdf', [
            'certificate' => $certificate,
            'certRequest' => $certRequest
        ]);
        
        return $pdf->download('Baptismal_Certificate_' . $certificate->cert_id . '.pdf');
    }

    public function downloadConfirmationCertificate($id)
    {
        $certificate = ConfirmationCertificate::with('subadmin')->findOrFail($id);
        
        // Create a mock certificate request for PDF generation
        $certRequest = (object)[
            'purpose' => 'For whatever legal purpose it may serve'
        ];
        
        $pdf = \PDF::loadView('admin.certificate_generator.confirmation_pdf', [
            'certificate' => $certificate,
            'certRequest' => $certRequest
        ]);
        
        return $pdf->download('Confirmation_Certificate_' . $certificate->cert_id . '.pdf');
    }

    public function downloadDeathCertificate($id)
    {
        $certificate = DeathCertificate::with('subadmin')->findOrFail($id);
        
        // Create a mock certificate request for PDF generation
        $certRequest = (object)[
            'purpose' => 'For whatever legal purpose it may serve'
        ];
        
        $pdf = \PDF::loadView('admin.certificate_generator.death_pdf', [
            'certificate' => $certificate,
            'certRequest' => $certRequest
        ]);
        
        return $pdf->download('Death_Certificate_' . $certificate->cert_id . '.pdf');
    }
}

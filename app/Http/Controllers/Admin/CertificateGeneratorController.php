<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use App\Models\BaptismalCertificate;
use App\Models\ConfirmationCertificate;
use App\Models\DeathCertificate;
use App\Notifications\CertificateReadyNotification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

class CertificateGeneratorController extends Controller
{
    // Show certificate selection page
    public function selectCertificate($requestId)
    {
        $certRequest = CertificateRequest::findOrFail($requestId);
        
        // Get certificates based on type
        $certificates = [];
        
        if ($certRequest->certificate_type === 'Baptismal Certificate') {
            $searchName = $certRequest->first_name . ' ' . $certRequest->last_name;
            $certificates = BaptismalCertificate::where('full_name', 'like', '%' . $searchName . '%')
                ->orWhere('full_name', 'like', '%' . $certRequest->first_name . '%')
                ->orWhere('full_name', 'like', '%' . $certRequest->last_name . '%')
                ->get();
        } elseif ($certRequest->certificate_type === 'Confirmation Certificate') {
            $searchName = $certRequest->first_name . ' ' . $certRequest->last_name;
            $certificates = ConfirmationCertificate::where('full_name', 'like', '%' . $searchName . '%')
                ->orWhere('full_name', 'like', '%' . $certRequest->first_name . '%')
                ->orWhere('full_name', 'like', '%' . $certRequest->last_name . '%')
                ->get();
        } elseif ($certRequest->certificate_type === 'Death Certificate') {
            $searchName = $certRequest->first_name . ' ' . $certRequest->last_name;
            $certificates = DeathCertificate::where('full_name', 'like', '%' . $searchName . '%')
                ->orWhere('full_name', 'like', '%' . $certRequest->first_name . '%')
                ->orWhere('full_name', 'like', '%' . $certRequest->last_name . '%')
                ->get();
        }
        
        return view('admin.certificate_generator.select', compact('certRequest', 'certificates'));
    }
    
    // Generate PDF from selected certificate
    public function generateCertificate(Request $request, $requestId)
    {
        $certRequest = CertificateRequest::findOrFail($requestId);
        $certificateId = $request->input('certificate_id');
        
        // Get the certificate data
        $certificate = null;
        $viewName = '';
        
        if ($certRequest->certificate_type === 'Baptismal Certificate') {
            $certificate = BaptismalCertificate::findOrFail($certificateId);
            $viewName = 'admin.certificate_generator.baptismal_pdf';
        } elseif ($certRequest->certificate_type === 'Confirmation Certificate') {
            $certificate = ConfirmationCertificate::findOrFail($certificateId);
            $viewName = 'admin.certificate_generator.confirmation_pdf';
        } elseif ($certRequest->certificate_type === 'Death Certificate') {
            $certificate = DeathCertificate::findOrFail($certificateId);
            $viewName = 'admin.certificate_generator.death_pdf';
        }
        
        // Generate PDF
        $pdf = Pdf::loadView($viewName, [
            'certificate' => $certificate,
            'certRequest' => $certRequest
        ]);
        
        // Save PDF
        $filename = 'certificate_' . $certRequest->id . '_' . time() . '.pdf';
        $path = 'certificates/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        // Update certificate request
        $certRequest->update([
            'certificate_file_path' => $path,
            'status' => 'ready',
            'processed_by' => auth()->id(),
        ]);
        
        // Send email notification
        if ($certRequest->user && $certRequest->user->email) {
            $certRequest->user->notify(new CertificateReadyNotification($certRequest));
        }
        
        return redirect()->route('admin.certificate-requests.show', $requestId)
            ->with('success', 'Certificate generated successfully! Email notification sent to parishioner.');
    }
}

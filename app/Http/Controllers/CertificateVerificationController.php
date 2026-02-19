<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaptismalCertificate;
use App\Models\ConfirmationCertificate;
use App\Models\DeathCertificate;

class CertificateVerificationController extends Controller
{
    public function index()
    {
        return view('certificate-verification.index');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'certificate_id' => 'required|string|max:255'
        ]);

        $certificateId = $request->certificate_id;
        
        // Search in all certificate tables
        $baptismalCert = BaptismalCertificate::where('cert_id', $certificateId)->first();
        $confirmationCert = ConfirmationCertificate::where('cert_id', $certificateId)->first();
        $deathCert = DeathCertificate::where('cert_id', $certificateId)->first();

        $certificate = $baptismalCert ?? $confirmationCert ?? $deathCert;

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate not found. This certificate may be fake or invalid.'
            ]);
        }

        // Determine certificate type
        $certificateType = 'Unknown';
        if ($baptismalCert) {
            $certificateType = 'Baptismal Certificate';
        } elseif ($confirmationCert) {
            $certificateType = 'Confirmation Certificate';
        } elseif ($deathCert) {
            $certificateType = 'Death Certificate';
        }

        return response()->json([
            'success' => true,
            'message' => 'Certificate verified successfully! This is a legitimate certificate.',
            'certificate' => [
                'id' => $certificate->cert_id,
                'type' => $certificateType,
                'full_name' => $certificate->full_name,
                'parish' => $certificate->parish,
                'status' => $certificate->status,
                'created_at' => $certificate->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }
}

<?php

namespace App\Http\Controllers\Parishioner;

use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateDownloadController extends Controller
{
    // Show all certificate requests for the logged-in parishioner
    public function index()
    {
        $requests = CertificateRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('parishioner.certificates.index', compact('requests'));
    }

    // Download certificate
    public function download($id)
    {
        $request = CertificateRequest::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
        
        // Check if certificate is ready
        if ($request->status !== 'ready' && $request->status !== 'completed') {
            return redirect()->back()->with('error', 'Certificate is not yet ready for download.');
        }
        
        // Check if file exists
        if (!$request->certificate_file_path || !Storage::disk('public')->exists($request->certificate_file_path)) {
            return redirect()->back()->with('error', 'Certificate file not found.');
        }
        
        // Get the file
        $filePath = storage_path('app/public/' . $request->certificate_file_path);
        $fileName = 'Certificate_' . $request->certificate_type . '_' . $request->id . '.pdf';
        
        return response()->download($filePath, $fileName);
    }

    // View certificate details
    public function show($id)
    {
        $request = CertificateRequest::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
        
        return view('parishioner.certificates.show', compact('request'));
    }
}

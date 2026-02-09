<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Certificate;
use App\Models\DeathCertificate;
use App\Models\BaptismalCertificate;
use App\Models\ConfirmationCertificate;
use App\Models\Minister;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function dashboard()
    {
        // Get certificate counts for the authenticated subadmin
        $baptismalCount = BaptismalCertificate::where('subadmin_id', auth()->id())->count();
        $deathCount = DeathCertificate::where('subadmin_id', auth()->id())->count();
        $confirmationCount = ConfirmationCertificate::where('subadmin_id', auth()->id())->count();

        return view('subadmin.dashboard', compact('baptismalCount', 'deathCount', 'confirmationCount'));
    }

    public function add(Request $request, $type)
    {
        $view = match($type) {
            'baptismal' => 'subadmin.add_baptismal',
            'death' => 'subadmin.add_death',
            'confirmation' => 'subadmin.add_confirmation',
            default => abort(404),
        };
        
        // Get certificates based on type using separate models with pagination and search
        $search = $request->get('search');
        
        $certificates = match($type) {
            'death' => DeathCertificate::where('subadmin_id', auth()->id())
                ->when($search, function($query, $search) {
                    return $query->where(function($q) use ($search) {
                        $q->where('full_name', 'LIKE', "%{$search}%")
                          ->orWhere('cert_id', 'LIKE', "%{$search}%")
                          ->orWhere('parish', 'LIKE', "%{$search}%")
                          ->orWhere('fathers_full_name', 'LIKE', "%{$search}%")
                          ->orWhere('mothers_full_name', 'LIKE', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(10)
                ->appends(request()->query()),
            'baptismal' => BaptismalCertificate::where('subadmin_id', auth()->id())
                ->when($search, function($query, $search) {
                    return $query->where(function($q) use ($search) {
                        $q->where('full_name', 'LIKE', "%{$search}%")
                          ->orWhere('cert_id', 'LIKE', "%{$search}%")
                          ->orWhere('parish', 'LIKE', "%{$search}%")
                          ->orWhere('mothers_full_name', 'LIKE', "%{$search}%")
                          ->orWhere('fathers_full_name', 'LIKE', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(10)
                ->appends(request()->query()),
            'confirmation' => ConfirmationCertificate::where('subadmin_id', auth()->id())
                ->when($search, function($query, $search) {
                    return $query->where(function($q) use ($search) {
                        $q->where('full_name', 'LIKE', "%{$search}%")
                          ->orWhere('cert_id', 'LIKE', "%{$search}%")
                          ->orWhere('parish', 'LIKE', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(10)
                ->appends(request()->query()),
            default => Certificate::where('certificate_type', $type)
                ->where('subadmin_id', auth()->id())
                ->when($search, function($query, $search) {
                    return $query->where(function($q) use ($search) {
                        $q->where('full_name', 'LIKE', "%{$search}%")
                          ->orWhere('cert_id', 'LIKE', "%{$search}%")
                          ->orWhere('parish', 'LIKE', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(10)
                ->appends(request()->query()),
        };
        
        // Get active ministers for dropdown
        $ministers = Minister::active()->orderBy('name')->get();
        
        return view($view, compact('certificates', 'ministers'));
    }

    public function store(Request $request, $type)
    {
        // Define validation rules based on certificate type
        $rules = match($type) {
            'death' => [
                'full_name' => 'required|string|max:255',
                'date_of_death' => 'required|date',
                'place_of_cemetery' => 'required|string|max:255',
                'fathers_full_name' => 'nullable|string|max:255',
                'mothers_full_name' => 'nullable|string|max:255',
                'residents_address' => 'nullable|string|max:255',
                'remarks' => 'nullable|string',
                'parish' => 'nullable|string|max:255',
                'parish_address' => 'nullable|string',
                'priest_name' => 'nullable|string|max:255',
            ],
            'baptismal' => [
                'full_name' => 'required|string',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string',
                'mothers_full_name' => 'required|string',
                'fathers_full_name' => 'required|string',
                'date_of_baptism' => 'required|date',
                'officiant' => 'nullable|string',
                'sponsor1' => 'nullable|string',
                'sponsor2' => 'nullable|string',
                'parish' => 'nullable|string',
                'parish_address' => 'nullable|string',
            ],
            'confirmation' => [
                'full_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:255',
                'fathers_full_name' => 'required|string|max:255',
                'mothers_full_name' => 'required|string|max:255',
                'date_of_baptism' => 'required|date',
                'place_of_baptism' => 'required|string|max:255',
                'date_of_confirmation' => 'required|date',
                'place_of_confirmation' => 'required|string|max:255',
                'sponsor1' => 'nullable|string|max:255',
                'sponsor2' => 'nullable|string|max:255',
                'remarks' => 'nullable|string',
                'officiant' => 'nullable|string|max:255',
                'parish' => 'nullable|string|max:255',
                'parish_address' => 'nullable|string',
            ],
            default => [
                'full_name' => 'required|string',
                'parish' => 'required|string',
            ]
        };

        $validated = $request->validate($rules);

        // Use appropriate model based on certificate type
        $certificate = match($type) {
            'death' => new DeathCertificate(),
            'baptismal' => new BaptismalCertificate(),
            'confirmation' => new ConfirmationCertificate(),
            default => new Certificate(),
        };

        // Generate a unique certificate ID based on type
        $modelClass = get_class($certificate);
        $certId = strtoupper(substr($type, 0, 1)) . 'C' . date('Y') . str_pad($modelClass::count() + 1, 4, '0', STR_PAD_LEFT);

        $certificate->cert_id = $certId;
        if ($certificate instanceof Certificate) {
            $certificate->certificate_type = $type;
        }
        $certificate->subadmin_id = auth()->id();
        
        // Auto-populate parish information from authenticated user for all certificate types
        if (in_array($type, ['baptismal', 'death', 'confirmation'])) {
            $validated['parish'] = auth()->user()->parish_name;
            $validated['parish_address'] = auth()->user()->parish_address;
        }
        
        $certificate->fill($validated);
        $certificate->save();

        return redirect()->back()->with('success', ucfirst($type) . ' certificate added successfully!');
    }

    public function update(Request $request, $id)
    {
        $certificate = BaptismalCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();

        $rules = [
            'full_name' => 'required|string',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string',
            'mothers_full_name' => 'required|string',
            'fathers_full_name' => 'required|string',
            'date_of_baptism' => 'required|date',
            'officiant' => 'nullable|string',
            'sponsor1' => 'nullable|string',
            'sponsor2' => 'nullable|string',
            'parish' => 'nullable|string',
            'parish_address' => 'nullable|string',
        ];

        $validated = $request->validate($rules);
        
        // Auto-populate parish information from authenticated user
        $validated['parish'] = auth()->user()->parish_name;
        $validated['parish_address'] = auth()->user()->parish_address;
        
        $certificate->update($validated);

        return redirect()->back()->with('success', 'Baptismal certificate updated successfully!');
    }

    public function delete($id)
    {
        $certificate = BaptismalCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();

        $certificate->delete();

        return redirect()->back()->with('success', 'Baptismal certificate deleted successfully!');
    }

    public function updateDeath(Request $request, $id)
    {
        $certificate = DeathCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();

        $rules = [
            'full_name' => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'place_of_cemetery' => 'required|string|max:255',
            'fathers_full_name' => 'nullable|string|max:255',
            'mothers_full_name' => 'nullable|string|max:255',
            'residents_address' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'parish' => 'nullable|string|max:255',
            'parish_address' => 'nullable|string',
            'priest_name' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);
        
        // Auto-populate parish information from authenticated user
        $validated['parish'] = auth()->user()->parish_name;
        $validated['parish_address'] = auth()->user()->parish_address;
        
        $certificate->update($validated);

        return redirect()->back()->with('success', 'Death certificate updated successfully!');
    }

    public function deleteDeath($id)
    {
        $certificate = DeathCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();

        $certificate->delete();

        return redirect()->back()->with('success', 'Death certificate deleted successfully!');
    }

    public function updateConfirmation(Request $request, $id)
    {
        $certificate = ConfirmationCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();

        $rules = [
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'fathers_full_name' => 'required|string|max:255',
            'mothers_full_name' => 'required|string|max:255',
            'date_of_baptism' => 'required|date',
            'place_of_baptism' => 'required|string|max:255',
            'date_of_confirmation' => 'required|date',
            'place_of_confirmation' => 'required|string|max:255',
            'sponsor1' => 'nullable|string|max:255',
            'sponsor2' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'officiant' => 'nullable|string|max:255',
            'parish' => 'nullable|string|max:255',
            'parish_address' => 'nullable|string',
        ];

        $validated = $request->validate($rules);
        
        // Auto-populate parish information from authenticated user
        $validated['parish'] = auth()->user()->parish_name;
        $validated['parish_address'] = auth()->user()->parish_address;
        
        $certificate->update($validated);

        return redirect()->back()->with('success', 'Confirmation certificate updated successfully!');
    }

    public function deleteConfirmation($id)
    {
        $certificate = ConfirmationCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();

        $certificate->delete();

        return redirect()->back()->with('success', 'Confirmation certificate deleted successfully!');
    }

    public function list()
    {
        $certificates = Certificate::where('subadmin_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('subadmin.certificates_list', compact('certificates'));
    }

    public function downloadBaptismalCertificate(Request $request, $id)
    {
        $certificate = BaptismalCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();
        
        // Create certificate request object with custom purpose
        $certRequest = (object)[
            'purpose' => $request->input('purpose', 'For whatever legal purpose it may serve')
        ];
        
        $pdf = \PDF::loadView('admin.certificate_generator.baptismal_pdf', [
            'certificate' => $certificate,
            'certRequest' => $certRequest
        ]);
        
        return $pdf->download('Baptismal_Certificate_' . $certificate->cert_id . '.pdf');
    }

    public function downloadConfirmationCertificate(Request $request, $id)
    {
        $certificate = ConfirmationCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();
        
        // Create certificate request object with custom purpose
        $certRequest = (object)[
            'purpose' => $request->input('purpose', 'For whatever legal purpose it may serve')
        ];
        
        $pdf = \PDF::loadView('admin.certificate_generator.confirmation_pdf', [
            'certificate' => $certificate,
            'certRequest' => $certRequest
        ]);
        
        return $pdf->download('Confirmation_Certificate_' . $certificate->cert_id . '.pdf');
    }

    public function downloadDeathCertificate(Request $request, $id)
    {
        $certificate = DeathCertificate::where('id', $id)
            ->where('subadmin_id', auth()->id())
            ->firstOrFail();
        
        // Create certificate request object with custom purpose
        $certRequest = (object)[
            'purpose' => $request->input('purpose', 'For whatever legal purpose it may serve')
        ];
        
        $pdf = \PDF::loadView('admin.certificate_generator.death_pdf', [
            'certificate' => $certificate,
            'certRequest' => $certRequest
        ]);
        
        return $pdf->download('Death_Certificate_' . $certificate->cert_id . '.pdf');
    }
} 
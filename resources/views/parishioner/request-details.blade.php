@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }
    .details-main-container { max-width: 1100px; margin: 2.5rem auto; background: #f8fafc; padding: 2rem 0; }
    .details-header-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 2rem 2.5rem 1.5rem 2.5rem; margin-bottom: 2rem; display: flex; flex-direction: column; }
    .details-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.7rem; }
    .details-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.2rem; }
    .details-id { color: #6b7280; font-size: 1rem; margin-bottom: 0.7rem; }
    .details-status-badge { display: flex; align-items: center; gap: 0.5rem; background: #fef3c7; color: #f59e0b; border-radius: 9999px; padding: 0.4rem 1.1rem; font-size: 1rem; font-weight: 500; }
    .details-status-badge.approved { background: #d1fae5; color: #10b981; }
    .details-status-badge.declined { background: #fee2e2; color: #ef4444; }
    .details-meta-row { display: flex; gap: 2rem; color: #6b7280; font-size: 1rem; margin-bottom: 0.7rem; }
    .details-progress-bar { width: 100%; height: 6px; background: #e5e7eb; border-radius: 3px; margin-top: 1rem; }
    .details-progress-fill { height: 100%; border-radius: 3px; background: #6366f1; width: 40%; transition: width 0.3s; }
    .details-content-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem; }
    .details-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 2rem; margin-bottom: 2rem; }
    .details-section-title { font-size: 1.1rem; font-weight: 600; color: #1e3a8a; margin-bottom: 1.2rem; }
    .details-info-row { display: flex; align-items: center; gap: 0.7rem; margin-bottom: 0.7rem; color: #374151; }
    .details-info-label { min-width: 120px; color: #6b7280; font-size: 0.97rem; }
    .details-info-value { font-weight: 500; }
    .details-timeline { margin-bottom: 2rem; }
    .timeline-step { display: flex; align-items: flex-start; gap: 0.7rem; margin-bottom: 1.2rem; }
    .timeline-dot { width: 14px; height: 14px; border-radius: 50%; background: #6366f1; margin-top: 2px; }
    .timeline-dot.inactive { background: #e5e7eb; }
    .timeline-content { font-size: 0.97rem; color: #374151; }
    .timeline-date { color: #6b7280; font-size: 0.93rem; margin-top: 0.1rem; }
    .details-docs-list { margin-bottom: 1.2rem; }
    .details-doc-row { display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border-radius: 6px; padding: 0.7rem 1rem; margin-bottom: 0.7rem; }
    .details-doc-name { display: flex; align-items: center; gap: 0.7rem; color: #374151; }
    .details-doc-size { color: #6b7280; font-size: 0.93rem; margin-left: 0.5rem; }
    .details-doc-download { color: #1e3a8a; font-size: 1.1rem; cursor: pointer; }
    .details-upload-btn { display: block; width: 100%; background: #e0e7ff; color: #1e3a8a; border: none; border-radius: 6px; padding: 0.7rem 0; font-size: 1rem; font-weight: 500; cursor: pointer; margin-top: 0.7rem; }
    .details-actions { display: flex; gap: 1rem; margin-top: 2rem; }
    .details-cancel-btn, .details-edit-btn, .details-download-btn { border: none; border-radius: 6px; padding: 0.6rem 1.5rem; font-size: 1rem; font-weight: 500; cursor: pointer; transition: background 0.2s, color 0.2s; }
    .details-cancel-btn { background: #f3f4f6; color: #222; }
    .details-cancel-btn:hover { background: #fee2e2; color: #ef4444; }
    .details-edit-btn { background: #1e3a8a; color: #fff; }
    .details-edit-btn:hover { background: #1e40af; }
    .details-download-btn { background: #10b981; color: #fff; }
    .details-download-btn:hover { background: #059669; }
</style>
<style>
@media print {
    body * {
        visibility: hidden !important;
    }
    #certificate-section, #certificate-section * {
        visibility: visible !important;
    }
    #certificate-section {
        position: absolute;
        left: 0;
        top: 0;
        width: 100vw;
        background: white;
        box-shadow: none;
        margin: 0;
        padding: 0;
    }
    .action-btns, .back-link {
        display: none !important;
    }
}
</style>
<script>
function printCertificateSection() {
    window.print();
}
</script>
<script src="https://cdn.tailwindcss.com"></script>

<div class="details-main-container">
    <a href="{{ route('parishioner.dashboard') }}" style="color:#1e3a8a;font-weight:500;font-size:1rem;margin-left:2.5rem;display:inline-block;margin-bottom:1rem;"><i class="fas fa-arrow-left"></i> Back to Requests</a>
    <div class="details-header-card">
        <div class="details-header-row">
            <div>
                <div class="details-title">{{ $request->certificate_type }}</div>
                <div class="details-id">Request ID: REQ-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="details-status-badge {{ $request->status }}">
                <i class="fas fa-exclamation-triangle"></i> {{ $request->status }}
            </div>
        </div>
        <div class="details-meta-row">
            <div><i class="far fa-calendar-alt"></i> Submitted: {{ $request->created_at->format('M d, Y') }}</div>
            <div><i class="far fa-clock"></i> Last updated: {{ $request->updated_at->diffForHumans() }}</div>
        </div>
        <div class="details-progress-bar"><div class="details-progress-fill"></div></div>
    </div>
    <div class="details-content-grid">
        <div>
            @if(request('edit') && $request->status == 'pending')
            <form method="POST" action="{{ route('parishioner.certificate-request.update', $request->id) }}" enctype="multipart/form-data" class="details-card">
                @csrf
                <div class="details-section-title">Edit Request</div>
                <div class="details-info-row"><span class="details-info-label">Certificate Type</span>
                    <select name="certificate_type" required>
                        <option value="Baptismal Certificate" @if($request->certificate_type=='Baptismal Certificate') selected @endif>Baptismal Certificate</option>
                        <option value="Marriage Certificate" @if($request->certificate_type=='Marriage Certificate') selected @endif>Marriage Certificate</option>
                        <option value="Death Certificate" @if($request->certificate_type=='Death Certificate') selected @endif>Death Certificate</option>
                        <option value="Confirmation Certificate" @if($request->certificate_type=='Confirmation Certificate') selected @endif>Confirmation Certificate</option>
                    </select>
                </div>
                <div class="details-info-row"><span class="details-info-label">First Name</span><input type="text" name="first_name" value="{{ $request->first_name }}" required></div>
                <div class="details-info-row"><span class="details-info-label">Last Name</span><input type="text" name="last_name" value="{{ $request->last_name }}" required></div>
                <div class="details-info-row"><span class="details-info-label">Contact Number</span><input type="text" name="contact_number" value="{{ $request->contact_number }}" required></div>
                <div class="details-info-row"><span class="details-info-label">Email</span><input type="email" name="email" value="{{ $request->email }}" required></div>
                <div class="details-info-row"><span class="details-info-label">Current Address</span><input type="text" name="current_address" value="{{ $request->current_address }}" required></div>
                <div class="details-info-row"><span class="details-info-label">Date of Birth</span><input type="date" name="date_of_birth" value="{{ $request->date_of_birth }}" required></div>
                <div class="details-info-row"><span class="details-info-label">Purpose</span><input type="text" name="purpose" value="{{ $request->purpose }}" required></div>
                <div class="details-info-row"><span class="details-info-label">Owner First Name</span><input type="text" name="owner_first_name" value="{{ $request->owner_first_name }}"></div>
                <div class="details-info-row"><span class="details-info-label">Owner Last Name</span><input type="text" name="owner_last_name" value="{{ $request->owner_last_name }}"></div>
                <div class="details-info-row"><span class="details-info-label">Owner Date of Birth</span><input type="date" name="owner_date_of_birth" value="{{ $request->owner_date_of_birth }}"></div>
                <div class="details-info-row"><span class="details-info-label">Relationship</span><input type="text" name="relationship" value="{{ $request->relationship }}"></div>
                <div class="details-info-row"><span class="details-info-label">Additional Notes</span><input type="text" name="third_party_reason" value="{{ $request->third_party_reason }}"></div>
                <div class="details-info-row"><span class="details-info-label">ID Photo</span><input type="file" name="id_photo_path"></div>
                <div class="action-btns">
                    <button class="save-btn" type="submit">Save Changes</button>
                    <a href="{{ route('parishioner.certificate-request.show', $request->id) }}" class="cancel-btn">Cancel</a>
                </div>
            </form>
            @else
            <div class="details-card">
                <div class="details-section-title">Applicant Information</div>
                <div class="details-info-row"><span class="details-info-label"><i class="fas fa-user"></i> Full Name</span><span class="details-info-value">{{ $request->first_name }} {{ $request->last_name }}</span></div>
                <div class="details-info-row"><span class="details-info-label"><i class="fas fa-envelope"></i> Email Address</span><span class="details-info-value">{{ $request->email }}</span></div>
                <div class="details-info-row"><span class="details-info-label"><i class="fas fa-phone"></i> Phone Number</span><span class="details-info-value">{{ $request->contact_number }}</span></div>
                <div class="details-info-row"><span class="details-info-label"><i class="fas fa-map-marker-alt"></i> Address</span><span class="details-info-value">{{ $request->current_address }}</span></div>
                <div class="details-info-row"><span class="details-info-label"><i class="fas fa-birthday-cake"></i> Date of Birth</span><span class="details-info-value">{{ $request->date_of_birth }}</span></div>
            </div>
            <div class="details-card">
                <div class="details-section-title">Certificate Owner's Information</div>
                <div class="details-info-row"><span class="details-info-label">Full Name</span><span class="details-info-value">{{ $request->owner_first_name }} {{ $request->owner_last_name }}</span></div>
                <div class="details-info-row"><span class="details-info-label">Date of Birth</span><span class="details-info-value">{{ $request->owner_date_of_birth }}</span></div>
                <div class="details-info-row"><span class="details-info-label">Relationship to Requestor</span><span class="details-info-value">{{ $request->relationship }}</span></div>
            </div>
            <div class="details-card">
                <div class="details-section-title">Request Details</div>
                <div class="details-info-row"><span class="details-info-label">Purpose of Request</span><span class="details-info-value">{{ $request->purpose }}</span></div>
                <div class="details-info-row"><span class="details-info-label">Additional Notes</span><span class="details-info-value">{{ $request->third_party_reason }}</span></div>
            </div>
            @endif
        </div>
        <div>
            <div class="details-card details-timeline">
                <div class="details-section-title">Processing Timeline</div>
                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">Request Submitted<div class="timeline-date">{{ $request->created_at->format('M d, Y') }}</div></div>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot {{ $request->status == 'approved' ? '' : 'inactive' }}"></div>
                    <div class="timeline-content">Processing<div class="timeline-date">Estimated: 3-5 business days</div></div>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot {{ $request->status == 'approved' ? '' : 'inactive' }}"></div>
                    <div class="timeline-content">Completion<div class="timeline-date">{{ ucfirst($request->status) }}</div></div>
                </div>
            </div>
            <div class="details-card">
                <div class="details-section-title">Supporting Documents</div>
                <div class="details-docs-list">
                    @if($request->id_photo_path)
                    <div class="details-doc-row">
                        <div class="details-doc-name"><i class="fas fa-file-alt"></i> ID Photo</div>
                        <div class="details-doc-size">2 MB</div>
                        <a href="#" class="details-doc-download"><i class="fas fa-download"></i></a>
                    </div>
                    @endif
                    <!-- Add more docs as needed -->
                </div>
                <button class="details-upload-btn">Upload Additional Documents</button>
            </div>
        </div>
    </div>
    <div class="details-actions">
        @if($request->status == 'pending')
        <form method="POST" action="{{ route('parishioner.certificate-request.destroy', $request->id) }}" onsubmit="return confirm('Are you sure you want to cancel/delete this request?');">
            @csrf
            @method('DELETE')
            <button class="details-cancel-btn" type="submit">Cancel Request</button>
        </form>
        <a href="{{ route('parishioner.certificate-request.show', $request->id) }}?edit=1" class="details-edit-btn">Edit</a>
        <button class="details-download-btn" disabled>Download Certificate</button>
        @elseif($request->status == 'approved')
        <a href="{{ route('parishioner.certificate-request.download', $request->id) }}" class="details-download-btn">Download Certificate</a>
        @endif
    </div>
</div>
<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection 
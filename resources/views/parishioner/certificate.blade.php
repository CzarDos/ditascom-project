@extends('layouts.app')

@section('content')
<style>
    .certificate-container {
        max-width: 900px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        padding: 2.5rem 3rem;
        font-family: 'Times New Roman', Times, serif;
        position: relative;
    }
    .certificate-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #1a237e;
        text-align: center;
        margin-bottom: 1.5rem;
        font-family: 'Inter', serif;
    }
    .certificate-header {
        text-align: center;
        margin-bottom: 1.2rem;
    }
    .certificate-header img {
        height: 60px;
        margin-bottom: 0.5rem;
    }
    .certificate-body {
        font-size: 1.15rem;
        color: #222;
        margin-top: 1.5rem;
        margin-bottom: 2rem;
    }
    .certificate-label {
        font-weight: 600;
        color: #1a237e;
    }
    .certificate-footer {
        margin-top: 2.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .certificate-verse {
        font-style: italic;
        color: #444;
        text-align: right;
        font-size: 1rem;
        margin-top: 2rem;
    }
    .certificate-seal {
        position: absolute;
        bottom: 2rem;
        right: 2rem;
        width: 80px;
        opacity: 0.7;
    }
    @media print {
        .download-btn, .back-link, nav.navbar { display: none !important; }
        .certificate-container { box-shadow: none; border: none; }
        body { background: #fff !important; }
    }
</style>
<div class="certificate-container">
    <div class="certificate-header">
        <img src="{{ asset('images/ditascom-logo.png') }}" alt="Parish Logo">
        <div style="font-size:1.1rem; color:#1a237e; font-weight:600;">The Roman Catholic Diocese of Tagum<br>SANTO NIÑO PARISH<br>Panabo City, Davao del Norte, Philippines, 8105</div>
    </div>
    <div class="certificate-title">Certificate of Baptism</div>
    <div class="certificate-body">
        According to the rites of the Roman Catholic Church<br><br>
        <span class="certificate-label">Name:</span> {{ $request->owner_first_name }} {{ $request->owner_last_name }}<br>
        <span class="certificate-label">Born on:</span> {{ \Carbon\Carbon::parse($request->owner_date_of_birth)->format('F d, Y') }}<br>
        <span class="certificate-label">at</span> {{ $request->place_of_birth ?? '________________' }}<br>
        <span class="certificate-label">Child of:</span> {{ $request->father_name ?? '________________' }} and {{ $request->mother_name ?? '________________' }}<br><br>
        was SOLEMNLY BAPTIZED by<br>
        <span class="certificate-label">Fr. ____________________</span><br>
        at <span class="certificate-label">Sto. Niño Parish Panabo City</span><br>
        the sponsors being <span class="certificate-label">__________________</span><br>
        on <span class="certificate-label">__________________</span><br><br>
        as it appears in the Parish Baptismal Registry<br>
        <span class="certificate-label">Book</span> ______ <span class="certificate-label">Page</span> ______ <span class="certificate-label">Line</span> ______<br><br>
        Legitimacy: <span class="certificate-label">Legitimate</span><br>
        Date of Issue: <span class="certificate-label">{{ now()->format('l, F d, Y') }}</span><br>
        Purpose of Certificate: <span class="certificate-label">{{ $request->purpose }}</span><br>
    </div>
    <div class="certificate-verse">
        "God has saved us by living water which gives our lives a fresh beginning, and he put his Spirit in us, so that healed by his grace, we may share his life and hope to live for ever"<br>
        <span style="font-size:0.95rem;">Titus 3: 5, 7</span>
    </div>
    <img src="{{ asset('images/seal.png') }}" alt="Parish Seal" class="certificate-seal">
    <div style="text-align:center; margin-top:2rem;">
        <a href="#" onclick="window.print();return false;" class="download-btn" style="background:#10b981;color:#fff;padding:0.7rem 2rem;border-radius:6px;text-decoration:none;font-weight:600;font-size:1.1rem;">Print / Save as PDF</a>
        <a href="{{ route('parishioner.certificate-request.show', $request->id) }}" class="back-link" style="margin-left:1.5rem;color:#1a237e;font-weight:500;">Back to Details</a>
    </div>
</div>
@endsection 
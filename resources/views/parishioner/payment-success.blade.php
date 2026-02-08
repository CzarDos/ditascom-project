@extends('layouts.app')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    .success-container { max-width: 600px; margin: 3rem auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 2.5rem 2.5rem 2rem 2.5rem; text-align: center; }
    .success-icon { font-size: 3rem; color: #10b981; margin-bottom: 1rem; }
    .success-title { font-size: 1.5rem; font-weight: 700; color: #1e3a8a; margin-bottom: 0.5rem; }
    .success-msg { color: #374151; font-size: 1.1rem; margin-bottom: 2rem; }
    .summary-box { background: #f8fafc; border-radius: 10px; padding: 1.2rem 1rem; margin-bottom: 2rem; text-align: left; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 0.7rem; }
    .summary-label { color: #6b7280; font-size: 0.97rem; }
    .summary-value { font-weight: 500; }
    .dashboard-btn { background: #1e3a8a; color: #fff; border: none; border-radius: 6px; padding: 0.7rem 2rem; font-size: 1rem; font-weight: 500; cursor: pointer; transition: background 0.2s; }
    .dashboard-btn:hover { background: #1e40af; }
</style>
<div class="success-container">
    <div class="success-icon"><i class="fas fa-check-circle"></i></div>
    <div class="success-title">Payment Successful!</div>
    <div class="success-msg">Thank you for your payment. Your certificate request has been received and is now being processed.</div>
    <div class="summary-box">
        <div class="summary-row"><div class="summary-label">Reference Number</div><div class="summary-value">REQ-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</div></div>
        <div class="summary-row"><div class="summary-label">Certificate Type</div><div class="summary-value">{{ $request->certificate_type }}</div></div>
        <div class="summary-row"><div class="summary-label">Applicant Name</div><div class="summary-value">{{ $request->user->name ?? 'N/A' }}</div></div>
        <div class="summary-row"><div class="summary-label">Status</div><div class="summary-value">{{ ucfirst($request->status) }}</div></div>
    </div>
    <a href="/parishioner/dashboard"><button class="dashboard-btn">Go to Dashboard</button></a>
</div>
@endsection 
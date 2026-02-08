@extends('layouts.app')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    .payment-container { max-width: 900px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 2.5rem 2.5rem 2rem 2.5rem; }
    .section-title { font-size: 1.3rem; font-weight: 600; margin-bottom: 1.5rem; }
    .summary-box, .order-summary { background: #f8fafc; border-radius: 10px; padding: 1.2rem 1rem; margin-bottom: 2rem; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 0.7rem; }
    .summary-label { color: #6b7280; font-size: 0.97rem; }
    .summary-value { font-weight: 500; }
    .payment-methods { display: flex; gap: 1.5rem; margin-bottom: 2rem; }
    .method-card { flex: 1; background: #f8fafc; border-radius: 10px; padding: 1.2rem 1rem; text-align: center; border: 2px solid #e5e7eb; cursor: pointer; transition: border 0.2s, background 0.2s; }
    .method-card.selected, .method-card:hover { border: 2px solid #1e3a8a; background: #e0e7ff; }
    .method-card i { font-size: 2rem; margin-bottom: 0.5rem; color: #1e3a8a; }
    .method-title { font-weight: 600; margin-bottom: 0.2rem; }
    .method-desc { color: #6b7280; font-size: 0.95rem; }
    .card-details { margin-bottom: 2rem; }
    .form-row { display: flex; gap: 1.5rem; margin-bottom: 1.2rem; }
    .form-group { flex: 1; display: flex; flex-direction: column; }
    .form-group label { font-size: 0.97rem; color: #374151; margin-bottom: 0.3rem; }
    .form-group input { padding: 0.7rem 0.9rem; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; background: #fff; }
    .order-summary { margin-bottom: 2rem; }
    .order-row { display: flex; justify-content: space-between; margin-bottom: 0.7rem; }
    .order-label { color: #6b7280; font-size: 0.97rem; }
    .order-value { font-weight: 500; }
    .action-btns { display: flex; justify-content: space-between; gap: 1rem; margin-top: 1.5rem; }
    .back-btn, .pay-btn, .cancel-btn { border: none; border-radius: 6px; padding: 0.6rem 1.5rem; font-size: 1rem; font-weight: 500; cursor: pointer; transition: background 0.2s, color 0.2s; }
    .back-btn { background: #f3f4f6; color: #222; }
    .back-btn:hover { background: #e5e7eb; }
    .cancel-btn { background: #dc2626; color: #fff; }
    .cancel-btn:hover { background: #b91c1c; }
    .pay-btn { background: #1e3a8a; color: #fff; }
    .pay-btn:hover { background: #1e40af; }
    .right-btns { display: flex; gap: 1rem; }
    .animated-check-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .animated-check {
        display: block;
    }
    .animated-check .check-circle {
        stroke-dasharray: 201;
        stroke-dashoffset: 201;
        animation: draw-circle 0.7s ease-out forwards;
    }
    .animated-check .check-mark {
        stroke-dasharray: 40;
        stroke-dashoffset: 40;
        animation: draw-check 0.5s 0.7s ease-out forwards;
    }
    @keyframes draw-circle {
        to { stroke-dashoffset: 0; }
    }
    @keyframes draw-check {
        to { stroke-dashoffset: 0; }
    }
</style>
<div class="payment-container">
    <div class="section-title">Payment Details</div>
    <div class="summary-box">
        <div class="summary-row"><div class="summary-label">Reference Number</div><div class="summary-value">REQ-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</div></div>
        <div class="summary-row"><div class="summary-label">Certificate Type</div><div class="summary-value">{{ ucfirst($request->certificate_type) }}</div></div>
        <div class="summary-row"><div class="summary-label">Applicant Name</div><div class="summary-value">{{ $request->user->name ?? 'N/A' }}</div></div>
        <div class="summary-row" style="border-top: 2px solid #e5e7eb; margin-top: 0.5rem; padding-top: 0.7rem;">
            <div class="summary-label" style="font-weight: 600; color: #1e3a8a;">Total Amount</div>
            <div class="summary-value" style="font-size: 1.3rem; font-weight: 700; color: #1e3a8a;">₱{{ number_format($request->payment_amount, 2) }}</div>
        </div>
    </div>
    <div class="section-title" style="font-size:1.1rem; margin-bottom:1rem;">Payment Information</div>
    <div style="background: #f0f9ff; border-left: 4px solid #1e3a8a; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <i class="fas fa-info-circle" style="color: #1e3a8a;"></i>
            <div style="font-weight: 600; color: #1e3a8a;">Secure Payment via PayMongo</div>
        </div>
        <div style="color: #374151; font-size: 0.95rem; line-height: 1.5;">
            You will be redirected to PayMongo's secure payment page where you can pay using:
            <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                <li>Credit/Debit Card (Visa, Mastercard)</li>
                <li>GCash</li>
                <li>PayMaya</li>
                <li>GrabPay</li>
            </ul>
        </div>
    </div>
    <form id="pay-form" method="POST" action="{{ route('parishioner.certificate-request.pay', ['id' => $request->id]) }}">
        @csrf
        <div class="action-btns">
            <button class="cancel-btn" type="button" id="cancel-btn">
                <i class="fas fa-times" style="margin-right: 0.5rem;"></i>
                Cancel Request
            </button>
            <div class="right-btns">
                <button class="back-btn" type="button" onclick="window.history.back();return false;">Back</button>
                <button class="pay-btn" type="submit" id="pay-btn">
                    <i class="fas fa-lock" style="margin-right: 0.5rem;"></i>
                    Proceed to Secure Payment
                </button>
            </div>
        </div>
    </form>

    <!-- Cancel Request Form (Hidden) -->
    <form id="cancel-form" method="POST" action="{{ route('parishioner.certificate-request.cancel', ['id' => $request->id]) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
<script>
    // Cancel Request Handler
    document.getElementById('cancel-btn').addEventListener('click', function() {
        if (confirm('Are you sure you want to cancel this certificate request?\n\nNote: Since you haven\'t paid yet, you can create a new request anytime.')) {
            document.getElementById('cancel-form').submit();
        }
    });

    document.getElementById('pay-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var url = form.action;
        var payBtn = document.getElementById('pay-btn');
        var originalBtnText = payBtn.innerHTML;
        
        // Disable button and show loading state
        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 0.5rem;"></i>Processing...';
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            if(res.success && res.checkout_url) {
                // Redirect to PayMongo checkout page
                window.location.href = res.checkout_url;
            } else {
                // Show error message
                alert(res.message || 'Failed to create payment session. Please try again.');
                payBtn.disabled = false;
                payBtn.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            payBtn.disabled = false;
            payBtn.innerHTML = originalBtnText;
        });
    });

    // Initialize Payment Tour
    document.addEventListener('DOMContentLoaded', function() {
        const onboardingTour = new OnboardingTour();
        
        // Auto-start payment tour for new users
        if (!onboardingTour.isTourCompleted()) {
            setTimeout(() => {
                onboardingTour.initPaymentTour();
            }, 500);
        }

        // Help Tour Button Click Handler
        document.getElementById('helpTourBtn').addEventListener('click', function() {
            const tour = new OnboardingTour();
            tour.initPaymentTour();
        });
    });
</script>

<!-- Help Tour Button -->
<button class="help-tour-btn" id="helpTourBtn" title="Start Help Tour">
    <i class="fas fa-question"></i>
</button>

<!-- Shepherd.js Library -->
<script src="https://cdn.jsdelivr.net/npm/shepherd.js@11.2.0/dist/js/shepherd.min.js"></script>
<script src="{{ asset('js/onboarding-tour.js') }}"></script>

@endsection
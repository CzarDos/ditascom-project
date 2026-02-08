// Onboarding Tour for DITASCOM Parishioner Portal
// Uses Shepherd.js for guided tours

class OnboardingTour {
    constructor() {
        this.tour = null;
        this.tourCompleted = localStorage.getItem('ditascom_tour_completed') === 'true';
    }

    // Dashboard Tour
    initDashboardTour(autoStart = false) {
        this.tour = new Shepherd.Tour({
            useModalOverlay: true,
            defaultStepOptions: {
                classes: 'shepherd-theme-custom',
                scrollTo: { behavior: 'smooth', block: 'center' },
                cancelIcon: {
                    enabled: true
                }
            }
        });

        this.tour.addStep({
            id: 'welcome',
            title: '👋 Welcome to DITASCOM!',
            text: `
                <div style="line-height: 1.6;">
                    <p>Welcome to the Ditascom Certificate Management System!</p>
                    <p>This quick tour will guide you through requesting and managing your church certificates.</p>
                    <p style="margin-top: 12px; font-size: 14px; color: #666;">
                        <strong>Tip:</strong> You can restart this tour anytime by clicking the "Help Tour" button.
                    </p>
                </div>
            `,
            buttons: [
                {
                    text: 'Skip Tour',
                    action: this.tour.cancel,
                    secondary: true
                },
                {
                    text: 'Start Tour',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'stats',
            title: '📊 Quick Stats',
            text: 'Here you can see a summary of all your certificate requests - total requests, pending ones, and those ready for download.',
            attachTo: {
                element: 'aside',
                on: 'right'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'new-request',
            title: '➕ Request New Certificate',
            text: 'Click here to start a new certificate request. You can request Baptismal, Confirmation, or Death certificates.',
            attachTo: {
                element: 'a[href="/parishioner/request/new"]',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'my-certificates',
            title: '📜 My Certificates',
            text: 'Access all your approved and ready certificates here. You can download them anytime.',
            attachTo: {
                element: 'a[href*="certificates.index"]',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'search-filter',
            title: '🔍 Search & Filter',
            text: 'Use the search bar to find specific requests, and use the dropdown filter to view requests by status (Pending, Processing, Ready, etc.).',
            attachTo: {
                element: '#searchInput',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'request-cards',
            title: '📋 Your Requests',
            text: `
                <div style="line-height: 1.6;">
                    <p>Each card shows a certificate request with:</p>
                    <ul style="margin: 10px 0; padding-left: 20px;">
                        <li>Certificate type and request date</li>
                        <li>Current status with progress bar</li>
                        <li>Quick actions to view details</li>
                    </ul>
                    <p style="margin-top: 10px;"><strong>Status meanings:</strong></p>
                    <ul style="margin: 5px 0; padding-left: 20px; font-size: 14px;">
                        <li><strong>Pending:</strong> Awaiting admin review</li>
                        <li><strong>Processing:</strong> Certificate being prepared</li>
                        <li><strong>Ready:</strong> Available for download</li>
                        <li><strong>Completed:</strong> Downloaded and closed</li>
                    </ul>
                </div>
            `,
            attachTo: {
                element: '.request-card',
                on: 'top'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'complete',
            title: '🎉 You\'re All Set!',
            text: `
                <div style="line-height: 1.6;">
                    <p>You're ready to start requesting certificates!</p>
                    <p style="margin-top: 12px;">Click "Request Certificate" to see the detailed request process.</p>
                    <p style="margin-top: 12px; font-size: 14px; color: #666;">
                        Remember: You can always restart this tour using the "Help Tour" button.
                    </p>
                </div>
            `,
            buttons: [
                {
                    text: 'Finish',
                    action: () => {
                        this.markTourComplete();
                        this.tour.complete();
                    }
                },
                {
                    text: 'Request Certificate',
                    action: () => {
                        this.markTourComplete();
                        this.tour.complete();
                        window.location.href = '/parishioner/request/new';
                    }
                }
            ]
        });

        // Auto-start tour for new users
        if (autoStart && !this.tourCompleted) {
            this.tour.start();
        }

        return this.tour;
    }

    // Request Form Tour
    initRequestFormTour() {
        this.tour = new Shepherd.Tour({
            useModalOverlay: true,
            defaultStepOptions: {
                classes: 'shepherd-theme-custom',
                scrollTo: { behavior: 'smooth', block: 'center' },
                cancelIcon: {
                    enabled: true
                }
            }
        });

        this.tour.addStep({
            id: 'welcome-request',
            title: '📝 Certificate Request Process',
            text: `
                <div style="line-height: 1.6;">
                    <p>Let's walk through the certificate request process step by step.</p>
                    <p style="margin-top: 10px;">This will only take a minute!</p>
                </div>
            `,
            buttons: [
                {
                    text: 'Skip',
                    action: this.tour.cancel,
                    secondary: true
                },
                {
                    text: 'Start',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'certificate-type',
            title: '1️⃣ Select Certificate Type',
            text: 'First, choose the type of certificate you need: Baptismal, Death, or Confirmation certificate.',
            attachTo: {
                element: '.cert-type-card',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'request-type',
            title: '2️⃣ Who is this for?',
            text: 'Specify if you\'re requesting for yourself or someone else. If for someone else, you\'ll need to provide additional information.',
            attachTo: {
                element: 'input[name="request_for"]',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'owner-info',
            title: '3️⃣ Certificate Owner Details',
            text: 'Enter the details of the person whose certificate you\'re requesting. Make sure the information matches church records.',
            attachTo: {
                element: 'input[name="owner_first_name"]',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'purpose',
            title: '4️⃣ Purpose of Request',
            text: 'Select why you need this certificate. This helps us prioritize and process your request appropriately.',
            attachTo: {
                element: 'select[name="purpose"]',
                on: 'top'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'parish-selection',
            title: '5️⃣ Select Parish',
            text: 'Choose the parish where the sacrament was administered. This is important for locating the correct records.',
            attachTo: {
                element: 'select[name="parish_id"]',
                on: 'top'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'submit',
            title: '6️⃣ Submit Your Request',
            text: `
                <div style="line-height: 1.6;">
                    <p>After filling all required fields, click "Submit Request".</p>
                    <p style="margin-top: 10px;"><strong>What happens next?</strong></p>
                    <ul style="margin: 10px 0; padding-left: 20px; font-size: 14px;">
                        <li>You'll be redirected to the payment page</li>
                        <li>Complete the payment to process your request</li>
                        <li>Admin will review and prepare your certificate</li>
                        <li>You'll be notified when it's ready for download</li>
                    </ul>
                </div>
            `,
            attachTo: {
                element: 'button[type="submit"]',
                on: 'top'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Got it!',
                    action: this.tour.complete
                }
            ]
        });

        this.tour.start();
        return this.tour;
    }

    // Payment Tour
    initPaymentTour() {
        this.tour = new Shepherd.Tour({
            useModalOverlay: true,
            defaultStepOptions: {
                classes: 'shepherd-theme-custom',
                scrollTo: { behavior: 'smooth', block: 'center' },
                cancelIcon: {
                    enabled: true
                }
            }
        });

        this.tour.addStep({
            id: 'payment-intro',
            title: '💳 Payment Process',
            text: `
                <div style="line-height: 1.6;">
                    <p>Your request has been submitted! Now let's complete the payment.</p>
                    <p style="margin-top: 10px;">This is the final step before your certificate is processed.</p>
                </div>
            `,
            buttons: [
                {
                    text: 'Skip',
                    action: this.tour.cancel,
                    secondary: true
                },
                {
                    text: 'Continue',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'payment-details',
            title: '📋 Request Summary',
            text: 'Review your request details and the payment amount. Make sure everything is correct before proceeding.',
            attachTo: {
                element: '.bg-white.rounded-2xl',
                on: 'top'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'payment-method',
            title: '💰 Payment Method',
            text: `
                <div style="line-height: 1.6;">
                    <p>Choose your preferred payment method:</p>
                    <ul style="margin: 10px 0; padding-left: 20px; font-size: 14px;">
                        <li><strong>GCash:</strong> Pay via GCash mobile wallet</li>
                        <li><strong>PayMaya:</strong> Use PayMaya for payment</li>
                        <li><strong>Bank Transfer:</strong> Direct bank transfer</li>
                    </ul>
                    <p style="margin-top: 10px;">All payment methods are secure and encrypted.</p>
                </div>
            `,
            attachTo: {
                element: 'select[name="payment_method"]',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'payment-proof',
            title: '📸 Upload Payment Proof',
            text: 'After making the payment, upload a screenshot or photo of your payment receipt. This helps us verify your payment quickly.',
            attachTo: {
                element: 'input[type="file"]',
                on: 'bottom'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Next',
                    action: this.tour.next
                }
            ]
        });

        this.tour.addStep({
            id: 'payment-complete',
            title: '✅ Complete Payment',
            text: `
                <div style="line-height: 1.6;">
                    <p>Click "Submit Payment" to complete the process.</p>
                    <p style="margin-top: 10px;"><strong>After payment:</strong></p>
                    <ul style="margin: 10px 0; padding-left: 20px; font-size: 14px;">
                        <li>Your request will be queued for processing</li>
                        <li>Admin will verify your payment</li>
                        <li>You'll receive notifications on status updates</li>
                        <li>Certificate will be ready in 2-3 business days</li>
                    </ul>
                </div>
            `,
            attachTo: {
                element: 'button[type="submit"]',
                on: 'top'
            },
            buttons: [
                {
                    text: 'Back',
                    action: this.tour.back,
                    secondary: true
                },
                {
                    text: 'Finish Tour',
                    action: this.tour.complete
                }
            ]
        });

        this.tour.start();
        return this.tour;
    }

    // Mark tour as completed
    markTourComplete() {
        localStorage.setItem('ditascom_tour_completed', 'true');
        this.tourCompleted = true;
    }

    // Reset tour (for testing or user request)
    resetTour() {
        localStorage.removeItem('ditascom_tour_completed');
        this.tourCompleted = false;
    }

    // Check if tour is completed
    isTourCompleted() {
        return this.tourCompleted;
    }
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = OnboardingTour;
}

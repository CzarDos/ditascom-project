# DITASCOM Onboarding Tour Feature

## Overview
The onboarding tour feature provides a guided, step-by-step walkthrough for new parishioners using the DITASCOM certificate management system. It helps users understand how to request certificates, make payments, and navigate the system.

## Features

### 1. **Automatic Tour for New Users**
- First-time visitors automatically see the guided tour
- Tour completion status is stored in browser localStorage
- Users can skip the tour at any time

### 2. **Help Tour Button**
- Floating help button (question mark icon) on all parishioner pages
- Always accessible in the bottom-right corner
- Pulsing animation for first-time users
- Click to restart the tour anytime

### 3. **Three Separate Tours**

#### Dashboard Tour
Covers:
- Quick stats overview
- New request button
- My certificates section
- Search and filter functionality
- Request cards and status meanings

#### Request Form Tour
Covers:
- Certificate type selection
- Request type (self vs. others)
- Certificate owner details
- Purpose selection
- Parish selection
- Form submission process

#### Payment Tour
Covers:
- Payment details review
- Payment method selection
- Payment proof upload
- Submission and next steps

## Technical Implementation

### Files Created

1. **`public/js/onboarding-tour.js`**
   - Main tour logic using Shepherd.js
   - Three tour classes: Dashboard, Request Form, Payment
   - localStorage management for tour completion

2. **`public/css/onboarding-tour.css`**
   - Custom styling for tour modals
   - Help button styling
   - Responsive design for mobile devices
   - Pulse animation for first-time users

### Files Modified

1. **`resources/views/parishioner/dashboard.blade.php`**
   - Added Shepherd.js library
   - Added help tour button
   - Auto-start tour for new users

2. **`resources/views/parishioner/request-new.blade.php`**
   - Added tour initialization
   - Help button integration
   - Auto-start for new users

3. **`resources/views/parishioner/payment.blade.php`**
   - Added payment tour
   - Help button integration

4. **`resources/views/layouts/app.blade.php`**
   - Added Shepherd.js CSS globally
   - Added custom tour CSS

## Usage

### For Users

**First Visit:**
1. User logs in for the first time
2. Tour automatically starts on dashboard
3. User can follow the guided steps or skip
4. Tour completion is saved in browser

**Returning Users:**
1. Help button available on all pages
2. Click the floating question mark button
3. Tour restarts from the current page

**Resetting the Tour:**
- Clear browser localStorage
- Or use browser developer tools: `localStorage.removeItem('ditascom_tour_completed')`

### For Developers

**Initialize a Tour:**
```javascript
const onboardingTour = new OnboardingTour();

// Dashboard tour with auto-start
onboardingTour.initDashboardTour(true);

// Request form tour
onboardingTour.initRequestFormTour();

// Payment tour
onboardingTour.initPaymentTour();
```

**Check Tour Status:**
```javascript
const tour = new OnboardingTour();
if (!tour.isTourCompleted()) {
    // Show tour
}
```

**Reset Tour:**
```javascript
const tour = new OnboardingTour();
tour.resetTour();
```

## Customization

### Adding New Steps

Edit `public/js/onboarding-tour.js` and add steps to the appropriate tour:

```javascript
this.tour.addStep({
    id: 'unique-step-id',
    title: 'Step Title',
    text: 'Step description',
    attachTo: {
        element: '.css-selector',
        on: 'bottom' // or 'top', 'left', 'right'
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
```

### Styling

Modify `public/css/onboarding-tour.css` to change:
- Modal appearance
- Button colors
- Help button position
- Animation effects

### Tour Behavior

In the JavaScript files, you can modify:
- Auto-start conditions
- Step order
- Button actions
- Completion tracking

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile responsive
- Uses localStorage (supported in all modern browsers)

## Dependencies

- **Shepherd.js v11.2.0** - Tour library
- **Font Awesome 6.0.0** - Icons
- **Tailwind CSS** - Styling (already in project)

## Troubleshooting

### Tour Not Starting
1. Check browser console for errors
2. Verify Shepherd.js is loaded
3. Clear localStorage and try again

### Help Button Not Visible
1. Check z-index conflicts
2. Verify CSS file is loaded
3. Check for JavaScript errors

### Tour Steps Not Attaching
1. Verify target elements exist on page
2. Check CSS selectors are correct
3. Ensure page is fully loaded before tour starts

## Future Enhancements

Potential improvements:
- Server-side tour completion tracking
- Different tours for different user roles
- Analytics on tour completion rates
- Multi-language support
- Video tutorials integration
- Interactive practice mode

## Support

For issues or questions:
1. Check browser console for errors
2. Review this documentation
3. Contact development team

## License

Part of the DITASCOM project.

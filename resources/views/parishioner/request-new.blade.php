@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<form id="certificate-request-form" method="POST" action="{{ route('parishioner.certificate-request.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="certificate_type" id="certificate_type" value="Baptismal Certificate">
    <div class="max-w-4xl mx-auto my-8 bg-white rounded-2xl shadow-sm p-6 lg:p-10">
        <div class="text-xl font-semibold mb-2">Request Official Certificates</div>
        <div class="text-gray-500 mb-8">Select the type of certificate you need</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-10">
            <div class="cert-type-card flex-1 bg-gray-50 rounded-lg p-4 lg:p-5 text-center border-2 border-gray-200 cursor-pointer transition-all hover:border-blue-900 hover:bg-blue-50 border-blue-900 bg-blue-50" data-type="Baptismal Certificate">
                <i class="fas fa-certificate text-2xl lg:text-3xl mb-2 text-blue-900"></i>
                <div class="font-semibold mb-1">Baptismal Certificate</div>
                <div class="text-gray-500 text-sm">Request your baptismal records</div>
            </div>
            <div class="cert-type-card flex-1 bg-gray-50 rounded-lg p-4 lg:p-5 text-center border-2 border-gray-200 cursor-pointer transition-all hover:border-blue-900 hover:bg-blue-50" data-type="Death Certificate">
                <i class="fas fa-file-alt text-2xl lg:text-3xl mb-2 text-blue-900"></i>
                <div class="font-semibold mb-1">Death Certificate</div>
                <div class="text-gray-500 text-sm">Request death certificates</div>
            </div>
            <div class="cert-type-card flex-1 bg-gray-50 rounded-lg p-4 lg:p-5 text-center border-2 border-gray-200 cursor-pointer transition-all hover:border-blue-900 hover:bg-blue-50" data-type="Confirmation Certificate">
                <i class="fas fa-church text-2xl lg:text-3xl mb-2 text-blue-900"></i>
                <div class="font-semibold mb-1">Confirmation Certificate</div>
                <div class="text-gray-500 text-sm">Access confirmation records</div>
            </div>
        </div>
        <div class="font-semibold mt-8 mb-4 text-lg text-blue-900">Request Type</div>
        <div class="flex gap-8 mb-5">
            <label class="font-medium text-gray-700 flex items-center gap-2"><input type="radio" name="request_for" value="self" checked class="text-blue-900"> Requesting for myself</label>
            <label class="font-medium text-gray-700 flex items-center gap-2"><input type="radio" name="request_for" value="others" class="text-blue-900"> Requesting for someone else</label>
        </div>
        <div id="personal-info-section" class="hidden">
            <div class="font-semibold mt-8 mb-4 text-lg text-blue-900">Personal Information</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <div class="flex flex-col">
                    <label class="text-sm text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" placeholder="Enter your first name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
                </div>
                <div class="flex flex-col">
                    <label class="text-sm text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" placeholder="Enter your last name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <div class="flex flex-col">
                    <label class="text-sm text-gray-700 mb-1">Contact Number</label>
                    <input type="text" name="contact_number" placeholder="09XXXXXXXXX" required class="p-3 border border-gray-200 rounded-md text-base bg-white" maxlength="11" pattern="[0-9]{11}" inputmode="numeric">
                    <div class="text-xs text-gray-500 mt-1">11-digit Philippine mobile number (e.g., 09171234567)</div>
                </div>
                <div class="flex flex-col">
                    <label class="text-sm text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email address" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <div class="flex flex-col">
                    <label class="text-sm text-gray-700 mb-1">Current Address</label>
                    <input type="text" name="current_address" placeholder="Enter your current address" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
                </div>
                <div class="flex flex-col">
                    <label class="text-sm text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" required class="p-3 border border-gray-200 rounded-md text-base bg-white" max="{{ date('Y-m-d') }}">
                    <div id="personal-dob-error" class="text-red-500 text-sm mt-1 hidden">Date of birth cannot be in the future</div>
                </div>
            </div>
        </div>
        <div id="certificate-owner-section" class="font-semibold mt-8 mb-4 text-lg text-blue-900">Certificate Owner's Information</div>
        <div id="certificate-owner-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">First Name</label>
                <input type="text" name="owner_first_name" placeholder="Enter certificate owner's first name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Last Name</label>
                <input type="text" name="owner_last_name" placeholder="Enter certificate owner's last name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
            </div>
        </div>
        <div id="certificate-owner-fields-2" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Date of Birth</label>
                <input type="date" name="owner_date_of_birth" required class="p-3 border border-gray-200 rounded-md text-base bg-white" max="{{ date('Y-m-d') }}">
                <div id="owner-dob-error" class="text-red-500 text-sm mt-1 hidden">Date of birth cannot be in the future</div>
            </div>
            <div class="flex flex-col" id="relationship-group">
                <label class="text-sm text-gray-700 mb-1">Relationship to Requestor</label>
                <select name="relationship" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
                    <option value="">Select relationship</option>
                    <option value="Parent">Parent</option>
                    <option value="Child">Child</option>
                    <option value="Sibling">Sibling</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Relative">Relative</option>
                    <option value="Legal Guardian">Legal Guardian</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 mb-5">
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Purpose of Request</label>
                <select name="purpose" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
                    <option value="">Select purpose</option>
                    <option value="Employment">Employment</option>
                    <option value="School Requirements">School Requirements</option>
                    <option value="Government ID">Government ID</option>
                    <option value="Marriage">Marriage</option>
                    <option value="Legal Matters">Legal Matters</option>
                    <option value="Personal Records">Personal Records</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="font-semibold mt-8 mb-4 text-lg text-blue-900">Parent's Information</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Father's First Name</label>
                <input type="text" name="father_first_name" placeholder="Enter father's first name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Father's Last Name</label>
                <input type="text" name="father_last_name" placeholder="Enter father's last name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Mother's First Name</label>
                <input type="text" name="mother_first_name" placeholder="Enter mother's first name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Mother's Last Name</label>
                <input type="text" name="mother_last_name" placeholder="Enter mother's last name" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
            </div>
        </div>
        
        <!-- Parish Information Section -->
        <div class="font-semibold mt-8 mb-4 text-lg text-blue-900">Parish Registration Information</div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-5">
            <div class="flex items-center gap-2 text-blue-700 mb-2">
                <i class="fas fa-church"></i>
                <span class="font-medium">Important Information</span>
            </div>
            <div class="text-blue-600 text-sm">
                Please specify the parish where the certificate owner was registered for baptismal, death, or confirmation records. This helps us verify and generate the correct certificate.
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 mb-5">
            <div class="flex flex-col">
                <label class="text-sm text-gray-700 mb-1">Registered Parish <span class="text-red-500">*</span></label>
                <input type="text" name="registered_parish" placeholder="Enter the parish name where records are registered" required class="p-3 border border-gray-200 rounded-md text-base bg-white">
                <div class="text-xs text-gray-500 mt-1">Example: Sto. Niño Parish of Panabo, San Isidro Labrador Parish of Kapalong, etc.</div>
            </div>
        </div>
        
        <div id="third-party-section" class="hidden">
            <div class="flex flex-col mb-5">
                <label class="text-sm text-gray-700 mb-1">Reason for Third-Party Request</label>
                <textarea name="third_party_reason" placeholder="Please provide detailed reason for requesting on behalf of someone else" class="p-3 border border-gray-200 rounded-md text-base bg-white min-h-[60px]"></textarea>
            </div>
            
            <!-- Relationship Summary Display -->
            <div id="relationship-summary" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-5 hidden">
                <div class="flex items-center gap-2 text-blue-700 mb-2">
                    <i class="fas fa-info-circle"></i>
                    <span class="font-medium">Request Summary</span>
                </div>
                <div class="text-blue-600 text-sm">
                    <span id="requester-name-display">You</span> are requesting a certificate for 
                    <span id="owner-name-display" class="font-medium">certificate owner</span> 
                    as their <span id="relationship-display" class="font-medium">relationship</span>.
                </div>
            </div>
        </div>
        <div class="font-semibold mt-8 mb-4 text-lg text-blue-900">Identity Verification</div>
        <div class="text-gray-600 text-sm mb-4">Please upload both front and back of your valid ID (Driver's License, Passport, National ID, etc.)</div>
        
        <!-- Front ID Upload -->
        <div class="bg-gray-50 border-2 border-dashed border-indigo-300 rounded-lg p-6 text-center mb-4">
            <i class="fas fa-id-card text-2xl text-blue-900 mb-2"></i>
            <div class="mb-1">Upload Front of Valid ID</div>
            <div class="text-gray-500 text-sm mb-3">Supported formats: JPG, PNG (Max 2MB)</div>
            <label for="id-front-upload" class="inline-block bg-blue-900 text-white rounded-md px-5 py-2 text-base font-medium cursor-pointer hover:bg-blue-800 transition">Choose File</label>
            <input type="file" name="id_front_photo" id="id-front-upload" class="hidden" accept=".jpg,.jpeg,.png" required>
            <div id="front-file-name" class="mt-2 text-sm text-gray-600"></div>
        </div>
        
        <!-- Back ID Upload -->
        <div class="bg-gray-50 border-2 border-dashed border-indigo-300 rounded-lg p-6 text-center mb-4">
            <i class="fas fa-id-card text-2xl text-blue-900 mb-2"></i>
            <div class="mb-1">Upload Back of Valid ID</div>
            <div class="text-gray-500 text-sm mb-3">Supported formats: JPG, PNG (Max 2MB)</div>
            <label for="id-back-upload" class="inline-block bg-blue-900 text-white rounded-md px-5 py-2 text-base font-medium cursor-pointer hover:bg-blue-800 transition">Choose File</label>
            <input type="file" name="id_back_photo" id="id-back-upload" class="hidden" accept=".jpg,.jpeg,.png" required>
            <div id="back-file-name" class="mt-2 text-sm text-gray-600"></div>
        </div>
        
        <!-- Additional Photos Upload -->
        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center mb-6">
            <i class="fas fa-images text-2xl text-blue-900 mb-2"></i>
            <div class="mb-1">Upload Additional Photos (Optional)</div>
            <div class="text-gray-500 text-sm mb-3">You can upload multiple additional photos if needed. Supported formats: JPG, PNG (Max 2MB each)</div>
            <label for="additional-photos-upload" class="inline-block bg-gray-600 text-white rounded-md px-5 py-2 text-base font-medium cursor-pointer hover:bg-gray-700 transition">Choose Files</label>
            <input type="file" name="additional_photos[]" id="additional-photos-upload" class="hidden" accept=".jpg,.jpeg,.png" multiple>
            <div id="additional-files-list" class="mt-2 text-sm text-gray-600"></div>
        </div>
        <div class="flex items-center gap-3 mb-5">
            <input type="checkbox" id="terms" required class="text-blue-900">
            <label for="terms" class="text-sm text-gray-700">I agree to the Terms of Service and Privacy Policy</label>
        </div>
        <div class="bg-blue-50 text-blue-900 rounded-md p-3 text-sm mb-5">Your personal information will be handled according to our privacy policy and used solely for the purpose of processing your certificate request.</div>
        <div class="bg-blue-50 text-blue-900 rounded-md p-3 text-sm mb-6">Estimated processing time: 3-5 business days</div>
        <div class="flex justify-end gap-4 mt-6">
            <button class="cancel-btn border-0 rounded-md px-6 py-2 text-base font-medium cursor-pointer transition bg-gray-100 text-gray-800 hover:bg-gray-200" type="button">Cancel</button>
            <button class="submit-btn border-0 rounded-md px-6 py-2 text-base font-medium cursor-pointer transition bg-blue-900 text-white hover:bg-blue-800" type="submit">Submit Request</button>
        </div>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Certificate type selection
        document.querySelectorAll('.cert-type-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.cert-type-card').forEach(c => {
                    c.classList.remove('border-blue-900', 'bg-blue-50');
                    c.classList.add('border-gray-200', 'bg-gray-50');
                });
                this.classList.remove('border-gray-200', 'bg-gray-50');
                this.classList.add('border-blue-900', 'bg-blue-50');
                document.getElementById('certificate_type').value = this.getAttribute('data-type');
            });
        });

        // Cancel button
        document.querySelector('.cancel-btn').addEventListener('click', function() {
            window.location.href = '/parishioner/dashboard';
        });

        // File upload functionality for ID front
        const frontFileInput = document.getElementById('id-front-upload');
        const frontFileName = document.getElementById('front-file-name');
        
        frontFileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (file.size > 2 * 1024 * 1024) { // 2MB limit
                    alert('File size must be less than 2MB');
                    this.value = '';
                    frontFileName.textContent = '';
                    return;
                }
                frontFileName.textContent = `Selected: ${file.name}`;
            } else {
                frontFileName.textContent = '';
            }
        });
        
        // File upload functionality for ID back
        const backFileInput = document.getElementById('id-back-upload');
        const backFileName = document.getElementById('back-file-name');
        
        backFileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (file.size > 2 * 1024 * 1024) { // 2MB limit
                    alert('File size must be less than 2MB');
                    this.value = '';
                    backFileName.textContent = '';
                    return;
                }
                backFileName.textContent = `Selected: ${file.name}`;
            } else {
                backFileName.textContent = '';
            }
        });
        
        // File upload functionality for additional photos
        const additionalPhotosInput = document.getElementById('additional-photos-upload');
        const additionalFilesList = document.getElementById('additional-files-list');
        
        additionalPhotosInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                let fileNames = [];
                let validFiles = true;
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    if (file.size > 2 * 1024 * 1024) { // 2MB limit
                        alert(`File "${file.name}" is too large. Each file must be less than 2MB`);
                        this.value = '';
                        additionalFilesList.textContent = '';
                        validFiles = false;
                        break;
                    }
                    fileNames.push(file.name);
                }
                
                if (validFiles) {
                    additionalFilesList.textContent = `Selected ${this.files.length} file(s): ${fileNames.join(', ')}`;
                }
            } else {
                additionalFilesList.textContent = '';
            }
        });

        // Handle request type radio buttons
        const requestTypeRadios = document.querySelectorAll('input[name="request_for"]');
        const personalInfoSection = document.getElementById('personal-info-section');
        const thirdPartySection = document.getElementById('third-party-section');
        const relationshipGroup = document.getElementById('relationship-group');
        const certificateOwnerSection = document.getElementById('certificate-owner-section');
        const certificateOwnerFields = document.getElementById('certificate-owner-fields');
        const certificateOwnerFields2 = document.getElementById('certificate-owner-fields-2');

        requestTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'self') {
                    personalInfoSection.classList.remove('hidden');
                    thirdPartySection.classList.add('hidden');
                    relationshipGroup.classList.add('hidden');
                    // Hide certificate owner section when requesting for self
                    certificateOwnerSection.classList.add('hidden');
                    certificateOwnerFields.classList.add('hidden');
                    certificateOwnerFields2.classList.add('hidden');
                    // Remove required attributes when hidden
                    relationshipGroup.querySelector('select').removeAttribute('required');
                    document.querySelector('input[name="owner_first_name"]').removeAttribute('required');
                    document.querySelector('input[name="owner_last_name"]').removeAttribute('required');
                    document.querySelector('input[name="owner_date_of_birth"]').removeAttribute('required');
                } else {
                    personalInfoSection.classList.remove('hidden');
                    thirdPartySection.classList.remove('hidden');
                    relationshipGroup.classList.remove('hidden');
                    // Show certificate owner section when requesting for others
                    certificateOwnerSection.classList.remove('hidden');
                    certificateOwnerFields.classList.remove('hidden');
                    certificateOwnerFields2.classList.remove('hidden');
                    // Add required attributes when visible
                    relationshipGroup.querySelector('select').setAttribute('required', 'required');
                    document.querySelector('input[name="owner_first_name"]').setAttribute('required', 'required');
                    document.querySelector('input[name="owner_last_name"]').setAttribute('required', 'required');
                    document.querySelector('input[name="owner_date_of_birth"]').setAttribute('required', 'required');
                }
                // Update relationship summary when request type changes
                updateRelationshipSummary();
            });
        });

        // Date validation for date of birth fields
        const today = new Date().toISOString().split('T')[0];
        
        // Personal date of birth validation
        const personalDobInput = document.querySelector('input[name="date_of_birth"]');
        const personalDobError = document.getElementById('personal-dob-error');
        
        personalDobInput.addEventListener('change', function() {
            if (this.value > today) {
                personalDobError.classList.remove('hidden');
                this.setCustomValidity('Date of birth cannot be in the future');
            } else {
                personalDobError.classList.add('hidden');
                this.setCustomValidity('');
            }
        });
        
        // Owner date of birth validation
        const ownerDobInput = document.querySelector('input[name="owner_date_of_birth"]');
        const ownerDobError = document.getElementById('owner-dob-error');
        
        ownerDobInput.addEventListener('change', function() {
            if (this.value > today) {
                ownerDobError.classList.remove('hidden');
                this.setCustomValidity('Date of birth cannot be in the future');
            } else {
                ownerDobError.classList.add('hidden');
                this.setCustomValidity('');
            }
        });

        // Relationship summary update function
        function updateRelationshipSummary() {
            const requestFor = document.querySelector('input[name="request_for"]:checked').value;
            const relationshipSummary = document.getElementById('relationship-summary');
            
            if (requestFor === 'others') {
                const ownerFirstName = document.querySelector('input[name="owner_first_name"]').value;
                const ownerLastName = document.querySelector('input[name="owner_last_name"]').value;
                const relationship = document.querySelector('select[name="relationship"]').value;
                const requesterFirstName = document.querySelector('input[name="first_name"]').value;
                const requesterLastName = document.querySelector('input[name="last_name"]').value;
                
                // Update display elements
                const requesterDisplay = document.getElementById('requester-name-display');
                const ownerDisplay = document.getElementById('owner-name-display');
                const relationshipDisplay = document.getElementById('relationship-display');
                
                // Set requester name or default to "You"
                if (requesterFirstName && requesterLastName) {
                    requesterDisplay.textContent = `${requesterFirstName} ${requesterLastName}`;
                } else {
                    requesterDisplay.textContent = 'You';
                }
                
                // Set owner name or default
                if (ownerFirstName && ownerLastName) {
                    ownerDisplay.textContent = `${ownerFirstName} ${ownerLastName}`;
                } else {
                    ownerDisplay.textContent = 'certificate owner';
                }
                
                // Set relationship or default
                if (relationship) {
                    relationshipDisplay.textContent = relationship.toLowerCase();
                } else {
                    relationshipDisplay.textContent = 'relationship';
                }
                
                // Show summary if we have at least owner name and relationship
                if ((ownerFirstName || ownerLastName) && relationship) {
                    relationshipSummary.classList.remove('hidden');
                } else {
                    relationshipSummary.classList.add('hidden');
                }
            } else {
                relationshipSummary.classList.add('hidden');
            }
        }
        
        // Contact number validation - only allow numbers
        const contactNumberInput = document.querySelector('input[name="contact_number"]');
        contactNumberInput.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 11 digits
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });
        
        contactNumberInput.addEventListener('keypress', function(e) {
            // Only allow numeric keys
            if (e.key < '0' || e.key > '9') {
                e.preventDefault();
            }
        });

        // Add event listeners for relationship summary updates
        document.querySelector('input[name="first_name"]').addEventListener('input', updateRelationshipSummary);
        document.querySelector('input[name="last_name"]').addEventListener('input', updateRelationshipSummary);
        document.querySelector('input[name="owner_first_name"]').addEventListener('input', updateRelationshipSummary);
        document.querySelector('input[name="owner_last_name"]').addEventListener('input', updateRelationshipSummary);
        document.querySelector('select[name="relationship"]').addEventListener('change', updateRelationshipSummary);

        // Initial state
        if (document.querySelector('input[name="request_for"]:checked').value === 'self') {
            personalInfoSection.classList.remove('hidden');
            thirdPartySection.classList.add('hidden');
            relationshipGroup.classList.add('hidden');
            // Hide certificate owner section initially when requesting for self
            certificateOwnerSection.classList.add('hidden');
            certificateOwnerFields.classList.add('hidden');
            certificateOwnerFields2.classList.add('hidden');
            // Remove required attributes
            relationshipGroup.querySelector('select').removeAttribute('required');
            document.querySelector('input[name="owner_first_name"]').removeAttribute('required');
            document.querySelector('input[name="owner_last_name"]').removeAttribute('required');
            document.querySelector('input[name="owner_date_of_birth"]').removeAttribute('required');
        }

        // Form validation
        document.getElementById('certificate-request-form').addEventListener('submit', function(e) {
            const terms = document.getElementById('terms');
            if (!terms.checked) {
                e.preventDefault();
                alert('Please agree to the Terms of Service and Privacy Policy');
                return false;
            }
            
            // Validate ID uploads
            const frontIdInput = document.getElementById('id-front-upload');
            const backIdInput = document.getElementById('id-back-upload');
            
            if (!frontIdInput.files || frontIdInput.files.length === 0) {
                e.preventDefault();
                alert('Please upload the front of your valid ID');
                return false;
            }
            
            if (!backIdInput.files || backIdInput.files.length === 0) {
                e.preventDefault();
                alert('Please upload the back of your valid ID');
                return false;
            }
            
            // Validate date of birth fields
            const personalDob = document.querySelector('input[name="date_of_birth"]');
            const ownerDob = document.querySelector('input[name="owner_date_of_birth"]');
            
            if (personalDob.value > today) {
                e.preventDefault();
                alert('Personal date of birth cannot be in the future');
                return false;
            }
            
            if (!ownerDob.hasAttribute('required') || ownerDob.value <= today) {
                // Owner DOB is either not required or valid
            } else if (ownerDob.value > today) {
                e.preventDefault();
                alert('Certificate owner\'s date of birth cannot be in the future');
                return false;
            }
            
            // Validate contact number format
            const contactNumber = document.querySelector('input[name="contact_number"]').value;
            if (contactNumber.length !== 11) {
                e.preventDefault();
                alert('Contact number must be exactly 11 digits');
                return false;
            }
            
            if (!/^[0-9]{11}$/.test(contactNumber)) {
                e.preventDefault();
                alert('Contact number must contain only numbers');
                return false;
            }
        });

        // Initialize Request Form Tour
        const onboardingTour = new OnboardingTour();
        
        // Check if user came from dashboard tour
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tour') === 'start' || !onboardingTour.isTourCompleted()) {
            // Small delay to ensure page is fully loaded
            setTimeout(() => {
                onboardingTour.initRequestFormTour();
            }, 500);
        }
    });
</script>

<!-- Help Tour Button -->
<button class="help-tour-btn" id="helpTourBtn" title="Start Help Tour">
    <i class="fas fa-question"></i>
</button>

<!-- Shepherd.js Library -->
<script src="https://cdn.jsdelivr.net/npm/shepherd.js@11.2.0/dist/js/shepherd.min.js"></script>
<script src="{{ asset('js/onboarding-tour.js') }}"></script>

<script>
    // Help Tour Button Click Handler for Request Form
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('helpTourBtn').addEventListener('click', function() {
            const tour = new OnboardingTour();
            tour.initRequestFormTour();
        });
    });
</script>

<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection 
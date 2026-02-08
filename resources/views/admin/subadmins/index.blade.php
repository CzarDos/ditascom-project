@extends('layouts.admin')

@section('title', 'Parish Management')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Parish Management</h1>
    </div>

            <!-- Table Section -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Parish Administrators</h2>
                    <div class="flex items-center gap-3">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.subadmins.index') }}" class="flex items-center gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Search..." 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                            <a href="{{ route('admin.subadmins.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </form>
                        <button onclick="openAddParishModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Add Parish
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parish Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parish Logo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parish Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($subAdmins as $subAdmin)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subAdmin->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subAdmin->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $subAdmin->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subAdmin->parish_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($subAdmin->parish_logo)
                                        <img src="{{ asset('storage/' . $subAdmin->parish_logo) }}" alt="Parish Logo" class="w-10 h-10 object-cover rounded-lg">
                                    @else
                                        <span class="text-gray-400">No logo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $subAdmin->parish_address ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $subAdmin->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal({{ $subAdmin->id }}, '{{ addslashes($subAdmin->name) }}', '{{ addslashes($subAdmin->email) }}', '{{ addslashes($subAdmin->parish_name ?? '') }}', '{{ addslashes($subAdmin->parish_address ?? '') }}', '{{ addslashes($subAdmin->parish_logo ?? '') }}')" 
                                            class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded transition">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="confirmDelete({{ $subAdmin->id }})" 
                                            class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                    <p>No parish administrators found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $subAdmins->links() }}
                </div>
            </div>
        </main>
    </div>

    <!-- Add Parish Modal -->
    <div id="addParishModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-2xl">
                <h2 class="text-xl font-semibold text-gray-800">Add New Parish Administrator</h2>
                <button onclick="closeAddParishModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.subadmins.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Administrator Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter administrator name">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter email address">
                    </div>
                    
                    <div>
                        <label for="parish_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="parish_name" name="parish_name" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="e.g., Sto. Niño Parish">
                    </div>
                    
                    <div>
                        <label for="parish_logo" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Logo <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <input type="file" id="parish_logo" name="parish_logo" accept="image/*" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    onchange="previewLogo(this, 'logoPreview')">
                                <p class="text-xs text-gray-500 mt-1">Upload PNG, JPG, or JPEG (max 2MB)</p>
                            </div>
                            <div id="logoPreview" class="w-16 h-16 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="parish_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Address <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="parish_address" name="parish_address" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="e.g., Panabo City, Davao del Norte, Philippines, 8105">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter password">
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Confirm password">
                        <div id="password_error" class="hidden mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Passwords do not match
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeAddParishModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="add_submit_btn"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Parish Administrator
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-2xl">
                <h2 class="text-xl font-semibold text-gray-800">Edit Parish Administrator</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Administrator Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit_name" name="name" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="edit_email" name="email" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="edit_parish_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit_parish_name" name="parish_name" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="e.g., Sto. Niño Parish">
                    </div>
                    
                    <div>
                        <label for="edit_parish_logo" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Logo
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <input type="file" id="edit_parish_logo" name="parish_logo" accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    onchange="previewLogo(this, 'editLogoPreview')">
                                <p class="text-xs text-gray-500 mt-1">Upload PNG, JPG, or JPEG (max 2MB) - Leave empty to keep current logo</p>
                            </div>
                            <div id="editLogoPreview" class="w-16 h-16 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="edit_parish_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Parish Address <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit_parish_address" name="parish_address" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="e.g., Panabo City, Davao del Norte, Philippines, 8105">
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Change Password (Optional)</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    New Password
                                </label>
                                <input type="password" id="edit_password" name="password" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Leave blank to keep current password">
                            </div>
                            
                            <div>
                                <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm New Password
                                </label>
                                <input type="password" id="edit_password_confirmation" name="password_confirmation" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Confirm new password">
                                <div id="edit_password_error" class="hidden mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Passwords do not match
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="edit_submit_btn"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Parish Administrator
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="text-center mb-4">
                    <div class="mx-auto w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Confirm Delete</h2>
                    <p class="text-gray-600">Are you sure you want to delete this parish administrator? This action cannot be undone.</p>
                </div>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('certificatesDropdown').classList.toggle('hidden');
        }

        function openAddParishModal() {
            document.getElementById('addParishModal').classList.remove('hidden');
            // Setup validation after modal is visible
            setTimeout(setupAddParishValidation, 100);
        }

        function closeAddParishModal() {
            document.getElementById('addParishModal').classList.add('hidden');
            // Clear validation state
            clearAddParishValidation();
        }
        
        document.getElementById('addParishModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAddParishModal();
        });

        function openEditModal(id, name, email, parishName, parishAddress, parishLogo) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            form.action = `/admin/subadmins/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_parish_name').value = parishName || '';
            document.getElementById('edit_parish_address').value = parishAddress || '';
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_password_confirmation').value = '';
            
            // Handle parish logo preview
            const logoPreview = document.getElementById('editLogoPreview');
            if (parishLogo) {
                logoPreview.innerHTML = `<img src="/storage/${parishLogo}" alt="Current Logo" class="w-full h-full object-cover rounded-lg">`;
            } else {
                logoPreview.innerHTML = '<i class="fas fa-image text-gray-400"></i>';
            }
            
            modal.classList.remove('hidden');
            // Setup validation after modal is visible
            setTimeout(setupEditValidation, 100);
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            // Clear validation state
            clearEditValidation();
        }
        
        document.getElementById('editModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        function confirmDelete(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/admin/subadmins/${id}`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        
        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        // Password validation for Add Parish form
        function validateAddPassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const errorDiv = document.getElementById('password_error');
            const submitBtn = document.getElementById('add_submit_btn');
            const confirmInput = document.getElementById('password_confirmation');

            // Show error if confirm password has value and doesn't match password
            if (confirmPassword && password && password !== confirmPassword) {
                errorDiv.classList.remove('hidden');
                confirmInput.classList.add('border-red-500');
                confirmInput.classList.remove('border-gray-300');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                return false;
            } else if (confirmPassword && password && password === confirmPassword) {
                // Passwords match
                errorDiv.classList.add('hidden');
                confirmInput.classList.remove('border-red-500');
                confirmInput.classList.add('border-gray-300');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                return true;
            } else if (confirmPassword && !password) {
                // Confirm password has value but password is empty
                errorDiv.classList.remove('hidden');
                confirmInput.classList.add('border-red-500');
                confirmInput.classList.remove('border-gray-300');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                return false;
            } else {
                // Either both empty or confirm password is empty
                errorDiv.classList.add('hidden');
                confirmInput.classList.remove('border-red-500');
                confirmInput.classList.add('border-gray-300');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                return true;
            }
        }

        // Password validation for Edit form
        function validateEditPassword() {
            const password = document.getElementById('edit_password').value;
            const confirmPassword = document.getElementById('edit_password_confirmation').value;
            const errorDiv = document.getElementById('edit_password_error');
            const submitBtn = document.getElementById('edit_submit_btn');
            const confirmInput = document.getElementById('edit_password_confirmation');

            // Show error if confirm password has value and doesn't match password
            if (confirmPassword && password && password !== confirmPassword) {
                errorDiv.classList.remove('hidden');
                confirmInput.classList.add('border-red-500');
                confirmInput.classList.remove('border-gray-300');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                return false;
            } else if (confirmPassword && password && password === confirmPassword) {
                // Passwords match
                errorDiv.classList.add('hidden');
                confirmInput.classList.remove('border-red-500');
                confirmInput.classList.add('border-gray-300');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                return true;
            } else if (confirmPassword && !password) {
                // Confirm password has value but password is empty
                errorDiv.classList.remove('hidden');
                confirmInput.classList.add('border-red-500');
                confirmInput.classList.remove('border-gray-300');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                return false;
            } else {
                // Either both empty or confirm password is empty (OK for edit since password change is optional)
                errorDiv.classList.add('hidden');
                confirmInput.classList.remove('border-red-500');
                confirmInput.classList.add('border-gray-300');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                return true;
            }
        }

        // Setup event listeners for Add Parish form
        function setupAddParishValidation() {
            const addPassword = document.getElementById('password');
            const addConfirmPassword = document.getElementById('password_confirmation');
            const addForm = document.querySelector('#addParishModal form');

            if (addPassword && addConfirmPassword) {
                // Remove existing listeners to prevent duplicates
                addPassword.removeEventListener('input', validateAddPassword);
                addConfirmPassword.removeEventListener('input', validateAddPassword);
                
                // Add new listeners
                addPassword.addEventListener('input', validateAddPassword);
                addConfirmPassword.addEventListener('input', validateAddPassword);
            }

            // Prevent form submission if passwords don't match
            if (addForm) {
                addForm.removeEventListener('submit', handleAddFormSubmit);
                addForm.addEventListener('submit', handleAddFormSubmit);
            }
        }

        // Setup event listeners for Edit form
        function setupEditValidation() {
            const editPassword = document.getElementById('edit_password');
            const editConfirmPassword = document.getElementById('edit_password_confirmation');
            const editForm = document.getElementById('editForm');

            if (editPassword && editConfirmPassword) {
                // Remove existing listeners to prevent duplicates
                editPassword.removeEventListener('input', validateEditPassword);
                editConfirmPassword.removeEventListener('input', validateEditPassword);
                
                // Add new listeners
                editPassword.addEventListener('input', validateEditPassword);
                editConfirmPassword.addEventListener('input', validateEditPassword);
            }

            if (editForm) {
                editForm.removeEventListener('submit', handleEditFormSubmit);
                editForm.addEventListener('submit', handleEditFormSubmit);
            }
        }

        // Form submit handlers
        function handleAddFormSubmit(e) {
            if (!validateAddPassword()) {
                e.preventDefault();
                return false;
            }
        }

        function handleEditFormSubmit(e) {
            if (!validateEditPassword()) {
                e.preventDefault();
                return false;
            }
        }

        // Clear validation functions
        function clearAddParishValidation() {
            const errorDiv = document.getElementById('password_error');
            const submitBtn = document.getElementById('add_submit_btn');
            const confirmInput = document.getElementById('password_confirmation');
            
            if (errorDiv) errorDiv.classList.add('hidden');
            if (confirmInput) {
                confirmInput.classList.remove('border-red-500');
                confirmInput.classList.add('border-gray-300');
            }
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        function clearEditValidation() {
            const errorDiv = document.getElementById('edit_password_error');
            const submitBtn = document.getElementById('edit_submit_btn');
            const confirmInput = document.getElementById('edit_password_confirmation');
            
            if (errorDiv) errorDiv.classList.add('hidden');
            if (confirmInput) {
                confirmInput.classList.remove('border-red-500');
                confirmInput.classList.add('border-gray-300');
            }
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // Logo preview function
        function previewLogo(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            
            if (file) {
                // Check file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    input.value = '';
                    preview.innerHTML = '<i class="fas fa-image text-gray-400"></i>';
                    return;
                }
                
                // Check file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file');
                    input.value = '';
                    preview.innerHTML = '<i class="fas fa-image text-gray-400"></i>';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="w-full h-full object-cover rounded-lg">`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<i class="fas fa-image text-gray-400"></i>';
            }
        }
    </script>
@endsection

@push('scripts')
    <script>
        function toggleDropdown() {
            document.getElementById('certificatesDropdown').classList.toggle('hidden');
        }
    </script>
@endpush

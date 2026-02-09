@extends('layouts.admin')

@section('title', 'Edit Minister')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Minister</h1>
        <p class="text-gray-600 mt-1">Update minister information</p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('admin.ministers.update', $minister) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Personal Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user mr-2 text-indigo-600"></i>
                    Personal Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               value="{{ old('name', $minister->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Title
                        </label>
                        <select id="title" 
                                name="title" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Title</option>
                            <option value="Rev. Fr." {{ old('title', $minister->title) == 'Rev. Fr.' ? 'selected' : '' }}>Rev. Fr.</option>
                            <option value="Most Rev." {{ old('title', $minister->title) == 'Most Rev.' ? 'selected' : '' }}>Most Rev.</option>
                            <option value="Rt. Rev." {{ old('title', $minister->title) == 'Rt. Rev.' ? 'selected' : '' }}>Rt. Rev.</option>
                            <option value="Very Rev." {{ old('title', $minister->title) == 'Very Rev.' ? 'selected' : '' }}>Very Rev.</option>
                            <option value="Rev." {{ old('title', $minister->title) == 'Rev.' ? 'selected' : '' }}>Rev.</option>
                            <option value="Fr." {{ old('title', $minister->title) == 'Fr.' ? 'selected' : '' }}>Fr.</option>
                            <option value="Deacon" {{ old('title', $minister->title) == 'Deacon' ? 'selected' : '' }}>Deacon</option>
                        </select>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-address-card mr-2 text-indigo-600"></i>
                    Contact Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email Address
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $minister->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number (11 digits)
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $minister->phone) }}"
                               placeholder="e.g., 09123456789"
                               maxlength="11"
                               pattern="[0-9]{11}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Assignment Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-church mr-2 text-indigo-600"></i>
                    Assignment Information
                </h3>
                <div class="space-y-6">
                    <div>
                        <label for="parish_assignment" class="block text-sm font-medium text-gray-700 mb-1">
                            Parish Assignment
                        </label>
                        <input type="text" 
                               id="parish_assignment" 
                               name="parish_assignment" 
                               value="{{ old('parish_assignment', $minister->parish_assignment) }}"
                               placeholder="e.g., St. Mary's Parish"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('parish_assignment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                            Address
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $minister->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-toggle-on mr-2 text-indigo-600"></i>
                    Status
                </h3>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="active" {{ old('status', $minister->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $minister->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.ministers.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Update Minister
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

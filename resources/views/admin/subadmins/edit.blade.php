@extends('layouts.admin')

@section('title', 'Edit Sub-administrator')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Sub-administrator</h1>
        <a href="{{ route('admin.subadmins.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
            <span>Back to List</span>
        </a>
    </div>

            <div class="bg-white rounded-lg shadow-sm max-w-2xl">
                <form action="{{ route('admin.subadmins.update', $subadmin) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $subadmin->name) }}" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $subadmin->email) }}" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parish_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Parish Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="parish_name" name="parish_name" value="{{ old('parish_name', $subadmin->parish_name) }}" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('parish_name') border-red-500 @enderror"
                                placeholder="e.g., Sto. Niño Parish">
                            @error('parish_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parish_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Parish Address <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="parish_address" name="parish_address" value="{{ old('parish_address', $subadmin->parish_address) }}" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('parish_address') border-red-500 @enderror"
                                placeholder="e.g., Panabo City, Davao del Norte, Philippines, 8105">
                            @error('parish_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <h2 class="text-lg font-medium text-gray-800 mb-1">Change Password</h2>
                            <p class="text-sm text-gray-600 mb-4">Leave password fields empty if you don't want to change it.</p>

                            <div class="space-y-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        New Password
                                    </label>
                                    <input type="password" id="password" name="password" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirm New Password
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('admin.subadmins.index') }}" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-center">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Update Sub-administrator
                        </button>
                    </div>
                </form>
            </div>
@endsection

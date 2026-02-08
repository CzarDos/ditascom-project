@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="header">
        <h2 class="text-2xl font-semibold">Sub-Administrator Management</h2>
        <a href="{{ route('admin.sub-admins.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Add New Sub-Admin
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subAdmins as $subAdmin)
                    <tr>
                        <td>{{ $subAdmin->name }}</td>
                        <td>{{ $subAdmin->email }}</td>
                        <td>{{ $subAdmin->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.sub-admins.edit', $subAdmin) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.sub-admins.destroy', $subAdmin) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this sub-admin?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.container {
    padding: 2rem;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 6px;
}

.alert-success {
    background-color: #e8f5e9;
    color: #4caf50;
    border: 1px solid #a5d6a7;
}

.card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
}

.card-body {
    padding: 1.5rem;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

th {
    font-weight: 600;
    color: var(--text-color);
}

.btn-edit, .btn-delete {
    padding: 0.5rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    margin-right: 0.5rem;
}

.btn-edit {
    background-color: #e3f2fd;
    color: #2196f3;
}

.btn-delete {
    background-color: #ffebee;
    color: #f44336;
}

.inline {
    display: inline-block;
}
</style>
@endsection 
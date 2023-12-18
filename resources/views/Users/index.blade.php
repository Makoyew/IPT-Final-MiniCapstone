@extends('base')

@include('navbar')

@section('content')
    <div class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="table-heading mt-4">Users</h2>
            </div>

            <div class="table-wrapper">
                <table class="custom-table">
                    <thead class="custom-thead">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="no-users-msg">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Add your custom styles here */

.table-container {
    margin-bottom: 2rem;
}

.table-heading {
    font-size: 1.5rem;
    font-weight: bold;
}

.create-user-btn {
    padding: 0.5rem 1rem;
    background-color: #3490dc;
    color: #fff;
    text-decoration: none;
    border-radius: 0.25rem;
    display: inline-block;
}

.table-wrapper {
    margin-top: 1rem;
    overflow-x: auto;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.custom-thead{
    background-color: rgb(173, 164, 164)
}

.custom-table th,
.custom-table td {
    padding: 0.75rem;
    text-align: center;
    border: 1px solid #e2e8f0;
}

.no-users-msg {
    text-align: center;
}

    </style>

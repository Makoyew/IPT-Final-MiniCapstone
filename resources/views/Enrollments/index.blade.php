<!-- resources/views/enrollments/index.blade.php -->

@extends('base')

@include('navbar')

@section('content')
    <div class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="table-heading mt-3">Enrollments</h2>
            </div>
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead class="custom-thead">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->id }}</td>
                                <td>{{ $enrollment->user->name }}</td>
                                <td>{{ $enrollment->course->title }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="no-enrollments-msg">No enrollments found.</td>
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

    .create-course-btn {
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

    .custom-thead {
        background-color: rgb(173, 164, 164)
    }

    .custom-table th,
    .custom-table td {
        padding: 0.75rem;
        text-align: center;
        border: 1px solid #e2e8f0;
    }

    .no-enrollments-msg {
        text-align: center;
    }
</style>

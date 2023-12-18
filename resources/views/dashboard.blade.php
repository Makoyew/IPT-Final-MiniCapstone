@extends('base')

@include('navbar')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 mt-5 justify-content-center">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Users</h5>
                    <p class="card-text text-center">{{ $userCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Enrollments</h5>
                    <p class="card-text text-center">{{ $enrollmentCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Courses</h5>
                    <p class="card-text text-center">{{ $courseCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h1 class="text-center mb-4">Welcome to the LMS Dashboard</h1>
                    <p class="lead text-center">Manage your courses, track enrollments, and stay informed with important updates.</p>

                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i>
                        Important information or updates can go here.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

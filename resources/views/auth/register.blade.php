@extends('base')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="background-color: #2c3e50; color: #fff;">
                    <h1>Register</h1>
                </div>
                <div class="card-body">
                    <form action="{{ '/register' }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name">
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                            @error('password')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm your password">
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ '/' }}" style="color: #2c3e50;">Already have an account?</a>
                                <button class="btn btn-primary mt-2" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

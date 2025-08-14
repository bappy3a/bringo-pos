@extends('layouts.auth')

@section('content')
    <div class="col-md-6 col-lg-5 col-xl-4 mt-5">
        <div class="card login-card rounded-4">
            <div class="card-body p-4 p-md-5">
                <h2 class="fw-bold mb-4 text-center">Welcome Back</h2>
                <form action="{{ route('login.post') }}" method="post">
                    @csrf
                    <div class="mb-3 position-relative">
                        <label class="form-label" for="email">Email address Or Username</label>
                        <input name="username" type="text" class="form-control ps-icon @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Email Or Username" required>
                        @error('username')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label" for="password">Password</label>
                        <input name="password" type="password" class="form-control ps-icon @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="small">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-brand w-100 mb-3">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
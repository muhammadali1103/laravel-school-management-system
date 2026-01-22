@extends('layouts.app')

@section('content')
<style>
    /* Reset & Base */
    body {
        background-color: #f3f4f6; /* Soft gray base */
        background-image: 
            radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
            radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
            radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        background-size: cover;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        margin: 0;
    }

    /* Container */
    .login-container {
        width: 100%;
        max-width: 420px;
        padding: 20px;
    }

    /* Card */
    .login-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 
            0 20px 25px -5px rgba(0, 0, 0, 0.1), 
            0 10px 10px -5px rgba(0, 0, 0, 0.04),
            0 0 0 1px rgba(0,0,0,0.03); /* Subtle border */
        overflow: hidden;
        position: relative;
    }

    /* Top Accent Line */
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #d946ef);
    }

    .login-header {
        padding: 40px 40px 20px 40px;
        text-align: center;
    }

    .logo-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: #4f46e5;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin: 0 auto 24px auto;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .login-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        letter-spacing: -0.025em;
    }

    .login-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }

    .login-body {
        padding: 0 40px 40px 40px;
    }

    /* Inputs */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #334155;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        font-size: 1rem;
        line-height: 1.5;
        color: #1e293b;
        background-color: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        transition: all 0.2s ease-in-out;
    }

    .form-control:focus {
        border-color: #6366f1;
        outline: 0;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    /* Button */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 14px 24px;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
        background: #4f46e5;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
    }

    .btn-submit:hover {
        background: #4338ca;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Checkbox & Link */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    .form-check-label {
        font-size: 0.875rem;
        color: #64748b;
        cursor: pointer;
    }

    .forgot-link {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4f46e5;
        text-decoration: none;
        transition: color 0.15s;
    }

    .forgot-link:hover {
        color: #4338ca;
        text-decoration: underline;
    }

    /* Alert */
    .alert-error {
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        color: #b91c1c;
        font-size: 0.875rem;
    }

    /* Hide default layout elements */
    .navbar, nav, footer { display: none !important; }
    main { padding: 0 !important; margin: 0 !important; }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="logo-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1>Welcome Back</h1>
            <p>Please enter your details to sign in.</p>
        </div>

        <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" value="{{ old('email') }}" 
                        required autocomplete="email" autofocus
                        placeholder="admin@school.com">
                    
                    @error('email')
                        <div class="mt-2 text-danger small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" required autocomplete="current-password"
                        placeholder="••••••••">

                    @error('password')
                        <div class="mt-2 text-danger small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="form-actions">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    Sign in
                </button>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <p class="text-muted small mb-0">&copy; {{ date('Y') }} School Management System</p>
    </div>
</div>
@endsection

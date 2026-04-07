@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('auth_body')
    <form action="{{ route('register') }}" method="POST">
        @csrf

        {{-- Name field --}}
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control"
                placeholder="{{ __('adminlte::adminlte.retype_password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('adminlte::adminlte.register') }}
        </button>
    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop

@push('css')
<link href="https://fonts.bunny.net/css?family=nunito:700,900" rel="stylesheet"/>
<style>
    /* ── Background teal ── */
    body.register-page {
        background-color: #0abfbc !important;
        background-image: none !important;
        overflow: hidden;
        font-family: 'Nunito', sans-serif;
    }

    body.register-page::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 70% 50%, rgba(255,255,255,0.10) 0%, transparent 70%),
            radial-gradient(ellipse 40% 40% at 20% 80%, rgba(255,255,255,0.08) 0%, transparent 60%);
        pointer-events: none;
        z-index: 0;
    }

    /* Cloud bottom */
    body.register-page::after {
        content: '';
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 120px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 120' preserveAspectRatio='none'%3E%3Cpath d='M0 80 Q80 40 160 70 Q240 100 320 60 Q400 20 480 60 Q560 100 640 70 Q720 40 800 65 Q880 90 960 60 Q1040 30 1120 60 Q1200 90 1280 65 Q1360 40 1440 70 L1440 120 L0 120 Z' fill='white' fill-opacity='0.18'/%3E%3Cpath d='M0 100 Q120 70 240 90 Q360 110 480 85 Q600 60 720 88 Q840 116 960 90 Q1080 64 1200 88 Q1320 112 1440 95 L1440 120 L0 120 Z' fill='white' fill-opacity='0.25'/%3E%3C/svg%3E");
        background-size: 100% 100%;
        pointer-events: none;
        z-index: 0;
    }

    /* Leaf decorations */
    .laundry-leaf-left {
        position: fixed;
        left: 20px;
        top: 60px;
        width: 110px;
        opacity: 0.45;
        pointer-events: none;
        z-index: 0;
        animation: leafSway 5s ease-in-out infinite;
    }

    .laundry-leaf-right {
        position: fixed;
        right: 20px;
        bottom: 80px;
        width: 80px;
        opacity: 0.4;
        pointer-events: none;
        z-index: 0;
        animation: leafSway 6s ease-in-out infinite reverse;
    }

    /* Bubbles */
    .laundry-bubble {
        position: fixed;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.5);
        pointer-events: none;
        z-index: 0;
        animation: bubbleFloat linear infinite;
    }

    @keyframes leafSway {
        0%, 100% { transform: rotate(-4deg); }
        50%       { transform: rotate(4deg); }
    }

    @keyframes bubbleFloat {
        0%   { transform: translateY(0);     opacity: 0.55; }
        100% { transform: translateY(-50px); opacity: 0; }
    }

    /* ── Card ── */
    .register-card-body,
    .card-body {
        background: rgba(255, 255, 255, 0.97) !important;
        border-radius: 16px !important;
        box-shadow: 0 20px 60px rgba(0, 80, 80, 0.25) !important;
    }

    .login-box-msg {
        color: #067070 !important;
        font-weight: 700 !important;
        font-size: 17px !important;
    }

    /* ── Input icons ── */
    .card .input-group-text {
        background-color: #0abfbc !important;
        border-color: #0abfbc !important;
        color: white !important;
    }

    .card .form-control:focus {
        border-color: #0abfbc !important;
        box-shadow: 0 0 0 0.2rem rgba(10, 191, 188, 0.25) !important;
    }

    /* ── Register button ── */
    .btn-primary {
        background-color: #0abfbc !important;
        border-color: #089a98 !important;
        font-weight: 700 !important;
        border-radius: 50px !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
    }

    .btn-primary:hover {
        background-color: #089a98 !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(10, 191, 188, 0.4) !important;
    }

    /* ── Footer link ── */
    .card-footer a {
        color: #0abfbc !important;
        font-weight: 600;
    }

    .card-footer a:hover {
        color: #067070 !important;
    }

    .login-box, .login-logo {
        position: relative;
        z-index: 1;
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;

    // ── Leaf left ──
    const leafLeft = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    leafLeft.setAttribute('viewBox', '0 0 130 200');
    leafLeft.setAttribute('fill', 'none');
    leafLeft.innerHTML = `
        <ellipse cx="50" cy="60" rx="28" ry="50" fill="white" fill-opacity="0.7" transform="rotate(-20 50 60)"/>
        <ellipse cx="80" cy="40" rx="20" ry="38" fill="white" fill-opacity="0.5" transform="rotate(15 80 40)"/>
        <ellipse cx="30" cy="120" rx="22" ry="42" fill="white" fill-opacity="0.6" transform="rotate(-30 30 120)"/>
        <ellipse cx="70" cy="100" rx="16" ry="32" fill="white" fill-opacity="0.4" transform="rotate(10 70 100)"/>
        <line x1="50" y1="110" x2="50" y2="200" stroke="white" stroke-opacity="0.5" stroke-width="2"/>
        <line x1="80" y1="78" x2="80" y2="150" stroke="white" stroke-opacity="0.4" stroke-width="1.5"/>
    `;
    leafLeft.classList.add('laundry-leaf-left');
    body.appendChild(leafLeft);

    // ── Leaf right ──
    const leafRight = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    leafRight.setAttribute('viewBox', '0 0 90 120');
    leafRight.setAttribute('fill', 'none');
    leafRight.innerHTML = `
        <ellipse cx="45" cy="50" rx="20" ry="40" fill="white" fill-opacity="0.6" transform="rotate(20 45 50)"/>
        <ellipse cx="65" cy="70" rx="15" ry="30" fill="white" fill-opacity="0.45" transform="rotate(-10 65 70)"/>
        <line x1="45" y1="90" x2="45" y2="120" stroke="white" stroke-opacity="0.5" stroke-width="2"/>
    `;
    leafRight.classList.add('laundry-leaf-right');
    body.appendChild(leafRight);

    // ── Bubbles ──
    const bubbles = [
        { size: 18, left: '10%',  bottom: '35%', duration: '3.5s', delay: '0s'   },
        { size: 12, left: '85%',  bottom: '25%', duration: '4.2s', delay: '1s'   },
        { size: 22, left: '20%',  bottom: '55%', duration: '5s',   delay: '0.5s' },
        { size: 10, left: '75%',  bottom: '60%', duration: '3s',   delay: '2s'   },
        { size: 16, left: '50%',  bottom: '15%', duration: '4s',   delay: '1.5s' },
        { size: 14, left: '60%',  bottom: '70%', duration: '3.8s', delay: '0.8s' },
        { size: 20, left: '35%',  bottom: '20%', duration: '4.5s', delay: '1.2s' },
    ];

    bubbles.forEach(b => {
        const el = document.createElement('div');
        el.classList.add('laundry-bubble');
        el.style.cssText = `
            width:${b.size}px; height:${b.size}px;
            left:${b.left}; bottom:${b.bottom};
            animation-duration:${b.duration};
            animation-delay:${b.delay};
        `;
        body.appendChild(el);
    });
});
</script>
@endpush
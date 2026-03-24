<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Food</title>

    <style>
        /* ===== Reset ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            transition: all .3s ease;
        }

        /* ===== BODY (WHITE BACKGROUND) ===== */
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            background-image:
                radial-gradient(circle at 20% 20%, #f3e8ff, transparent 40%),
                radial-gradient(circle at 80% 80%, #fde2f3, transparent 40%);
            overflow-x: hidden;
            position: relative;
        }

        /* ===== Background Blobs ===== */
        .blob {
            position: absolute;
            width: 20rem;
            height: 20rem;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .6;
            animation: blob 12s infinite;
        }

        .blob1 {
            background: #c084fc;
            top: -80px;
            left: -80px;
        }

        .blob2 {
            background: #60a5fa;
            bottom: -80px;
            right: -80px;
        }

        .blob3 {
            background: #f472b6;
            top: 50%;
            left: 60%;
        }

        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            25% {
                transform: translate(20px, -50px) scale(1.1);
            }

            50% {
                transform: translate(-20px, 20px) scale(.9);
            }

            75% {
                transform: translate(50px, 50px) scale(1.05);
            }
        }

        /* ===== Login Card ===== */
        .card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
            padding: 3rem 2rem;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(15px);
            border-radius: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .15);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, .2);
        }

        /* ===== Logo ===== */
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .2);
        }

        .logo-container img:hover {
            transform: scale(1.1) rotate(6deg);
        }

        /* ===== Header ===== */
        .card h2 {
            font-size: 2rem;
            text-align: center;
            background: linear-gradient(90deg, #7c3aed, #9333ea, #ec489a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card p {
            text-align: center;
            color: #555;
            font-size: .9rem;
            margin-bottom: 2rem;
        }

        /* ===== Form ===== */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: .5rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: .75rem 1rem;
            padding-left: 2.5rem;
            border-radius: 1rem;
            border: 2px solid #ddd;
            font-size: .95rem;
            outline: none;
        }

        .form-group input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, .2);
        }

        .form-group svg {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        /* ===== Options ===== */
        .form-options {
            display: flex;
            justify-content: space-between;
            font-size: .85rem;
            margin-bottom: 1.5rem;
        }

        .form-options a {
            color: #7c3aed;
            text-decoration: none;
        }

        /* ===== Button ===== */
        .btn-login {
            width: 100%;
            padding: .75rem;
            font-weight: 600;
            border-radius: 1rem;
            border: none;
            cursor: pointer;
            color: white;
            background: linear-gradient(90deg, #7c3aed, #9333ea, #ec489a);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .25);
        }

        /* ===== Divider ===== */
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #ccc;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .divider span {
            background: #fff;
            padding: 0 .5rem;
        }

        /* ===== Register ===== */
        .register-link {
            text-align: center;
            font-size: .85rem;
        }

        .register-link a {
            font-weight: 600;
            background: linear-gradient(90deg, #7c3aed, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        /* ===== Success Message ===== */
        .success-message {
            background: #dcfce7;
            border: 1px solid #22c55e;
            color: #16a34a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }

        /* ===== Error Message ===== */
        .error-message {
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        /* ===== Floating Food Icons ===== */
        .food-icon {
            position: absolute;
            font-size: 3rem;
            opacity: .2;
            animation: float 6s ease-in-out infinite;
        }

        .food-icon.delay1 {
            animation-delay: 1s;
        }

        .food-icon.delay2 {
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* ===== Responsive ===== */
        @media(max-width:480px) {
            .card {
                padding: 2rem 1.5rem;
            }

            .card h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Background blobs -->
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
    <div class="blob blob3"></div>

    <!-- Login Card -->
    <div class="card">

        <div class="logo-container">
            <img src="https://i.pinimg.com/1200x/53/0d/19/530d192bcc98fab1594a08888acf7acf.jpg">
        </div>

        <h2>សូមស្វាគមន៍</h2>
        <p>ចូលប្រើដើម្បីបន្តការទិញទំនិញ</p>

        @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
            <p style="margin:0;">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>អ៊ីមែល</label>
                <input type="email" name="email" required placeholder="you@example.com">
            </div>

            <div class="form-group">
                <label>ពាក្យសម្ងាត់</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>

            <div class="form-options">
                <label><input type="checkbox"> ចងចាំខ្ញុំ</label>
            </div>

            <button class="btn-login">ចូលប្រើ</button>

            <div class="divider"><span>ឬ</span></div>

            <!-- Google Login Button -->
            <a href="{{ route('auth.google') }}" style="text-decoration: none;">
                <button type="button" style="
                    width: 100%;
                    padding: 0.75rem;
                    font-weight: 600;
                    border-radius: 1rem;
                    border: 2px solid #ddd;
                    cursor: pointer;
                    background: white;
                    color: #333;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 10px;
                ">
                    <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    ចូលប្រើដោយប្រើ Google
                </button>
            </a>

            <div class="register-link">
                មិនទាន់មានគណនី?
                <a href="{{ route('register') }}">ចុះឈ្មោះឥឡូវ</a>
            </div>

        </form>
    </div>

    <!-- Floating Icons -->
    <div class="food-icon" style="bottom:10px;left:10px;">🍕</div>
    <div class="food-icon delay1" style="top:80px;right:20px;">🍜</div>
    <div class="food-icon delay2" style="bottom:150px;right:50px;">🍰</div>

</body>

</html>

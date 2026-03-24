<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<style>

/* ===============================
   RESET
================================*/
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

/* ===============================
   BACKGROUND
================================*/
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(-45deg,#c7d2fe,#e9d5ff,#fbcfe8,#dbeafe);
    background-size:300% 300%;
    animation:bgMove 12s ease infinite;
}

@keyframes bgMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

/* ===============================
   CARD
================================*/
.card{
    width:100%;
    max-width:420px;
    background:rgba(255,255,255,0.92);
    backdrop-filter:blur(12px);
    border-radius:18px;
    padding:35px 28px;
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
    animation:fadeUp .8s ease;
}

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ===============================
   BACK BUTTON
================================*/
.back{
    text-decoration:none;
    color:#4f46e5;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    margin-bottom:20px;
    transition:.3s;
}

.back:hover{
    color:#312e81;
}

/* ===============================
   LOGO
================================*/
.logo{
    display:flex;
    justify-content:center;
    margin-bottom:18px;
}

.logo img{
    width:85px;
    height:85px;
    border-radius:50%;
    box-shadow:0 8px 18px rgba(0,0,0,.2);
    transition:.4s;
}

.logo img:hover{
    transform:scale(1.1) rotate(4deg);
}

/* ===============================
   TITLE
================================*/
.title{
    text-align:center;
    margin-bottom:25px;
}

.title h2{
    font-size:32px;
    font-weight:800;
    background:linear-gradient(90deg,#6366f1,#a855f7,#ec4899);
    -webkit-background-clip:text;
    color:transparent;
}

.title p{
    color:#555;
    margin-top:6px;
}

/* ===============================
   INPUT
================================*/
.form-group{
    margin-bottom:18px;
}

label{
    font-size:14px;
    font-weight:600;
}

input{
    width:100%;
    margin-top:6px;
    padding:12px;
    border-radius:10px;
    border:1px solid #ddd;
    transition:.3s;
    font-size:15px;
}

input:focus{
    outline:none;
    border-color:#6366f1;
    box-shadow:0 0 0 3px rgba(99,102,241,.2);
}

/* ===============================
   FOOTER
================================*/
.form-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:15px;
}

.form-footer a{
    font-size:14px;
    color:#555;
    text-decoration:none;
}

.form-footer a:hover{
    text-decoration:underline;
}

/* ===============================
   BUTTON
================================*/
button{
    border:none;
    padding:12px 20px;
    border-radius:10px;
    color:white;
    font-weight:600;
    cursor:pointer;
    background:linear-gradient(90deg,#6366f1,#a855f7);
    transition:.3s;
}

button:hover{
    transform:scale(1.05);
    box-shadow:0 8px 20px rgba(99,102,241,.4);
}

/* ===============================
   ERROR MESSAGES
================================*/
.error-message{
    background:#fee2e2;
    border:1px solid #ef4444;
    color:#dc2626;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    font-size:14px;
}

.error-message ul{
    margin:0;
    padding-left:20px;
}

.error-message li{
    margin-top:4px;
}

.success-message{
    background:#dcfce7;
    border:1px solid #22c55e;
    color:#16a34a;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    font-size:14px;
}

.input-error{
    border-color:#ef4444 !important;
}

.input-error:focus{
    box-shadow:0 0 0 3px rgba(239,68,68,.2) !important;
}

</style>
</head>

<body>

<div class="card">

    <!-- Back -->
    <a href="{{ route('login') }}" class="back">← Back</a>

    <!-- Logo -->
    <div class="logo">
        <img src="https://i.pinimg.com/1200x/53/0d/19/530d192bcc98fab1594a08888acf7acf.jpg">
    </div>

    <!-- Title -->
    <div class="title">
        <h2>ចុះឈ្មោះ</h2>
        <p>បង្កើតគណនីថ្មីរបស់អ្នក</p>
    </div>

    <!-- FORM -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if($errors->any())
        <div class="error-message">
            <strong>⚠️ មានកំហុសក្នុងការបំពេញទិន្នន័យ</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
        @endif

        <div class="form-group">
            <label>Name <span style="color:#ef4444">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email <span style="color:#ef4444">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="{{ $errors->has('email') ? 'input-error' : '' }}" required>
        </div>

        <div class="form-group">
            <label>Password <span style="color:#ef4444">*</span></label>
            <input type="password" name="password"
                   class="{{ $errors->has('password') ? 'input-error' : '' }}"
                   minlength="8" required>
            <small style="color:#666;font-size:12px;">យ៉ាងតិច ៨ តួអក្សរឡើង</small>
        </div>

        <div class="form-group">
            <label>Confirm Password <span style="color:#ef4444">*</span></label>
            <input type="password" name="password_confirmation"
                   class="{{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                   minlength="8" required>
        </div>

        <div class="form-footer">
            <a href="{{ route('login') }}">Already registered?</a>
            <button type="submit">Register</button>
        </div>

    </form>

</div>

</body>
</html>

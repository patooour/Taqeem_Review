<html>
<head>

    <link rel="stylesheet" href="{{asset('assets/login/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/login/css/font-awesome.min.css')}}">
    <title>Login</title>
</head>
<body>

<div style="margin-top: 300px;"></div>
<img src="{{asset('assets/login/imgs/logo.jpeg')}}">
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="/doRegister" class="form1" method="POST">
            @csrf
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fa fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fa fa-google" aria-hidden="true"></i></a>
                <a href="#" class="social"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>
            <span>or use your email for registration</span>
            <input type="hidden" placeholder="id"  value="" name="id" />
            <input type="text" placeholder="firstname" value="{{old('firstname')}}" name="firstname" />
            <input type="text" placeholder="lastname" value="{{old('lastname')}}"  name="lastname"/>
            <input type="text" placeholder="username" value="{{old('username')}}"  name="username"/>
            <input type="email" placeholder="email" value="{{old('email')}}"   name="email"/>
            <input type="password" placeholder="Password" name="password"/>
            <button type="submit">Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="/doLogin" class="form1" method="POST">
            @csrf
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fa fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fa fa-google" aria-hidden="true"></i></a>
                <a href="#" class="social"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>
            <span>or use your account</span>
            <input type="email" placeholder="email" value="{{old('email')}}" name="email"/>
            <input type="password" placeholder="Password" name="password"/>
            <a href="#">Forgot your password?</a>
            <button type="submit">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 250px;"></div>

<script src="{{asset('assets/login/js/main.js')}}"></script>
</body>
</html>

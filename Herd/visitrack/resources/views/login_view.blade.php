<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitrack - Login</title>
    <link rel="stylesheet" href="/styles/login.css">
    <link rel="stylesheet" href="/styles/partials.css">
</head>



<body>
    <!-- NAV BAR -->
     @include('partials/nav')
    <div class="main-container">
        <div class="building-container">
            <img src="/resources/styles/img/building.png" alt="Building" class="building-img">
        </div>

        <div class="form-container">
            <div class="logo">visitrack</div>
            <div class="tagline">Know your safe</div>

            <div class="login-form">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username:" required>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password:" required>
                </div>

                <button type="submit" class="login-btn">Log In</button>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <a href="/registration.php">
                    <button type="button" class="register-btn">Register</button>
                </a>

            </div>

            <div class="footer-text">Create a peaceful environment.</div>
        </div>
    </div>

</body>

<!-- FOOTER -->

@include('partials.footer')

</html>
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
    <?php require __DIR__ . "/partials/nav.php";?>
    <div class="main-container">
        <div class="building-container">
            <img src="/styles/img/building.png" alt="Building" class="building-img">
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

                <button type="button" class="register-btn">Register</button>
            </div>

            <div class="footer-text">Create a peaceful environment.</div>
        </div>
    </div>

</body>

<!-- FOOTER -->

<?php require __DIR__ . "/partials/footer.php";?>

</html>
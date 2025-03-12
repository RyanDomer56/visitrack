<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="/styles/index.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Register</h1>
        </div>
        <div class="form-container">
            <h2>New User?</h2>
            <p class="form-description">Use the form below to create your account</p>

            <form id="registrationForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name: <span class="required">*</span></label>
                        <input type="text" id="firstName" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address: <span class="required">*</span></label>
                        <input type="text" id="address" name="address" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="middleName">Middle Name: (Optional)</label>
                        <input type="text" id="middleName" name="middleName">
                    </div>
                    <div class="form-group">
                        <label for="username">Username: <span class="required">*</span></label>
                        <input type="text" id="username" name="username" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="lastName">Last Name: <span class="required">*</span></label>
                        <input type="text" id="lastName" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Sex: <span class="required">*</span></label>
                        <div class="radio-group">
                            <label for="male">
                                <input type="radio" id="male" name="sex" value="male" required> Male
                            </label>
                            <label for="female">
                                <input type="radio" id="female" name="sex" value="female"> Female
                            </label>
                            <label for="others">
                                <input type="radio" id="others" name="sex" value="others"> Others
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <span class="required">*</span></label>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="birthDate">Birth Date: <span class="required">*</span></label>
                        <input type="date" id="birthDate" name="birthDate" required>
                    </div>
                    <div class="form-group">
                        <label for="repeatPassword">Repeat Password: <span class="required">*</span></label>
                        <input type="password" id="repeatPassword" name="repeatPassword" required>
                    </div>
                </div>

                <div class="form-buttons">
                    <a href="/login.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <button type="submit" class="btn-register">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gr5 Ecommarce</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-page">

    <?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);


    


require_once 'db.php';
    


      if (isset($_SESSION['username'])) {
            header("Location: my.php");
            exit;
        }


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['formType'] === 'loginF') {
        $email = $_POST['email'];
        $password = $_POST['password'];

         if (empty($email) || empty($password)) {
            die("Email and password are required.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format.");
        }

        $sql = "SELECT * FROM customer WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            
            if (password_verify($password, $row['password'])) {
                // Login success
                $_SESSION['username'] = $row['username'];
                
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['fname'] = $row['first_name'];
                $_SESSION['lname'] = $row['last_name'];
                // echo "Login successful! Welcome, " . htmlspecialchars($row['username']);
                
                header("Location: my.php");
                exit;
            } else {
                // echo "Invalid password.";

                echo "<script>alert('Invalid password/username combo') </script>";
            }
        } else {
            echo "<script>alert('No account found with that email.') </script>";
            // echo "No account found with that email.";
            
        }


    

    } elseif ($_POST['formType'] === 'registerF') {
        $firstName       = $_POST['firstName'];
        $username        = $_POST['username'];
        $lastName        = $_POST['lastName'];
        $phone           = $_POST['Pnum'];
        $city            = $_POST['City'];
        $postal       = $_POST['Postacode'];
        $country     = $_POST['Country'];
        $email           = $_POST['email'];
        $password        = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        // $cardNumber     = $_POST['cardNumber'];
        // $cardholderName = $_POST['cardholderName'];
        // $cvv            = $_POST['cvv'];

    // Credit card fields (name="cardNumber")
    $cardNumber      = isset($_POST['cardNumber']) ? trim($_POST['cardNumber']) : null;
    $cardholderName  = isset($_POST['cardholderName']) ? trim($_POST['cardholderName']) : null;
    $cvv             = isset($_POST['cvv']) ? trim($_POST['cvv']) : null;


    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $checkSql = "SELECT id FROM customer WHERE email = ? OR username = ?";
    $stmt = mysqli_prepare($conn, $checkSql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        die("Email or Username already exists.");
    }
    mysqli_stmt_close($stmt);


    $sql = "INSERT INTO customer 
        (email, password, first_name, last_name, username, phone, city, postal_code, country_code, 
         card_number, card_cvv, billing_name) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssss",
        $email,
        $hashedPassword,
        $firstName,
        $lastName,
        $username,
        $phone,
        $city,
        $postal,
        $country,
        $cardNumber,
        $cvv,
        $cardholderName
    );

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['fname'] = $firstName;
        $_SESSION['lname'] = $lastName;
        // echo "Registration successful! Welcome, " . htmlspecialchars($username);
        header("Location: my.php"); exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);


    
    // if (empty($firstName) || empty($username) || empty($lastName) || empty($phone) ||
    //     empty($city) || empty($postal) || empty($country) || empty($email) ||
    //     empty($password) || empty($confirmPassword)) {
    //     die("All fields are required.");
    // }

    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     die("Invalid email format.");
    // }

    // if ($password !== $confirmPassword) {
    //     die("Passwords do not match.");
    // }

    
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

 
    // $checkSql = "SELECT id FROM users WHERE email = ? OR username = ?";
    // $stmt = mysqli_prepare($conn, $checkSql);
    // mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    // mysqli_stmt_execute($stmt);
    // mysqli_stmt_store_result($stmt);

    // if (mysqli_stmt_num_rows($stmt) > 0) {
    //     die("Email or Username already exists.");
    // }
    // mysqli_stmt_close($stmt);

    
    // $sql = "INSERT INTO users (firstName, username, lastName, phone, city, postal, country, email, password) 
    //         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    // $stmt = mysqli_prepare($conn, $sql);
    // mysqli_stmt_bind_param($stmt, "sssssssss", 
    //     $firstName, $username, $lastName, $phone, $city, $postal, $country, $email, $hashedPassword);

    // if (mysqli_stmt_execute($stmt)) {
    //     // Registration successful
    //     $_SESSION['user'] = $username;
    //     echo "Registration successful! Welcome, " . htmlspecialchars($username);
    //     // Optionally redirect:
    //     // header("Location: dashboard.php");
    //     // exit;
    // } else {
    //     echo "Error: " . mysqli_error($conn);
    // }

    // mysqli_stmt_close($stmt);




        

    }
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

//     header('Content-Type: application/json');

//     function response($success, $message, $extra = []) {
//         echo json_encode(array_merge([
//             'success' => $success,
//             'message' => $message
//         ], $extra));
//         exit;
//     }

//     $action = $_POST['action'];

//     /* ===== REGISTER ===== */
//     if ($action === 'register') {

//         $firstName = trim($_POST['firstName'] ?? '');
//         $lastName  = trim($_POST['lastName'] ?? '');
//         $username  = trim($_POST['username'] ?? '');
//         $phone     = trim($_POST['Pnum'] ?? '');
//         $city      = trim($_POST['City'] ?? '');
//         $postal    = trim($_POST['Postacode'] ?? '');
//         $country   = trim($_POST['Country'] ?? '');
//         $email     = trim($_POST['email'] ?? '');
//         $password  = $_POST['password'] ?? '';
//         $confirm   = $_POST['confirmPassword'] ?? '';
//         echo $firstName;
//         if (
//             !$firstName || !$lastName || !$username ||
//             !$email || !$password || !$confirm
//         ) {
//             response(false, 'All required fields must be filled');
//         }

//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             response(false, 'Invalid email address');
//         }

//         if ($password !== $confirm) {
//             response(false, 'Passwords do not match');
//         }

//         // Check email
//         $check = mysqli_prepare($conn, "SELECT id FROM customer WHERE email = ?");
//         mysqli_stmt_bind_param($check, "s", $email);
//         mysqli_stmt_execute($check);
//         mysqli_stmt_store_result($check);

//         if (mysqli_stmt_num_rows($check) > 0) {
//             response(false, 'Email already registered');
//         }

//         $hash = password_hash($password, PASSWORD_DEFAULT);

//         $stmt = mysqli_prepare($conn, "
//             INSERT INTO customer
//             (email, password, first_name, last_name, username, phone, city, postal_code, country_code)
//             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
//         ");

//         mysqli_stmt_bind_param(
//             $stmt,
//             "sssssssss",
//             $email,
//             $hash,
//             $firstName,
//             $lastName,
//             $username,
//             $phone,
//             $city,
//             $postal,
//             $country
//         );

//         if (!mysqli_stmt_execute($stmt)) {
//             response(false, 'Registration failed');
//         }

//         $_SESSION['user_id'] = mysqli_insert_id($conn);
//         $_SESSION['email']   = $email;

//         response(true, 'Account created successfully');
//     }

//     /* ===== LOGIN ===== */
//     if ($action === 'login') {

//         $email    = trim($_POST['email'] ?? '');
//         $password = $_POST['password'] ?? '';

//         $stmt = mysqli_prepare($conn, "
//             SELECT id, password, first_name
//             FROM customer
//             WHERE email = ?
//             LIMIT 1
//         ");

//         mysqli_stmt_bind_param($stmt, "s", $email);
//         mysqli_stmt_execute($stmt);
//         $result = mysqli_stmt_get_result($stmt);

//         if (!$user = mysqli_fetch_assoc($result)) {
//             response(false, 'Invalid email or password');
//         }

//         if (!password_verify($password, $user['password'])) {
//             response(false, 'Invalid email or password');
//         }

//         $_SESSION['user_id'] = $user['id'];
//         $_SESSION['email']   = $email;
//         $_SESSION['name']    = $user['first_name'];

//         response(true, 'Login successful');
//     }

//     response(false, 'Unknown action');
// }
?>
    <!-- Notch -->
    <div class="notch-container">
        <div class="notch">
            <div class="notch-time">12:30</div>
            <div class="notch-icons">
                <a href="https://www.google.com/maps" 
                     class="notch-map-link" 
                     target="_blank" 
                     rel="noopener" 
                     aria-label="Open Google Maps">
                    <i class="fas fa-compass" style="color: white;"></i>
                  </a>
                <div class="notch-time">24/7</div>

            </div>
        </div>
    </div>

    <!-- Auth Background -->
    <div class="auth-background">
        <div class="auth-glow"></div>
    </div>

    <!-- Auth Container -->
    <div class="auth-container">
        <div class="auth-header">
            <a href="index.html" class="auth-logo">Gr5 <span>Ecommarce</span></a>
            <h1>Welcome Back</h1>
            <p>Sign in to your account to continue</p>
        </div>

        <div class="auth-tabs">
            <button class="auth-tab active" data-tab="login">Sign In</button>
            <button class="auth-tab" data-tab="register">Create Account</button>
        </div>

        <!-- Login Form -->
        <form class="auth-form active" id="loginForm" method="POST" action="/loginReg.php">
            <input type="hidden" name="formType" value="loginF">

            <div class="form-group">
                <label for="loginEmail">Email Address</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="loginEmail" name="email" placeholder="Enter your email" required>
                </div>
                <div class="error-message" id="loginEmailError"></div>
            </div>

            <div class="form-group">
                <label for="loginPassword">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-password" data-target="loginPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="error-message" id="loginPasswordError"></div>
            </div>

            <div class="form-options">
                <label class="checkbox">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Remember me
                </label>
                <a href="/admin/staff.php" class="forgot-link">Are You Stuff?</a>
            </div>

            <button type="submit" class="btn btn-primary btn-full auth-submit">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </button>

            <div class="auth-divider">
                <span>or continue with</span>
            </div>

            <div class="social-auth">
                <button type="button" class="social-btn google" onclick="alert('Feature Not Avilale Right Now')">
                    <i class="fab fa-google"></i>
                    Google
                </button>
                <button type="button" class="social-btn apple" onclick="alert('Feature Not Avilale Right Now')">
                    <i class="fab fa-apple"></i>
                    Apple
                </button>
                <button type="button" class="social-btn facebook" onclick="alert('Feature Not Avilale Right Now')">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </button>
            </div>

            <div class="auth-footer">
                Don't have an account? <a href="#" class="switch-to-register">Sign up</a>
            </div>
        </form>

        <!-- Register Form -->
        <form class="auth-form" id="registerForm" method="POST" action="/loginReg.php">
            <input type="hidden" name="formType" value="registerF">

            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="firstName" name="firstName" placeholder="First name" required>
                    </div>
                    <div class="error-message" id="firstNameError"></div>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="error-message" id="firstNameError"></div>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="lastName" name="lastName" placeholder="Last name" required>
                    </div>
                    <div class="error-message" id="lastNameError"></div>
                </div>
                <!-- New Added -->
                <div class="form-group">
                    <label for="PhoneNumber">Phone Number</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="Pnum" name="Pnum" placeholder="Phone Number" required>
                    </div>
                    <div class="error-message" id="PnumError"></div>
                </div>

                <div class="form-group">
                    <label for="City">City</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="City" name="City" placeholder="City" required>
                    </div>
                    <div class="error-message" id="CityError"></div>
                </div>

                <div class="form-group">
                    <label for="lastName">Posta Code</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="Postacode" name="Postacode" placeholder="Posta Code " required>
                    </div>
                    <div class="error-message" id="lastNameError"></div>
                </div>
                 <div class="form-group">
                    <label for="Country">Country Code</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="Country" name="Country" placeholder="Country Code " maxlength="2" required>
                    </div>
                    <div class="error-message" id="lastNameError"></div>
                </div>




                <!-- <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <div class="input-with-icon">
                        <i class="far fa-credit-card"></i>
                        <input type="text" name="cardNumber" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    <div class="card-icons">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-discover"></i>
                    </div>
                </div>
                
               

                <div class="form-group">
                     <div class="input-with-icon">
                       <label for="cardholderName">Cardholder Name</label>
                                <input type="text" name="cardholderName" id="cardholderName" placeholder="CardHolder Name">
                    </div>
                </div>

                <div class="form-group">
                     <div class="input-with-icon">
                       <label for="cardholderName">CVV</label>
                               <input type="text" name="cvv" id="cvv" placeholder="123" maxlength="4">
                    </div>
                </div>
 -->
                <!-- 
                 <div class="form-row">
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date</label>
                        <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <div class="input-with-icon">
                            <input type="text" id="cvv" placeholder="123" maxlength="4">
                            <button type="button" class="cvv-help" title="3-digit code on back of card">
                                <i class="fas fa-question-circle"></i>
                            </button>
                        </div>
                    </div> -->

             




                <!-- New Added End -->


            </div>

            <div class="form-group">
                <label for="registerEmail">Email Address</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="registerEmail" name="email" placeholder="Enter your email" required>
                </div>
                <div class="error-message" id="registerEmailError"></div>
            </div>

            <div class="form-group">
                <label for="registerPassword">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="registerPassword" name="password" placeholder="Create a password" required>
                    <button type="button" class="toggle-password" data-target="registerPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="passwordStrength"></div>
                    </div>
                    <span class="strength-text" id="passwordStrengthText">Weak</span>
                </div>
                <div class="error-message" id="registerPasswordError"></div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    <button type="button" class="toggle-password" data-target="confirmPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="error-message" id="confirmPasswordError"></div>
            </div>

            <div class="form-options">
                <label class="checkbox">
                    <input type="checkbox" name="newsletter" checked>
                    <span class="checkmark"></span>
                    Subscribe to our newsletter for exclusive offers
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="terms" required>
                    <span class="checkmark"></span>
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-full auth-submit">
                <i class="fas fa-user-plus"></i>
                Create Account
            </button>

            <div class="auth-divider">
                <span>or continue with</span>
            </div>

            <div class="social-auth">
                <button type="button" class="social-btn google" onclick="alert('Feature Not Avilale Right Now')">
                    <i class="fab fa-google"></i>
                    Google
                </button>
                <button type="button" class="social-btn apple" onclick="alert('Feature Not Avilale Right Now')">
                    <i class="fab fa-apple"></i>
                    Apple
                </button>
                <button type="button" class="social-btn facebook" onclick="alert('Feature Not Avilale Right Now')">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </button>
            </div>

            <div class="auth-footer">
                Already have an account? <a href="#" class="switch-to-login">Sign in</a>
            </div>
        </form>
    </div>

    <script src="app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeAuthPage();

            // document.getElementById('loginForm').addEventListener('submit', function (e) {
            //     e.preventDefault();
            //     handleLogin(this);
            // });

            // document.getElementById('registerForm').addEventListener('submit', function (e) {
            //     e.preventDefault();
            //     handleRegistration(this);
            // });
        });
        // document.getElementById('loginForm').addEventListener('submit', e => {
        //     e.preventDefault();
        //     const formData = new FormData(e.target);
        //     formData.append('action', 'login');

        //     fetch('loginReg.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(r => r.json())
        //     .then(d => {
        //         if (!d.success) return showNotification(d.message, 'error');
        //         showNotification('Logged in successfully');
        //         window.location.href = 'my.php';
        //     });
        // });

        // document.getElementById('registerForm').addEventListener('submit', e => {
        //     e.preventDefault();
        //     const formData = new FormData(e.target);
        //     formData.append('action', 'register');

        //     fetch('loginReg.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(r => r.json())
        //     .then(d => {
        //         if (!d.success) return showNotification(d.message, 'error');
        //         showNotification('Account created successfully');
        //         window.location.href = 'my.php';
        //     });
        // });
         const cardNumberInput = document.getElementById('cardNumber');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let matches = value.match(/\d{4,16}/g);
                    let match = matches && matches[0] || '';
                    let parts = [];
                    
                    for (let i = 0; i < match.length; i += 4) {
                        parts.push(match.substring(i, i + 4));
                    }
                    
                    if (parts.length) {
                        e.target.value = parts.join(' ');
                    } else {
                        e.target.value = value;
                    }
                });
            }

            const expiryInput = document.getElementById('expiryDate');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }

        function initializeAuthPage() {
            // Tab switching
            const tabs = document.querySelectorAll('.auth-tab');
            const forms = document.querySelectorAll('.auth-form');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update active form
                    forms.forEach(form => form.classList.remove('active'));
                    document.getElementById(targetTab + 'Form').classList.add('active');
                });
            });

            // Switch between login/register links
            document.querySelector('.switch-to-register').addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('[data-tab="register"]').click();
            });

            document.querySelector('.switch-to-login').addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('[data-tab="login"]').click();
            });

            // Password visibility toggle
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Password strength indicator
            const passwordInput = document.getElementById('registerPassword');
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    updatePasswordStrength(this.value);
                });
            }

            // Form submissions
            // document.getElementById('loginForm').addEventListener('submit', function(e) {
            //     e.preventDefault();
            //     handleLogin(this);
            // });

            // document.getElementById('registerForm').addEventListener('submit', function(e) {
            //     e.preventDefault();
            //     handleRegistration(this);
            // });
        }

        function updatePasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordStrengthText');
            
            let strength = 0;
            let text = 'Weak';
            let width = '25%';
            let color = '#ff4757';
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;
            
            switch(strength) {
                case 1:
                    text = 'Weak';
                    width = '25%';
                    color = '#ff4757';
                    break;
                case 2:
                    text = 'Fair';
                    width = '50%';
                    color = '#ffa502';
                    break;
                case 3:
                    text = 'Good';
                    width = '75%';
                    color = '#2ed573';
                    break;
                case 4:
                    text = 'Strong';
                    width = '100%';
                    color = '#2ed573';
                    break;
            }
            
            strengthBar.style.width = width;
            strengthBar.style.backgroundColor = color;
            strengthText.textContent = text;
            strengthText.style.color = color;
        }

        // function handleLogin(form) {
        //     const formData = new FormData(form);
        //     const email = formData.get('email');
        //     const password = formData.get('password');
            
        //     // Basic validation
        //     let isValid = true;
            
        //     if (!email || !isValidEmail(email)) {
        //         showError('loginEmailError', 'Please enter a valid email address');
        //         isValid = false;
        //     } else {
        //         clearError('loginEmailError');
        //     }
            
        //     if (!password || password.length < 6) {
        //         showError('loginPasswordError', 'Password must be at least 6 characters');
        //         isValid = false;
        //     } else {
        //         clearError('loginPasswordError');
        //     }
            
        //     if (isValid) {
        //         // Simulate API call
        //         const submitBtn = form.querySelector('.auth-submit');
        //         const originalText = submitBtn.innerHTML;
                
        //         submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
        //         submitBtn.disabled = true;
                
        //         setTimeout(() => {
        //             showNotification('Successfully signed in!');
        //             window.location.href = 'account-dashboard.html';
        //         }, 1500);
        //     }
        // }

        // function handleRegistration(form) {
        //     const formData = new FormData(form);
        //     const firstName = formData.get('firstName');
        //     const lastName = formData.get('lastName');
        //     const email = formData.get('email');
        //     const password = formData.get('password');
        //     const confirmPassword = formData.get('confirmPassword');
        //     const terms = formData.get('terms');
            
        //     let isValid = true;
            
        //     // Validation logic would go here
        //     // For demo purposes, we'll just show success
        //     const submitBtn = form.querySelector('.auth-submit');
        //     const originalText = submitBtn.innerHTML;
            
        //     submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
        //     submitBtn.disabled = true;
            
        //     setTimeout(() => {
        //         showNotification('Account created successfully!');
        //         window.location.href = 'account-dashboard.html';
        //     }, 1500);
        // }

        // function handleLogin(form) {
        //     const formData = new FormData(form);
        //     formData.append('action', 'login');

        //     const email = formData.get('email');
        //     const password = formData.get('password');

        //     let isValid = true;

        //     if (!email || !isValidEmail(email)) {
        //         showError('loginEmailError', 'Please enter a valid email address');
        //         isValid = false;
        //     } else {
        //         clearError('loginEmailError');
        //     }

        //     if (!password || password.length < 6) {
        //         showError('loginPasswordError', 'Password must be at least 6 characters');
        //         isValid = false;
        //     } else {
        //         clearError('loginPasswordError');
        //     }

        //     if (!isValid) return;

        //     const submitBtn = form.querySelector('.auth-submit');
        //     const originalText = submitBtn.innerHTML;

        //     submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
        //     submitBtn.disabled = true;

        //     fetch('auth.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(res => res.json())
        //     .then(data => {
        //         if (!data.success) {
        //             showNotification(data.message, 'error');
        //             submitBtn.innerHTML = originalText;
        //             submitBtn.disabled = false;
        //             return;
        //         }

        //         showNotification('Successfully signed in!');
        //         window.location.href = 'my.php';
        //     })
        //     .catch(() => {
        //         showNotification('Server error. Please try again.', 'error');
        //         submitBtn.innerHTML = originalText;
        //         submitBtn.disabled = false;
        //     });
        // }

      
        // function handleRegistration(form) {
        //     const formData = new FormData(form);
        //     formData.append('action', 'register');

        //     const password = formData.get('password');
        //     const confirm  = formData.get('confirmPassword');

        //     let isValid = true;

        //     if (password !== confirm) {
        //         showError('confirmPasswordError', 'Passwords do not match');
        //         isValid = false;
        //     } else {
        //         clearError('confirmPasswordError');
        //     }

        //     if (!isValid) return;

        //     const submitBtn = form.querySelector('.auth-submit');
        //     const originalText = submitBtn.innerHTML;

        //     submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
        //     submitBtn.disabled = true;

        //     fetch('auth.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(res => res.json())
        //     .then(data => {
        //         if (!data.success) {
        //             showNotification(data.message, 'error');
        //             submitBtn.innerHTML = originalText;
        //             submitBtn.disabled = false;
        //             return;
        //         }

        //         showNotification('Account created successfully!');
        //         window.location.href = 'my.php';
        //     })
        //     .catch(() => {
        //         showNotification('Server error. Please try again.', 'error');
        //         submitBtn.innerHTML = originalText;
        //         submitBtn.disabled = false;
        //     });
        // }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function showError(elementId, message) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.style.display = 'block';
        }

        function clearError(elementId) {
            const element = document.getElementById(elementId);
            element.textContent = '';
            element.style.display = 'none';
        }
    </script>
</body>
</html>

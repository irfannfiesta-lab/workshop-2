<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Database credentials
$servername = "localhost";
$username = "example_user"; // replace with your MySQL username
$password = "password";     // replace with your MySQL password
$dbname = "workshop_db";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";
$fullName = "";

// When the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matric = $_POST['matric'];
    $pass = $_POST['password'];

    // Updated query: fetch fullName too
    $stmt = $conn->prepare("SELECT password, fullName FROM student WHERE matricNo = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($db_password, $db_fullname);
        $stmt->fetch();

        if ($pass === $db_password) {

            // Set session for next page
            $_SESSION['fullName'] = $db_fullname;

            // Redirect to frontpage
            header("Location: frontpage.php");
            exit;

        } else {
            $error = "Invalid matric number or password.";
        }
    } else {
        $error = "Matric number does not exist.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0b3d91 0%, #1e6fd9 50%, #a0c4ff 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            z-index: 0;
        }

        body::before {
            top: -100px;
            left: -100px;
            animation: float 20s infinite linear;
        }

        body::after {
            bottom: -100px;
            right: -100px;
            animation: float 25s infinite linear reverse;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, 50px) rotate(90deg); }
            50% { transform: translate(0, 100px) rotate(180deg); }
            75% { transform: translate(-30px, 50px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            z-index: 10;
        }

        .login-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
        }

        .card-header {
            background: linear-gradient(135deg, #0b3d91, #1e6fd9);
            padding: 40px 30px 30px 30px;
            text-align: center;
            position: relative;
            border-bottom-left-radius: 50% 30px;
            border-bottom-right-radius: 50% 30px;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 Q50,80 100,0 L100,100 0,100" fill="%231e6fd9" opacity="0.2"/></svg>');
            background-size: cover;
        }

        .logo-container {
            position: relative;
            z-index: 2;
            margin-bottom: 10px;
        }

        .logo {
            width: 180px;
            height: auto;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
            transition: transform 0.5s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .card-header h1 {
            color: white;
            font-size: 26px;
            margin-top: 15px;
            font-weight: 700;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.5px;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-top: 5px;
            font-weight: 300;
        }

        .card-body {
            padding: 40px 35px 35px 35px;
        }

        .card-body h2 {
            color: #0b3d91;
            margin-bottom: 30px;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .error {
            background: rgba(255, 0, 0, 0.1);
            color: #d32f2f;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            border-left: 5px solid #d32f2f;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #0b3d91;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1e6fd9;
            z-index: 2;
        }

        .input-with-icon input {
            width: 100%;
            padding: 16px 16px 16px 50px;
            border: 2px solid #e1e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f8fafc;
            color: #333;
        }

        .input-with-icon input:focus {
            border-color: #0b3d91;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(11, 61, 145, 0.15);
            outline: none;
        }

        .input-with-icon input::placeholder {
            color: #a0aec0;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            cursor: pointer;
            z-index: 3;
        }

        .password-toggle:hover {
            color: #1e6fd9;
        }

        .login-btn {
            background: linear-gradient(135deg, #0b3d91, #1e6fd9);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 18px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 5px 15px rgba(11, 61, 145, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #0a3685, #1a64c7);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(11, 61, 145, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .card-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e8f0;
            color: #718096;
            font-size: 14px;
        }

        .card-footer a {
            color: #1e6fd9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .card-footer a:hover {
            color: #0b3d91;
            text-decoration: underline;
        }

    </style>
</head>

<body>

<div class="wrapper">
    <div class="login-card">
        <!-- Header with logo -->
        <div class="card-header">
            <div class="logo-container">
                <img src="utem_logo.png" alt="UTEM Logo" class="logo">
            </div>
            <h1>UTEM Student Portal</h1>
            <p>Secure Login Access</p>
        </div>

        <!-- Login form -->
        <div class="card-body">
            <h2><i class="fa-solid fa-user-lock"></i> Student Login</h2>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label><i class="fa-solid fa-id-badge"></i> Matric Number</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="matric" placeholder="Enter your matric number" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fa-solid fa-lock"></i> Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        <span class="password-toggle" id="togglePassword">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fa-solid fa-right-to-bracket"></i> Login to Portal
                </button>
            </form>

            <div class="card-footer">
                <p>Need help? <a href="#">Contact System Administrator</a></p>
                <p>© 2023 Universiti Teknikal Malaysia Melaka</p>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Form submission animation
document.querySelector('form').addEventListener('submit', function(e) {
    const btn = this.querySelector('.login-btn');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Authenticating...';
    btn.disabled = true;
});
</script>

</body>
</html>

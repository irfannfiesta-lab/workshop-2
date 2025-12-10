<?php
session_start();

// Destroy the session to log the user out
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout Successful</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #f4f2ff 0%, #edf7ff 50%, #e9faff 100%);
            text-align: center;
            padding: 100px 0;
        }

        .message-box {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #4a4a4a;
        }

        .button {
            padding: 12px 20px;
            background-color: #7a6dff;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .button:hover {
            background-color: #48c8d8;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="message-box">
    <h1>You have successfully logged out.</h1>
    <p>Click below to go to the login page:</p>
    <a href="login.php" class="button">Proceed to Login</a>
</div>

</body>
</html>

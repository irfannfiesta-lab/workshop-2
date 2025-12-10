<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['fullName'])) {
    header("Location: login.php");
    exit;
}

$fullName = $_SESSION['fullName'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(
                135deg,
                #f4f2ff 0%,
                #edf7ff 50%,
                #e9faff 100%
            );
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
        }

        /* Background glow */
        .glow {
            position: absolute;
            width: 350px;
            height: 350px;
            background: #c8bfff;
            filter: blur(140px);
            border-radius: 50%;
            animation: float 7s ease-in-out infinite;
            opacity: 0.45;
            z-index: -1;
        }

        .glow:nth-child(2) {
            background: #b7f1f1;
            animation-delay: 2.5s;
            opacity: 0.35;
        }

        @keyframes float {
            0%,100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-60px) translateX(40px); }
        }

        /* LEFT SIDE NAVIGATION */
        .sidebar {
            width: 240px;
            background: rgba(255,255,255,0.55);
            backdrop-filter: blur(14px);
            box-shadow: 4px 0 12px rgba(0,0,0,0.1);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 10;
        }

        .sidebar .logo {
            font-size: 20px;
            font-weight: 600;
            color: #4a4a4a;
            margin-bottom: 40px;
            width: 100%;
            text-align: left;
        }

        .sidebar a {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            color: #4a4a4a;
            border-radius: 10px;
            transition: 0.2s;
            display: block;
            box-sizing: border-box;
        }

        .sidebar a:hover {
            background: rgba(122,109,255,0.15);
            color: #7a6dff;
        }

        /* USER CORNER */
        .user-corner {
            margin-top: auto;
            font-size: 14px;
            color: #333;
            background: rgba(255,255,255,0.7);
            padding: 12px;
            width: 90%;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            cursor: pointer;
            position: relative;
            box-sizing: border-box;
        }

        .user-corner strong {
            font-size: 15px;
        }

        /* LOGOUT BOX BESIDE USER CORNER */
        .logout-box {
            display: none;
            position: absolute;
            left: 105%; /* appears to the right */
            bottom: 0;
            background: white;
            padding: 12px 18px;
            border-radius: 10px;
            width: 140px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: center;
            box-sizing: border-box;
        }

        /* Profile and Logout link style */
        .logout-box a {
            text-decoration: none;
            color: #4a4a4a; /* Default color for Profile */
            font-weight: 600;
            font-size: 15px;
        }

        .logout-box a:hover {
            color: #7a6dff; /* Hover color for both Profile and Logout */
        }

        .logout-box a.logout {
            color: #ff4b4b; /* Red color for Logout */
        }

        /* MAIN CONTENT AREA */
        .content {
            flex: 1;
            padding: 80px 100px;
            margin-left: 260px;
        }

        .reminder-box {
            width: 420px;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.7);
            animation: fadeIn 1s ease-in-out;
        }

        .reminder-box h2 {
            margin: 0 0 10px;
            color: #3b3b3b;
            font-size: 22px;
            font-weight: 600;
        }

        .reminder-box p {
            font-size: 15px;
            color: #555;
            line-height: 1.6;
        }

        .add-button {
            margin-top: 20px;
            padding: 12px 18px;
            background: linear-gradient(90deg, #7a6dff, #48c8d8);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .add-button:hover {
            transform: scale(1.02);
            box-shadow: 0 0 12px rgba(100, 100, 255, 0.4);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

    </style>

</head>
<body>

<div class="glow"></div>
<div class="glow"></div>

<!-- LEFT-SIDE NAVIGATION -->
<div class="sidebar">
    <div class="logo">Internship System</div>

    <a href="http://10.241.214.216/internlink/student_logbook.php" target="_blank">Submit Logbook</a>
    <a href="logbook_status.php">Logbook Status</a>
    <a href="supervisor_details.php">Supervisor Details</a>

    <div class="user-corner" onclick="toggleLogout()">
        Logged in as: <br>
        <strong><?php echo htmlspecialchars($fullName); ?></strong>
    </div>

    <div class="logout-box" id="logoutBox">
        <a href="student_profile.php">Profile</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT AREA -->
<div class="content">
    <div class="reminder-box">
        <h2>Weekly Reminder</h2>
        <p>
            Don't forget to upload your <strong>Weekly Logbook</strong>.
            <br><br>
            Keeping your logbook updated helps your supervisor track progress.
        </p>

        <a href="submit_logbook.php">
            <button class="add-button">+ Add Logbook</button>
        </a>
    </div>
</div>

<script>
function toggleLogout() {
    const box = document.getElementById('logoutBox');
    box.style.display = (box.style.display === "block") ? "none" : "block";
}
</script>

</body>
</html>

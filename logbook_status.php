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
    <title>Logbook Status</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #f4f2ff 0%, #edf7ff 50%, #e9faff 100%);
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
        }

        /* Background glow effects */
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
            0%, 100% { transform: translateY(0px) translateX(0px); }
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
        }

        .logout-box {
            display: none;
            position: absolute;
            left: 105%;
            bottom: 0;
            background: white;
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 120px;
            text-align: center;
        }

        .logout-box a {
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            background: rgba(122,109,255,0.2);
            border-radius: 8px;
            color: #7a6dff;
            font-weight: 600;
        }

        /* Main content */
        .content {
            flex: 1;
            padding: 60px 100px;
            margin-left: 260px;
        }

        .logbook-wrapper {
            display: flex;
            gap: 40px;
        }

        .logbook-box {
            background: white;
            padding: 25px;
            width: 420px;  /* Slightly wider */
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        }

        .attachment-box {
            background: white;
            padding: 25px;
            width: 520px;   /* Bigger preview container */
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        }

        h2 {
            margin-bottom: 14px;
            color: #333;
        }

        select, textarea, input[type="file"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        /* Bigger description box + vertical resize only */
        textarea {
            height: 150px;
            resize: vertical;
            max-height: 350px;
        }

        /* Designed date field */
        .date-display {
            background: #f3f2ff;
            border: 1px solid #d5d3ff;
            color: #555;
            font-weight: 500;
        }

        .submit-btn, .view-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #7a6dff, #48c8d8);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.2s;
        }

        .submit-btn:hover, .view-btn:hover {
            transform: scale(1.02);
        }

        .preview-box {
            margin-top: 12px;
            background: #f9f9ff;
            padding: 14px;
            border-radius: 10px;
            text-align: center;
            display: none;
        }

        .preview-box img, 
        .preview-box iframe {
            max-width: 100%;
            max-height: 420px;
            border-radius: 10px;
        }

    </style>
</head>

<body>

<div class="glow"></div>
<div class="glow"></div>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">Internship System</div>

    <a href="frontpage.php">Home</a>
    <a href="submit_logbook.php">Submit Logbook</a>
    <a href="logbook_status.php">Logbook Status</a>
    <a href="supervisor_details.php">Supervisor Details</a>

    <div class="user-corner" onclick="toggleLogout()">
        Logged in as:<br>
        <strong><?php echo htmlspecialchars($fullName); ?></strong>
    </div>

    <div class="logout-box" id="logoutBox">
        <a href="login.php">Logout</a>
    </div>
</div>

<script>
function toggleLogout() {
    const box = document.getElementById("logoutBox");
    box.style.display = box.style.display === "block" ? "none" : "block";
}
</script>

</body>
</html>
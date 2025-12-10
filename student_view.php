<?php
// --- 1. FORCE ERROR REPORTING ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --------------------------------

// 2. Include the connection file
if (!file_exists('db.php')) {
    die("<h3>Error: Could not find db.php.</h3>");
}
include "db.php";

// 3. Get Database Connection
$pdo = getSQLServer();
$alert = "";

// 4. Handle "Apply" Button Logic
if ($pdo && isset($_POST['apply_btn'])) {
    $sID = $_POST['student_id'];
    $iID = $_POST['internship_id'];

    // Check if student already applied
    $check = $pdo->prepare("SELECT * FROM Application WHERE StudentID = ? AND InternshipID = ?");
    $check->execute([$sID, $iID]);

    if ($check->rowCount() > 0) {
        $alert = "<div class='alert alert-warning'>You have already applied for this job!</div>";
    } else {
        // Insert new application into the Bridge Table
        $sql = "INSERT INTO Application (StudentID, InternshipID, Status) VALUES (?, ?, 'Pending')";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$sID, $iID]);
            $alert = "<div class='alert alert-success'>Application Sent Successfully!</div>";
        } catch (Exception $e) {
            $alert = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}

// 5. Fetch Internships to Display
$internships = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM Internship ORDER BY InternshipID DESC");
    $internships = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Internships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5" style="background-color: #f0f2f5;">

    <div class="container">
        <h1 class="mb-4 text-center">Available Internships</h1>
        
        <?= $alert ?>

        <div class="row">
            <?php if (count($internships) > 0): ?>
                <?php foreach ($internships as $job): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h4 class="card-title text-primary"><?= htmlspecialchars($job['Title']) ?></h4>
                                <h6 class="text-muted mb-3">Company ID: <?= $job['CompanyID'] ?></h6>
                                <p class="card-text"><?= htmlspecialchars($job['Description']) ?></p>
                                
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-success fs-6">RM <?= $job['Allowance'] ?></span>
                                    
                                    <form method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="internship_id" value="<?= $job['InternshipID'] ?>">
                                        <input type="number" name="student_id" class="form-control form-control-sm" placeholder="Student ID" style="width: 100px;" required>
                                        <button type="submit" name="apply_btn" class="btn btn-primary btn-sm">Apply</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info w-100">No internships posted yet.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
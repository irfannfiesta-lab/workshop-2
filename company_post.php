<?php
// --- 1. FORCE ERROR REPORTING (Fixes White Screen) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// -----------------------------------------------------

// 2. Include the connection file
if (!file_exists('db.php')) {
    die("<h3>Error: Could not find db.php. Make sure both files are in the same folder!</h3>");
}
include "db.php";

// 3. Get Database Connection
$pdo = getSQLServer();
$message = "";

// 4. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $pdo) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $allowance = $_POST['allowance'];
    $company_id = $_POST['company_id']; 

    // SQL Query
    $sql = "INSERT INTO Internship (Title, Description, Allowance, CompanyID) VALUES (?, ?, ?, ?)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $allowance, $company_id]);
        $message = "success";
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Internship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">

    <div class="container bg-white p-4 rounded shadow" style="max-width: 600px;">
        <h2 class="text-primary text-center mb-4">Create Internship Offer</h2>

        <?php if ($message == "success"): ?>
            <div class="alert alert-success">Internship posted successfully!</div>
        <?php elseif ($message != ""): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Company ID (Simulated)</label>
                <input type="number" name="company_id" class="form-control" required placeholder="e.g. 101">
            </div>

            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" class="form-control" required placeholder="e.g. Web Developer">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Allowance (RM)</label>
                <input type="number" name="allowance" class="form-control" step="0.01" placeholder="0.00">
            </div>

            <button type="submit" class="btn btn-primary w-100">Post Job</button>
        </form>
    </div>

</body>
</html>
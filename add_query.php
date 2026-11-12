<?php
require_once 'config.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// =============================================
// SANITIZE & VALIDATE INPUTS
// =============================================
$roll_no   = trim($conn->real_escape_string($_POST['roll_no']   ?? ''));
$full_name = trim($conn->real_escape_string($_POST['full_name'] ?? ''));
$email     = trim($conn->real_escape_string($_POST['email']     ?? ''));
$class     = trim($conn->real_escape_string($_POST['class']     ?? ''));
$gender    = trim($conn->real_escape_string($_POST['gender']    ?? ''));
$is_active = isset($_POST['is_active']) ? 1 : 0;

$allowed_classes = ['9th','10th','11th','12th','BS-1','BS-2','BS-3','BS-4'];
$allowed_genders = ['Male','Female','Other'];

// Validation
if (empty($roll_no) || empty($full_name) || empty($email) || empty($class) || empty($gender)) {
    $_SESSION['error'] = 'All fields are required!';
    $_SESSION['old']   = $_POST;
    header('Location: add.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address!';
    $_SESSION['old']   = $_POST;
    header('Location: add.php');
    exit;
}

if (!in_array($class, $allowed_classes)) {
    $_SESSION['error'] = 'Invalid class selected!';
    $_SESSION['old']   = $_POST;
    header('Location: add.php');
    exit;
}

if (!in_array($gender, $allowed_genders)) {
    $_SESSION['error'] = 'Invalid gender selected!';
    $_SESSION['old']   = $_POST;
    header('Location: add.php');
    exit;
}

// =============================================
// INSERT QUERY
// =============================================
$sql = "INSERT INTO students (roll_no, full_name, email, class, gender, is_active)
        VALUES ('$roll_no', '$full_name', '$email', '$class', '$gender', $is_active)";

if ($conn->query($sql)) {
    $_SESSION['success'] = "Student <strong>$full_name</strong> added successfully!";
    header('Location: index.php');
} else {
    // Duplicate entry check
    if ($conn->errno === 1062) {
        $_SESSION['error'] = 'Roll Number or Email already exists! Please use a unique value.';
    } else {
        $_SESSION['error'] = 'Database error: ' . $conn->error;
    }
    $_SESSION['old'] = $_POST;
    header('Location: add.php');
}

$conn->close();
exit;
?>

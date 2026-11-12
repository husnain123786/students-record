<?php
require_once 'config.php';

// =============================================
// DELETE QUERY
// =============================================
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['error'] = 'Invalid student ID!';
    header('Location: index.php');
    exit;
}

// First fetch the name for feedback message
$check = $conn->query("SELECT full_name FROM students WHERE id = $id LIMIT 1");

if (!$check || $check->num_rows === 0) {
    $_SESSION['error'] = 'Student not found!';
    header('Location: index.php');
    exit;
}

$student  = $check->fetch_assoc();
$name     = $student['full_name'];

// =============================================
// DELETE QUERY
// =============================================
$sql = "DELETE FROM students WHERE id = $id LIMIT 1";

if ($conn->query($sql) && $conn->affected_rows > 0) {
    $_SESSION['success'] = "Student <strong>$name</strong> has been deleted successfully!";
} else {
    $_SESSION['error'] = 'Could not delete student. Please try again.';
}

$conn->close();
header('Location: index.php');
exit;
?>

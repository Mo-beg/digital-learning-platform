<?php
/*
 * enroll.php - ENROLLMENT HANDLER
 * -------------------------------------------------------------
 * LEARNING NOTE: This file has NO HTML at all - it's a pure
 * "action" file. It just does work and redirects.
 *
 * Flow:
 *   1. Check if user is logged in (if not -> login page)
 *   2. Get course_id from the URL (?course_id=1)
 *   3. Insert a row in the enrollments table (or ignore if exists)
 *   4. Redirect to the overview page for that course
 * -------------------------------------------------------------
 */

session_start();
require_once 'db.php';

// Must be logged in to enroll
// If not, redirect to login and remember to come back here after
if (!isset($_SESSION['user_id'])) {
    $current_url = urlencode("/digital learning platform/enroll.php?course_id=" . ($_GET['course_id'] ?? ''));
    header("Location: /digital learning platform/auth/login.php?redirect=" . $current_url);
    exit;
}

$user_id   = $_SESSION['user_id'];
$course_id = (int) ($_GET['course_id'] ?? 0); // (int) makes sure it's a number - prevents attacks

if ($course_id <= 0) {
    header("Location: /digital learning platform/course.php");
    exit;
}

// Look up the course to get its overview file path
$stmt = mysqli_prepare($conn, "SELECT overview_file FROM courses WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $course_id); // "i" = integer
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $overview_file);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$overview_file) {
    header("Location: /digital learning platform/course.php");
    exit;
}

// INSERT IGNORE means: if enrollment already exists, do nothing (no error)
// If it doesn't exist, insert a new row
$stmt2 = mysqli_prepare($conn, "INSERT IGNORE INTO enrollments (user_id, course_id) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt2, "ii", $user_id, $course_id);
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);

// Redirect to the overview page for this course
header("Location: /digital learning platform/" . $overview_file);
exit;
?>

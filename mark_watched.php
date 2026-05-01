<?php
/*
 * mark_watched.php - VIDEO WATCH TRACKER (AJAX ENDPOINT)
 * -------------------------------------------------------------
 * LEARNING NOTE: This is an "API endpoint" - a PHP file that
 * doesn't return HTML, it returns JSON data.
 *
 * JavaScript in the material pages calls this file using
 * fetch() after the user watches the video for 10-25 seconds.
 *
 * This is how modern websites talk between the browser (JS)
 * and the server (PHP) without reloading the page.
 *
 * Request:  POST with JSON body: { course_id: 1 }
 * Response: JSON: { success: true } or { success: false }
 * -------------------------------------------------------------
 */

session_start();
require_once 'db.php';

// Tell the browser we're sending back JSON, not HTML
header('Content-Type: application/json');

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

// Read the JSON body that JavaScript sent us
$data      = json_decode(file_get_contents('php://input'), true);
$course_id = (int) ($data['course_id'] ?? 0);
$user_id   = $_SESSION['user_id'];

if ($course_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid course']);
    exit;
}

// Update the enrollment row to set video_watched = 1
$stmt = mysqli_prepare($conn,
    "UPDATE enrollments SET video_watched = 1 WHERE user_id = ? AND course_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $user_id, $course_id);
$ok = mysqli_stmt_execute($stmt);

echo json_encode(['success' => $ok]);
exit;
?>

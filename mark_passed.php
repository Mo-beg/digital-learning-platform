<?php
/*
 * mark_passed.php - SAVE QUIZ PASS TO DATABASE
 * -------------------------------------------------------------
 * Called by JavaScript in quiz.php when user scores 60%+
 * Updates enrollments table: quiz_passed = 1
 * Returns JSON response (no HTML)
 * -------------------------------------------------------------
 */

session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$data      = json_decode(file_get_contents('php://input'), true);
$course_id = (int) ($data['course_id'] ?? 0);
$user_id   = $_SESSION['user_id'];

if ($course_id <= 0) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = mysqli_prepare($conn,
    "UPDATE enrollments SET quiz_passed = 1 WHERE user_id = ? AND course_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $user_id, $course_id);
$ok = mysqli_stmt_execute($stmt);

echo json_encode(['success' => $ok]);
exit;
?>

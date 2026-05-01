<?php
/*
 * partials/auth_check.php - LOGIN GUARD
 * -------------------------------------------------------------
 * LEARNING NOTE: Instead of copy-pasting the same login check
 * into every protected file, we put it here ONCE and include it.
 *
 * Any page that requires login just does:
 *   require_once '../partials/auth_check.php';
 *
 * This is the DRY principle: Don't Repeat Yourself.
 * It's a core habit in professional PHP development.
 *
 * The file reads $course_id from the page that included it,
 * so it can redirect back to the right place after login.
 * -------------------------------------------------------------
 */

if (!isset($_SESSION['user_id'])) {
    // Build the URL of the current page so we can return here after login
    $current_page = urlencode("/digital learning platform" . $_SERVER['PHP_SELF'] .
        (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));

    header("Location: /digital learning platform/auth/login.php?redirect=" . $current_page);
    exit;
}

// Also check enrollment if $course_id is set by the including page
if (isset($course_id) && isset($conn)) {
    $uid = $_SESSION['user_id'];
    $stmt = mysqli_prepare($conn, "SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $uid, $course_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        // User is logged in but hasn't enrolled - send them to enroll first
        header("Location: /digital learning platform/enroll.php?course_id=" . $course_id);
        exit;
    }
    mysqli_stmt_close($stmt);
}
?>

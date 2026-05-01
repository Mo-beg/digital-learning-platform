<?php
/*
 * logout.php - LOG OUT
 * -------------------------------------------------------------
 * LEARNING NOTE: Logging out is simple but has 3 steps:
 *
 * Step 1: session_start()   - you must start it before destroying it
 * Step 2: session_destroy() - removes all $_SESSION data from the server
 * Step 3: Redirect to home  - send the user somewhere after logout
 *
 * There's no HTML here - this file just does work and redirects.
 * -------------------------------------------------------------
 */

session_start();
session_destroy(); // Clears all $_SESSION variables

// Also clear the session cookie from the browser (best practice)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

header("Location: /digital learning platform/home.php");
exit;
?>

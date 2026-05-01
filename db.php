<?php
/*
 * db.php - DATABASE CONNECTION
 * -------------------------------------------------------------
 * Every PHP file that needs the database will do:
 *   require_once '../db.php';   (or just 'db.php' if in same folder)
 *
 * We use mysqli (MySQL Improved) - it's built into PHP and
 * works perfectly with XAMPP.
 *
 * HOW TO SET UP (do this ONCE before running the site):
 *  1. Open XAMPP -> Start Apache and MySQL
 *  2. Go to http://localhost/phpmyadmin
 *  3. Click "New" on the left side
 *  4. Database name: learnhub  -> click Create
 *  5. Then run the SQL in setup.sql (we provide that file too)
 * -------------------------------------------------------------
 */

define('DB_HOST', 'localhost');   // XAMPP always uses localhost
define('DB_USER', 'root');        // XAMPP default username
define('DB_PASS', '');            // XAMPP default password (empty)
define('DB_NAME', 'learnhub');    // The database name we just created

// mysqli_connect() tries to open a connection to MySQL
// It returns a connection object we store in $conn
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Always check if connection worked
// mysqli_connect_error() returns the error message if it failed
if (!$conn) {
    die(" Database connection failed: " . mysqli_connect_error());
}

// If we reach here, connection is open and ready to use!
// $conn is now available in any file that includes this file
?>

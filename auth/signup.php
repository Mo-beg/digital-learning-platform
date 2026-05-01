<?php
/*
 * signup.php - USER REGISTRATION
 * -------------------------------------------------------------
 * LEARNING NOTE: This file does two jobs depending on HOW it
 * was opened:
 *
 *   1. GET request  -> user just opened the page -> show the form
 *   2. POST request -> user submitted the form   -> process the data
 *
 * $_SERVER['REQUEST_METHOD'] tells us which one it is.
 * This is a very common PHP pattern - one file handles both!
 * -------------------------------------------------------------
 */

// session_start() MUST be the very first thing - before any HTML
// It allows us to use $_SESSION[] to remember the logged-in user
session_start();

// If already logged in, no need to sign up again - send to home
if (isset($_SESSION['user_id'])) {
    header("Location: /digital learning platform/home.php");
    exit; // Always exit after header() redirect!
}

// Include database connection - now $conn is available
require_once '../db.php';

// We'll collect errors and success messages in these variables
$error   = '';
$success = '';

// --- PROCESS FORM SUBMISSION ----------------------------------
// This block runs ONLY when the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Grab form values. trim() removes accidental spaces.
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');

    // -- Validation --------------------------------------------
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // filter_var() is a built-in PHP function that checks email format
        $error = 'Please enter a valid email address.';

    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';

    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';

    } else {
        // -- Check if email already exists ---------------------
        // We use a "prepared statement" - this is the SAFE way to
        // query the database. It prevents SQL Injection attacks.
        //
        // ? is a placeholder - the real value is bound below
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email); // "s" = string type
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = 'An account with this email already exists.';
        } else {
            // -- Hash the password ------------------------------
            // NEVER store plain passwords in a database!
            // password_hash() scrambles it using a strong algorithm.
            // password_verify() (used in login.php) checks it later.
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // -- Insert the new user ----------------------------
            $stmt2 = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt2, "sss", $name, $email, $hashed);

            if (mysqli_stmt_execute($stmt2)) {
                // Get the new user's ID (the auto-generated one)
                $new_user_id = mysqli_insert_id($conn);

                // Log them in immediately after signup
                $_SESSION['user_id']   = $new_user_id;
                $_SESSION['user_name'] = $name;

                // Redirect to home page
                header("Location: /digital learning platform/home.php");
                exit;
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
// --- END OF FORM PROCESSING -----------------------------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - LearnHub</title>
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #0f172a;
}

/* NAVBAR */
.navbar {
    background: #1e293b;
    padding: 16px 48px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
}

/* LOGO */
.logo a {
    font-size: 22px;
    font-weight: 700;
    color: #3b82f6;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.logo a:hover {
    color: #60a5fa;
}

/* NAV LINKS */
.nav-links a {
    color: #cbd5e1;
    text-decoration: none;
    margin: 0 16px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color 0.3s ease;
}

.nav-links a i {
    color: #3b82f6;
}

.nav-links a:hover {
    color: #3b82f6;
}
        /* MAIN CONTENT */
        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
        }

        .auth-card {
            background: #1e293b;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 440px;
            border: 1px solid rgba(51,65,85,0.5);
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        .auth-card h1 {
            font-size: 28px;
            color: #ffffff;
            margin-bottom: 8px;
            text-align: center;
        }

        .auth-card .subtitle {
            color: #94a3b8;
            font-size: 15px;
            text-align: center;
            margin-bottom: 32px;
        }

        /* ALERT MESSAGES */
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .alert-error   { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }
        .alert-success { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }

        /* FORM */
        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            background: #0f172a;
            border: 1px solid rgba(51,65,85,0.7);
            border-radius: 8px;
            color: #ffffff;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        input::placeholder { color: #475569; }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59,130,246,0.35);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #94a3b8;
        }

        .auth-footer a { color: #3b82f6; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">
        <a href="/digital learning platform/home.php">
            <img src="/digital learning platform/image/logofinal.svg" alt="LearnHub" class="nav-logo">
        
        </a>
    </div>
    <div class="nav-links">
        <a href="/digital learning platform/home.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="/digital learning platform/course.php"><i class="fa-solid fa-book"></i> Courses</a>
        <a href="/digital learning platform/discover.php"><i class="fa-solid fa-compass"></i> Discover</a>
    </div>
</nav>

<!-- SIGNUP FORM -->
<div class="auth-wrapper">
    <div class="auth-card">

        <h1><i class="fa-solid fa-user-plus" style="color:#3b82f6"></i> Create Account</h1>
        <p class="subtitle">Join LearnHub and start learning today</p>

        <!-- Show error message if $error is not empty -->
        <?php if ($error): ?>
            <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!--
            action="" means submit to THIS same file (signup.php)
            method="post" means data is sent in the request body (not in URL)
        -->
        <form action="" method="post">

            <div class="form-group">
                <label for="name">Full Name</label>
                <!-- htmlspecialchars() prevents XSS attacks when re-displaying user input -->
                <input type="text" id="name" name="name" placeholder="Your full name"
                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="At least 6 characters" required>
            </div>

            <div class="form-group">
                <label for="confirm">Confirm Password</label>
                <input type="password" id="confirm" name="confirm" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Create My Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="/digital learning platform/auth/login.php">Log in here</a>
        </div>

    </div>
</div>

</body>
</html>

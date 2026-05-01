<?php
/*
 * login.php - USER LOGIN
 * -------------------------------------------------------------
 * LEARNING NOTE: Notice how similar this is to signup.php -
 * same pattern: GET shows form, POST processes it.
 *
 * The key difference: instead of INSERT, we do SELECT
 * then use password_verify() to check the hashed password.
 * -------------------------------------------------------------
 */

session_start();

// Already logged in? Send to home
if (isset($_SESSION['user_id'])) {
    header("Location: /digital learning platform/home.php");
    exit;
}

require_once '../db.php';

$error = '';

// Did the user come from a protected page? Save where to redirect back
// e.g., material.php adds ?redirect=course+1/material.php to the URL
$redirect = $_GET['redirect'] ?? '/digital learning platform/home.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    // Save redirect from hidden form field
    $redirect = $_POST['redirect'] ?? '/digital learning platform/home.php';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';

    } else {
        // Find user by email
        // We select the id, name, and password to check
        $stmt = mysqli_prepare($conn, "SELECT id, name, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        // bind_result() maps the database columns to PHP variables
        mysqli_stmt_bind_result($stmt, $user_id, $user_name, $hashed_password);
        mysqli_stmt_fetch($stmt);

        // password_verify() checks if the typed password matches the stored hash
        // This is the opposite of password_hash() used in signup.php
        if ($user_id && password_verify($password, $hashed_password)) {
            //  Correct! Set session variables to remember this user
            $_SESSION['user_id']   = $user_id;
            $_SESSION['user_name'] = $user_name;

            // Redirect to where they were trying to go (or home)
            header("Location: " . $redirect);
            exit;
        } else {
            //  Wrong email or password - same message for both (security best practice)
            $error = 'Invalid email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - LearnHub</title>
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
            max-width: 420px;
            border: 1px solid rgba(51,65,85,0.5);
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        .auth-card h1 { font-size: 28px; color: #ffffff; margin-bottom: 8px; text-align: center; }
        .auth-card .subtitle { color: #94a3b8; font-size: 15px; text-align: center; margin-bottom: 32px; }

        .alert { padding: 14px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 15px; }
        .alert-error { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }

        .form-group { margin-bottom: 20px; }
        label { display: block; color: #cbd5e1; font-size: 14px; font-weight: 600; margin-bottom: 8px; }

        input[type="email"], input[type="password"] {
            width: 100%; padding: 12px 16px;
            background: #0f172a; border: 1px solid rgba(51,65,85,0.7);
            border-radius: 8px; color: #ffffff; font-size: 15px; transition: border-color 0.3s;
        }
        input:focus { outline: none; border-color: #3b82f6; }
        input::placeholder { color: #475569; }

        .btn-submit {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white; border: none; border-radius: 8px;
            font-size: 16px; font-weight: 600; cursor: pointer;
            margin-top: 8px; transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(59,130,246,0.35); }

        .auth-footer { text-align: center; margin-top: 24px; font-size: 14px; color: #94a3b8; }
        .auth-footer a { color: #3b82f6; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

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

<div class="auth-wrapper">
    <div class="auth-card">

        <h1><i class="fa-solid fa-right-to-bracket" style="color:#3b82f6"></i> Welcome Back</h1>
        <p class="subtitle">Log in to continue your learning</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <!-- Hidden field carries the redirect destination through the form submission -->
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Your password" required>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-right-to-bracket"></i> Log In
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="/digital learning platform/auth/signup.php">Sign up free</a>
        </div>

    </div>
</div>

</body>
</html>

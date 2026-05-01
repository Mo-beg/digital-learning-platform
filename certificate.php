<?php
/*
 * certificate.php - CERTIFICATE OF COMPLETION
 * -------------------------------------------------------------
 * LEARNING NOTE: This page checks THREE things before showing
 * the certificate:
 *   1. Is the user logged in?
 *   2. Is the course_id valid?
 *   3. Did this user actually pass the quiz?
 *
 * If any check fails -> redirect away. This prevents someone
 * from just typing /certificate.php?course_id=1 to get a
 * certificate they didn't earn!
 * -------------------------------------------------------------
 */

session_start();
require_once 'db.php';

// Guard 1: Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /digital learning platform/auth/login.php");
    exit;
}

$user_id   = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$course_id = (int) ($_GET['course_id'] ?? 0);

if ($course_id <= 0) {
    header("Location: /digital learning platform/course.php");
    exit;
}

// Guard 2 + 3: Check enrollment AND quiz_passed = 1
$stmt = mysqli_prepare($conn,
    "SELECT e.quiz_passed, c.title
     FROM enrollments e
     JOIN courses c ON c.id = e.course_id
     WHERE e.user_id = ? AND e.course_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $user_id, $course_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $quiz_passed, $course_title);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// If not enrolled OR quiz not passed -> back to course page
if (!$quiz_passed) {
    header("Location: /digital learning platform/course.php");
    exit;
}

// All checks passed! Show the certificate.
// Get today's date in a nice format
$date = date("F j, Y"); // e.g. "January 15, 2026"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - LearnHub</title>
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; }

        body {
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* -- NAVBAR ----------------------------------------------- */
        .navbar {
            width: 100%;
            background: #1e293b;
            padding: 16px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(59,130,246,0.1);
        }
        .logo a {
            font-size: 22px; font-weight: 700; color: #3b82f6;
            text-decoration: none; display: flex; align-items: center; gap: 8px;
        }
        .nav-links a {
            color: #cbd5e1; text-decoration: none; margin: 0 16px; font-weight: 500;
        }
        .nav-links a:hover { color: #3b82f6; }

        /* -- PAGE WRAPPER ------------------------------------------- */
        .cert-page {
            padding: 50px 20px 80px;
            width: 100%;
            max-width: 900px;
            text-align: center;
        }

        .page-title {
            color: #cbd5e1;
            font-size: 18px;
            margin-bottom: 30px;
        }

        /* -- PRINT BUTTON ------------------------------------------- */
        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 40px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59,130,246,0.35);
        }

        /* -- THE ACTUAL CERTIFICATE ---------------------------------- */
        /* This is the part that gets printed */
        .certificate {
            background: #ffffff;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 60px 70px;
            border-radius: 4px;
            border: 12px solid #1e3a8a;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            position: relative;
            color: #1e293b;
        }

        /* Decorative corner accents */
        .certificate::before,
        .certificate::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            border-color: #f59e0b;
            border-style: solid;
        }
        .certificate::before {
            top: 16px; left: 16px;
            border-width: 4px 0 0 4px;
        }
        .certificate::after {
            bottom: 16px; right: 16px;
            border-width: 0 4px 4px 0;
        }

        .cert-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .cert-logo img {
            height: 40px;
        }
        .cert-logo-text {
            font-size: 28px;
            font-weight: 800;
            color: #1e3a8a;
        }

        .cert-divider {
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #f59e0b, transparent);
            margin: 20px auto;
        }

        .cert-subtitle {
            font-size: 13px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 16px;
        }

        .cert-main-title {
            font-size: 40px;
            font-weight: 800;
            color: #1e3a8a;
            margin-bottom: 20px;
            font-family: Georgia, serif;
        }

        .cert-presented {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 10px;
        }

        .cert-name {
            font-size: 42px;
            font-weight: 700;
            color: #0f172a;
            font-family: Georgia, serif;
            border-bottom: 2px solid #e2e8f0;
            display: inline-block;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .cert-for {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 10px;
        }

        .cert-course {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .cert-badge {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 24px auto;
            box-shadow: 0 4px 16px rgba(245,158,11,0.4);
        }
        .cert-badge i { font-size: 44px; color: #fff; }

        .cert-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 40px;
        }

        .cert-sig-block {
            text-align: center;
        }
        .cert-sig-line {
            width: 160px;
            border-top: 2px solid #0f172a;
            margin: 0 auto 6px;
        }
        .cert-sig-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }
        .cert-sig-role {
            font-size: 12px;
            color: #64748b;
        }

        .cert-date-block {
            text-align: center;
        }
        .cert-date {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }
        .cert-date-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* -- PRINT STYLES ------------------------------------------
           @media print runs when the user presses Ctrl+P or
           clicks our Print button. It hides everything except
           the certificate itself so it prints cleanly.
        ------------------------------------------------------------ */
        @media print {
            body { background: #fff !important; }
            .navbar, .print-btn, .page-title { display: none !important; }
            .cert-page { padding: 0 !important; }
            .certificate {
                box-shadow: none !important;
                border-radius: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR (hidden when printing) -->
<?php include 'partials/nav.php'; ?>

<div class="cert-page">

    <p class="page-title">
        <i class="fa-solid fa-circle-check" style="color:#10b981"></i>
        Congratulations, <?= htmlspecialchars($user_name) ?>! Here is your certificate.
    </p>

    <!-- Print button - calls window.print() which triggers the @media print CSS -->
    <button class="print-btn" onclick="window.print()">
        <i class="fa-solid fa-print"></i> Print / Save as Screenshot
    </button>

    <!-- ==========================================================
         THE CERTIFICATE - this is what gets printed
    ========================================================== -->
    <div class="certificate">

        <!-- Logo: pure SVG inline - works in print/PDF with no broken image -->
        <div class="cert-logo">
            <span class="cert-logo-text"><img src="/digital learning platform/image/logofinal.svg" alt="LearnHub" class="nav-logo"></span>
        </div>

        <div class="cert-divider"></div>

        <div class="cert-subtitle">Certificate of Completion</div>

        <div class="cert-main-title">Achievement Unlocked</div>

        <div class="cert-presented">This certificate is proudly presented to</div>

        <!-- The user's actual name from the database / session -->
        <div class="cert-name"><?= htmlspecialchars($user_name) ?></div>

        <div class="cert-for">for successfully completing the course</div>

        <!-- The course title from the database -->
        <div class="cert-course"><?= htmlspecialchars($course_title) ?></div>

        <!-- Trophy badge - inline SVG works in print/PDF -->
        <div class="cert-badge">
            <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                <path d="M25,5 L31,18 L46,18 L34,27 L38,41 L25,32 L12,41 L16,27 L4,18 L19,18 Z"
                      fill="#ffffff" stroke="none"/>
            </svg>
        </div>

        <div class="cert-divider"></div>

        <!-- Footer with signature + date -->
        <div class="cert-footer">

            <div class="cert-sig-block">
                <!-- SVG signature — transparent background, matches white certificate -->
                <svg width="160" height="52" viewBox="0 0 160 52" xmlns="http://www.w3.org/2000/svg" style="display:block; margin-bottom:6px;">
                  <!-- Elegant cursive-style signature in dark ink, fully transparent background -->
                  <path d="M12,38 C18,20 28,14 36,18 C42,22 38,34 32,36 C26,38 22,32 28,28 C34,24 44,26 50,30 C56,34 54,42 48,40"
                        fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M48,40 C54,38 62,32 68,34 C74,36 72,44 66,42 C72,40 80,34 88,36"
                        fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M88,36 C94,38 96,30 100,26 C104,22 108,24 106,30 C104,36 98,40 104,38 C110,36 118,30 124,32"
                        fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M124,32 C130,34 134,28 138,30 C142,32 140,38 136,36 C140,34 146,30 150,32"
                        fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  <!-- Underline flourish -->
                  <path d="M10,46 C40,43 80,44 150,46" fill="none" stroke="#1e293b" stroke-width="1.2" stroke-linecap="round" opacity="0.4"/>
                </svg>
                <div class="cert-sig-name">LearnHub Academy</div>
                <div class="cert-sig-role">Course Director</div>
            </div>

            <div class="cert-date-block">
                <div class="cert-date"><?= $date ?></div>
                <div class="cert-date-label">Date of Completion</div>
            </div>

        </div>

    </div>
    <!-- end .certificate -->

</div>

</body>
</html>

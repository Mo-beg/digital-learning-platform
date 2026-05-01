<?php
/*
 * partials/nav.php - SHARED NAVIGATION BAR
 * Session must be started in the page that includes this file.
 */
?>
<header class="navbar">
    <div class="logo">
        <a href="/digital learning platform/home.php">
            <img src="/digital learning platform/image/logofinal.svg" alt="LearnHub" class="nav-logo">
        </a>
    </div>

    <nav class="nav-links">
        <a href="/digital learning platform/home.php"><i class="fa-solid fa-house fa-sm"></i> Home</a>
        <a href="/digital learning platform/course.php"><i class="fa-solid fa-book fa-sm"></i> Courses</a>
        <a href="/digital learning platform/discover.php"><i class="fa-solid fa-compass fa-sm"></i> Discover</a>
    </nav>

    <div class="nav-auth">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span style="color:#64748b; font-size:14px; margin-right:16px;">
                <i class="fa-solid fa-circle-user fa-sm" style="color:#2563eb"></i>
                <?= htmlspecialchars($_SESSION['user_name']) ?>
            </span>
            <a href="/digital learning platform/auth/logout.php" class="btn"
               style="background:transparent; border:2px solid #2563eb; color:#2563eb; padding:7px 16px; border-radius:20px; text-decoration:none; font-weight:600; font-size:14px;">
                Logout
            </a>
        <?php else: ?>
            <a href="/digital learning platform/auth/signup.php" class="btn"
               style="text-decoration:none; padding:9px 20px; border-radius:20px; font-size:14px;">
                Get Started
            </a>
        <?php endif; ?>
    </div>
</header>

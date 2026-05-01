<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LearnHub | Courses</title>
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/course.css">
    <!-- FONT AWESOME ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Inline fallback - guarantees hero styles load regardless of external CSS */
        body { margin:0; background:#0f172a; color:#fff; font-family:Arial,sans-serif; }
        .course-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1e293b 100%);
            padding: 60px 60px 50px;
            border-bottom: 1px solid rgba(59,130,246,0.2);
            position: relative; overflow: hidden;
        }
        .course-hero::before {
            content:''; position:absolute; top:-80px; right:-80px;
            width:360px; height:360px;
            background:radial-gradient(circle,rgba(59,130,246,0.15) 0%,transparent 70%);
            border-radius:50%;
        }
        .course-hero-inner {
            max-width:1100px; margin:0 auto;
            display:flex; justify-content:space-between; align-items:center;
            gap:40px; position:relative; z-index:1;
        }
        .course-hero-eyebrow {
            color:#60a5fa; font-size:14px; font-weight:600;
            letter-spacing:1px; text-transform:uppercase;
            margin-bottom:16px; display:flex; align-items:center; gap:8px;
        }
        .course-hero-text h1 {
            font-size:38px; font-weight:800; color:#fff;
            line-height:1.2; margin-bottom:16px; letter-spacing:-0.5px;
        }
        .course-hero-sub {
            font-size:16px; color:#94a3b8; line-height:1.7;
            max-width:520px; margin-bottom:32px;
        }
        .course-hero-stats { display:flex; align-items:center; gap:24px; }
        .hero-stat { text-align:center; }
        .hero-stat-num { display:block; font-size:28px; font-weight:800; color:#3b82f6; line-height:1; }
        .hero-stat-label { display:block; font-size:13px; color:#64748b; margin-top:4px; }
        .hero-stat-divider { width:1px; height:40px; background:rgba(51,65,85,0.8); }
        .course-hero-icon { font-size:120px; color:rgba(59,130,246,0.15); line-height:1; flex-shrink:0; }
        @media(max-width:768px){
            .course-hero{ padding:40px 24px; }
            .course-hero-text h1{ font-size:26px; }
            .course-hero-icon{ display:none; }
            .course-hero-inner{ flex-direction:column; }
        }
    </style>
</head>
<body>

<?php include 'partials/nav.php'; ?>
<section class="course-hero">
    <div class="course-hero-inner">
        <div class="course-hero-text">
            <p class="course-hero-eyebrow"><i class="fa-solid fa-graduation-cap"></i> LearnHub Course Catalog</p>
            <h1>Expand Your Knowledge,<br>Advance Your Future</h1>
            <p class="course-hero-sub">Choose from our expert-designed courses and earn a verified certificate upon completion. Learn at your own pace, completely free.</p>
            <div class="course-hero-stats">
                <div class="hero-stat">
                    <span class="hero-stat-num">4</span>
                    <span class="hero-stat-label">Courses</span>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <span class="hero-stat-num">100%</span>
                    <span class="hero-stat-label">Free</span>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <span class="hero-stat-num">4</span>
                    <span class="hero-stat-label">Certificates</span>
                </div>
            </div>
        </div>
        <div class="course-hero-icon">
            <i class="fa-solid fa-book-open-reader"></i>
        </div>
    </div>
</section>
<!-- COURSES -->
<section class="courses">
    <br>
    <p class="count">Showing 4 courses</p>

    <div class="course-grid">

        <!-- CARD 1 -->
        <div class="card">
            <img src="image/digital.webp" alt="Digital Detective">
            <h3>Digital Detective: Spot the Fake</h3>
            <p>Master the fundamentals of digital detective work.</p>
            <span class="level">Beginner</span>
            <div style="padding:0 15px 15px; display:flex; gap:10px;">
                <a href="course 4/overview4.php" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#334155; color:#cbd5e1; border:none; border-radius:6px; cursor:pointer; font-size:13px;">Overview</button>
                </a>
                <a href="/digital learning platform/enroll.php?course_id=4" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#3b82f6; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:13px; font-weight:600;">Enroll</button>
                </a>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="card">
            <img src="image/psychology.jpeg" alt="Psychology">
            <h3>The Psychology of Everyday Decisions</h3>
            <p>Explore the fascinating world of Psychology.</p>
            <span class="level">Beginner</span>
            <div style="padding:0 15px 15px; display:flex; gap:10px;">
                <a href="course 1/psychology.php" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#334155; color:#cbd5e1; border:none; border-radius:6px; cursor:pointer; font-size:13px;">Overview</button>
                </a>
                <a href="/digital learning platform/enroll.php?course_id=1" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#3b82f6; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:13px; font-weight:600;">Enroll</button>
                </a>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="card">
            <img src="image/financial.jpeg" alt="Financial Management">
            <h3>Financial Management</h3>
            <p>Learn about financial planning, budgeting, and investment strategies.</p>
            <span class="level">Beginner</span>
            <div style="padding:0 15px 15px; display:flex; gap:10px;">
                <a href="course 2/overview2.php" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#334155; color:#cbd5e1; border:none; border-radius:6px; cursor:pointer; font-size:13px;">Overview</button>
                </a>
                <a href="/digital learning platform/enroll.php?course_id=2" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#3b82f6; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:13px; font-weight:600;">Enroll</button>
                </a>
            </div>
        </div>
        
        <!-- CARD 4 -->
        <div class="card">
            <img src="image/prompt.jpeg" alt="Prompt Engineering">
            <h3>Prompt Engineering for Beginners</h3>
            <p>Learn how to create effective prompts for AI tools and systems.</p>
            <span class="level">Beginner</span>
            <div style="padding:0 15px 15px; display:flex; gap:10px;">
                <a href="course 3/prompt-eng-nav.php" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#334155; color:#cbd5e1; border:none; border-radius:6px; cursor:pointer; font-size:13px;">Overview</button>
                </a>
                <a href="/digital learning platform/enroll.php?course_id=3" style="text-decoration:none; flex:1;">
                    <button style="width:100%; padding:9px; background:#3b82f6; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:13px; font-weight:600;">Enroll</button>
                </a>
            </div>
        </div>

    </div>
</section>

<?php include 'partials/footer.php'; ?>
</body>
</html>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prompt Engineering for Beginners - LearnHub</title>

    <!-- Font Awesome -->
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
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
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
}

/* LOGO */
.logo a {
    font-size: 22px;
    font-weight: 700;
    color: #6366f1;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
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
}

.nav-links a i {
    color: #6366f1;
}

.nav-links a:hover {
    color: #6366f1;
}

/* BUTTON */
.btn {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: #ffffff;
    border: none;
    padding: 10px 22px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 500;
}

.btn:hover {
    background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
}

/* HERO SECTION */
.hero-section {
    background: linear-gradient(135deg, #1e1b4b 0%, #2e1065 100%);
    padding: 60px 48px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.18) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-content {
    flex: 1;
    color: white;
    position: relative;
    z-index: 1;
}

.course-badges {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

.hero-content h1 {
    font-size: 48px;
    margin-bottom: 20px;
    font-weight: 700;
    text-shadow: 0 0 40px rgba(99, 102, 241, 0.4);
}

.hero-content p {
    font-size: 18px;
    margin-bottom: 30px;
    line-height: 1.6;
    opacity: 0.95;
}

.course-stats {
    display: flex;
    gap: 30px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
}

.stat-item i {
    font-size: 20px;
    color: #a5b4fc;
}

.hero-image {
    flex: 0 0 400px;
    background: #1e293b;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 1;
}

.image-placeholder {
    width: 100%;
    height: 300px;
    background: #1e1b4b;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.image-placeholder::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background-image:
        radial-gradient(circle at 30% 50%, rgba(99, 102, 241, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 70% 50%, rgba(124, 58, 237, 0.08) 0%, transparent 50%);
}

/* Neural network SVG nodes */
.neural-net {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
}

.hero-icon-wrap {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.hero-icon-wrap i {
    font-size: 90px;
    color: #6366f1;
    filter: drop-shadow(0 0 20px rgba(99, 102, 241, 0.5));
}

.hero-icon-wrap span {
    color: #a5b4fc;
    font-size: 14px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.instructor-card {
    background: #1e293b;
}

/* TABS SECTION */
.tabs-container {
    background: #1e293b;
    padding: 0 48px;
}

.tabs {
    display: flex;
    gap: 0;
}

.tab {
    background: transparent;
    padding: 16px 40px;
    font-size: 16px;
    font-weight: 500;
    color: #94a3b8;
    text-decoration: none;
    cursor: pointer;
    border-radius: 12px 12px 0 0;
    transition: all 0.3s;
    display: inline-block;
}

.tab.active {
    background: #0f172a;
    color: #ffffff;
}

.tab:hover {
    background: #334155;
}

.tab.active:hover {
    background: #0f172a;
}

/* CONTENT SECTION */
.content-section {
    background: #1e293b;
    padding: 50px 48px;
    margin: 0 48px 40px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.content-section h2 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #ffffff;
}

.about-text {
    font-size: 16px;
    color: #cbd5e1;
    line-height: 1.6;
    margin-bottom: 30px;
}

.content-section h3 {
    font-size: 20px;
    margin-bottom: 20px;
    color: #ffffff;
    font-weight: 600;
}

.learning-list {
    list-style: none;
}

.learning-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    font-size: 16px;
    color: #cbd5e1;
}

.learning-list li i {
    color: #6366f1;
    font-size: 20px;
}

/* FOOTER */
.footer {
    background: #0f172a;
    color: #cbd5e1;
    padding: 0;
    }

.footer-content {
        padding: 40px 60px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
}

.footer h4 {
    color: #6366f1;
    margin-bottom: 12px;
}

.footer a {
    display: block;
    text-decoration: none;
    color: #cbd5e1;
    margin-bottom: 8px;
    font-size: 14px;
}

.footer a:hover {
    color: #6366f1;
}

.footer p {
    font-size: 14px;
    margin-bottom: 8px;
    color: #cbd5e1;
}

.footer-bottom {
    background: #000d1a;
    width: 100%;
    padding: 18px 20px;
    text-align: center;
    font-size: 13px;
    font-weight: 500;
    color: #94a3b8;
    border-top: 2px solid #1e3a5f;
    display: block;
    box-sizing: border-box;
    letter-spacing: 0.3px;
}

/* RESPONSIVE */
@media (max-width: 968px) {
    .hero-section {
        flex-direction: column;
        padding: 40px 24px;
    }

    .hero-image {
        flex: 0 0 auto;
        width: 100%;
        max-width: 400px;
    }

    .hero-content h1 {
        font-size: 36px;
    }

    .navbar {
        padding: 16px 24px;
    }

    .tabs-container {
        padding: 0 24px;
    }

    .content-section {
        padding: 40px 24px;
        margin: 0 24px 40px;
    }

    .footer {
        padding: 0;
    }
}
    </style>
</head>

<body>

<!-- NAVBAR -->
<?php include '../partials/nav.php'; ?>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-content">
        <div class="course-badges">
            <span class="badge">AI &amp; Technology</span>
            <span class="badge">Beginner</span>
        </div>

        <h1>Prompt Engineering for Beginners</h1>

        <p>Learn how to communicate effectively with AI systems like ChatGPT and other large language models to generate accurate, structured, and high-quality outputs.</p>

        <div class="course-stats">
            <div class="stat-item">
                <i class="fa-regular fa-clock"></i>
                <span>3 Weeks</span>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-book"></i>
                <span>1 Full Lesson</span>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-trophy"></i>
                <span>1 Quiz</span>
            </div>
        </div>
    </div>

    <div class="hero-image">
        <div class="image-placeholder">
            <svg class="neural-net" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
                <!-- Connections -->
                <line x1="60" y1="80" x2="180" y2="60" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="60" y1="80" x2="180" y2="150" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="60" y1="150" x2="180" y2="60" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="60" y1="150" x2="180" y2="150" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="60" y1="150" x2="180" y2="240" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="60" y1="220" x2="180" y2="150" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="60" y1="220" x2="180" y2="240" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="180" y1="60" x2="290" y2="80" stroke="rgba(124,58,237,0.25)" stroke-width="1"/>
                <line x1="180" y1="60" x2="290" y2="150" stroke="rgba(124,58,237,0.25)" stroke-width="1"/>
                <line x1="180" y1="150" x2="290" y2="80" stroke="rgba(124,58,237,0.25)" stroke-width="1"/>
                <line x1="180" y1="150" x2="290" y2="150" stroke="rgba(124,58,237,0.25)" stroke-width="1"/>
                <line x1="180" y1="150" x2="290" y2="220" stroke="rgba(124,58,237,0.25)" stroke-width="1"/>
                <line x1="180" y1="240" x2="290" y2="150" stroke="rgba(124,58,237,0.25)" stroke-width="1"/>
                <line x1="180" y1="240" x2="290" y2="220" stroke="rgba(124,58,237,0.25)" stroke-width="1"/>
                <line x1="290" y1="80" x2="360" y2="150" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="290" y1="150" x2="360" y2="150" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <line x1="290" y1="220" x2="360" y2="150" stroke="rgba(99,102,241,0.25)" stroke-width="1"/>
                <!-- Layer 1 nodes -->
                <circle cx="60" cy="80" r="10" fill="rgba(99,102,241,0.6)" stroke="rgba(99,102,241,0.9)" stroke-width="1.5"/>
                <circle cx="60" cy="150" r="10" fill="rgba(99,102,241,0.6)" stroke="rgba(99,102,241,0.9)" stroke-width="1.5"/>
                <circle cx="60" cy="220" r="10" fill="rgba(99,102,241,0.6)" stroke="rgba(99,102,241,0.9)" stroke-width="1.5"/>
                <!-- Layer 2 nodes -->
                <circle cx="180" cy="60" r="10" fill="rgba(124,58,237,0.6)" stroke="rgba(124,58,237,0.9)" stroke-width="1.5"/>
                <circle cx="180" cy="150" r="10" fill="rgba(124,58,237,0.6)" stroke="rgba(124,58,237,0.9)" stroke-width="1.5"/>
                <circle cx="180" cy="240" r="10" fill="rgba(124,58,237,0.6)" stroke="rgba(124,58,237,0.9)" stroke-width="1.5"/>
                <!-- Layer 3 nodes -->
                <circle cx="290" cy="80" r="10" fill="rgba(99,102,241,0.6)" stroke="rgba(99,102,241,0.9)" stroke-width="1.5"/>
                <circle cx="290" cy="150" r="10" fill="rgba(99,102,241,0.6)" stroke="rgba(99,102,241,0.9)" stroke-width="1.5"/>
                <circle cx="290" cy="220" r="10" fill="rgba(99,102,241,0.6)" stroke="rgba(99,102,241,0.9)" stroke-width="1.5"/>
                <!-- Output node -->
                <circle cx="360" cy="150" r="14" fill="rgba(124,58,237,0.8)" stroke="rgba(165,180,252,0.9)" stroke-width="2"/>
            </svg>
            <div class="hero-icon-wrap">
                <i class="fa-solid fa-microchip"></i>
                <span>Neural Language Model</span>
            </div>
        </div>
        <div class="instructor-card"></div>
    </div>
</section>

<!-- TABS -->
<div class="tabs-container">
    <div class="tabs">
        <a href="prompt-eng-nav.php" class="tab active">Overview</a>
        <a href="prompt-eng-materials.php" class="tab">Materials</a>
        <a href="prompt-eng-quiz.php" class="tab">Quizzes</a>
    </div>
</div>

<!-- CONTENT -->
<section class="content-section">
    <h2>About This Course</h2>

    <p class="about-text">
        Prompt engineering is the skill of designing clear and structured instructions for AI systems. The quality of AI output depends heavily on how the request is written.
    </p>

    <p class="about-text">
        This course teaches you how to structure prompts, reduce ambiguity, control output format, and use advanced techniques for better results.
    </p>

    <h3>What You'll Learn:</h3>

    <ul class="learning-list">
        <li>
            <i class="fa-solid fa-check"></i>
            <span>How AI interprets prompts</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Structure of high-quality prompts</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Role prompting techniques</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Few-shot prompting</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Iterative refinement</span>
        </li>
    </ul>
</section>

<!-- FOOTER -->
<?php include '../partials/footer.php'; ?>

</body>
</html>

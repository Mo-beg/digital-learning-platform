<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Psychology of Everyday Decisions - LearnHub</title>

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
    color: #3b82f6;
}

.nav-links a:hover {
    color: #3b82f6;
}

/* BUTTON */
.btn {
    background-color: #3b82f6;
    color: #ffffff;
    border: none;
    padding: 10px 22px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 500;
}

.btn:hover {
    background-color: #2563eb;
}

/* HERO SECTION */
.hero-section {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    padding: 60px 48px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
}

.hero-content {
    flex: 1;
    color: white;
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
}

.hero-buttons {
    display: flex;
    gap: 16px;
}

.btn-primary {
    background: white;
    color: #1e40af;
    padding: 12px 28px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
}

.btn-primary:hover {
    background: #f1f5f9;
}

.btn-secondary {
    background: transparent;
    color: white;
    padding: 12px 28px;
    border-radius: 8px;
    border: 2px solid white;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
}

.hero-image {
    flex: 0 0 400px;
    background: #1e293b;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.image-placeholder {
    width: 100%;
    height: 300px;
    background: #334155;
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
        linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.02) 40%, rgba(255,255,255,0.02) 60%, transparent 60%),
        linear-gradient(-45deg, transparent 40%, rgba(255,255,255,0.02) 40%, rgba(255,255,255,0.02) 60%, transparent 60%);
    background-size: 30px 30px;
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
    box-shadow: 0 1px 3px rgba(59, 130, 246, 0.1);
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
    color: #10b981;
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
    color: #3b82f6;
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
    color: #3b82f6;
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
            <span class="badge">Psychology</span>
            <span class="badge">Beginner</span>
        </div>

        <h1>The Psychology of Everyday Decisions</h1>
        
        <p>Understand why you make the choices you make. This course explores cognitive biases, habits, emotions, and decision-making patterns that influence everyday life - from spending money to scrolling social media.</p>

        <div class="course-stats">
            <div class="stat-item">
                <i class="fa-regular fa-clock"></i>
                <span>4 Weeks</span>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-book"></i>
                <span>3 Materials</span>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-trophy"></i>
                <span>1 Quiz</span>
            </div>
        </div>
    </div>

    <div class="hero-image">
        <div class="image-placeholder">
            <i class="fa-solid fa-brain" style="font-size: 100px; color: #3b82f6;"></i>
        </div>
        <div class="instructor-card">
        </div>
    </div>
</section>

<!-- TABS -->
<div class="tabs-container">
    <div class="tabs">
        <a href="psychology.php" class="tab active">Overview</a>
        <a href="material.php" class="tab">Materials</a>
        <a href="quiz.php" class="tab">Quizzes</a>
    </div>
</div>

<!-- CONTENT -->
<section class="content-section">
    <h2>About This Course</h2>
    
    <p class="about-text">
        Every day, we make hundreds of decisions - what to buy, what to say, what to believe. Most of these choices feel rational, but they are often influenced by hidden psychological patterns.
    </p>
    
    <p class="about-text">
        In this course, you'll explore how cognitive biases, emotions, habits, and social influence shape your decisions. By understanding these patterns, you'll learn how to think more clearly and make smarter choices in daily life.
    </p>

    <h3>What you'll learn:</h3>

    <ul class="learning-list">
        <li>
            <i class="fa-solid fa-check"></i>
            <span>How cognitive biases influence your thinking</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Why habits control many of your decisions</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>The role of emotions in decision-making</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>How social pressure affects choices</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Techniques to improve rational thinking</span>
        </li>
    </ul>
</section>

<!-- FOOTER -->
<?php include '../partials/footer.php'; ?>

</body>
</html>
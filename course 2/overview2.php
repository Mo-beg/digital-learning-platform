<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Management Fundamentals - LearnHub</title>

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
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
}

/* LOGO */
.logo a {
    font-size: 22px;
    font-weight: 700;
    color: #10b981;
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
    color: #10b981;
}

.nav-links a:hover {
    color: #10b981;
}

/* BUTTON */
.btn {
    background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
    color: #ffffff;
    border: none;
    padding: 10px 22px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 500;
}

.btn:hover {
    background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
}

/* HERO SECTION */
.hero-section {
    background: linear-gradient(135deg, #064e3b 0%, #115e59 100%);
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
    background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
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
    text-shadow: 0 0 40px rgba(16, 185, 129, 0.3);
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
    color: #10b981;
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
        linear-gradient(45deg, transparent 40%, rgba(16, 185, 129, 0.02) 40%, rgba(16, 185, 129, 0.02) 60%, transparent 60%),
        linear-gradient(-45deg, transparent 40%, rgba(16, 185, 129, 0.02) 40%, rgba(16, 185, 129, 0.02) 60%, transparent 60%);
    background-size: 30px 30px;
}

.image-placeholder i {
    font-size: 100px;
    color: #10b981;
    position: relative;
    z-index: 1;
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
    box-shadow: 0 1px 3px rgba(16, 185, 129, 0.1);
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
    color: #10b981;
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
    color: #10b981;
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
            <span class="badge">Finance</span>
            <span class="badge">Beginner</span>
        </div>

        <h1>Financial Management Fundamentals</h1>
        
        <p>Master the core principles of money management, budgeting, investments, and risk control. Build a strong financial foundation for personal and professional success.</p>

        <div class="course-stats">
            <div class="stat-item">
                <i class="fa-regular fa-clock"></i>
                <span>4 Weeks</span>
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
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div class="instructor-card">
        </div>
    </div>
</section>

<!-- TABS -->
<div class="tabs-container">
    <div class="tabs">
        <a href="overview2.php" class="tab active">Overview</a>
        <a href="material2.php" class="tab">Materials</a>
        <a href="quiz2.php" class="tab">Quizzes</a>
    </div>
</div>

<!-- CONTENT -->
<section class="content-section">
    <h2>About This Course</h2>
    
    <p class="about-text">
        Financial management is not just about saving money - it is about controlling financial decisions, understanding risk, and building long-term stability.
    </p>
    
    <p class="about-text">
        This course provides practical frameworks for budgeting, investment planning, and financial control.
    </p>

    <h3>What You'll Learn:</h3>

    <ul class="learning-list">
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Structured budgeting systems</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Cash flow management techniques</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Investment fundamentals</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Risk vs return balance</span>
        </li>
        <li>
            <i class="fa-solid fa-check"></i>
            <span>Financial discipline strategies</span>
        </li>
    </ul>
</section>

<!-- FOOTER -->
<?php include '../partials/footer.php'; ?>  

</body>
</html>
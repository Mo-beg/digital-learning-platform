<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Detective: Spot the Fake - LearnHub</title>
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #0f172a; }
        .navbar { background: #1e293b; padding: 16px 48px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(20, 184, 166, 0.1); }
        .logo a { font-size: 22px; font-weight: 700; color: #14b8a6; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .nav-links a { color: #cbd5e1; text-decoration: none; margin: 0 16px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
        .nav-links a i { color: #14b8a6; }
        .nav-links a:hover { color: #14b8a6; }
        .btn { background: linear-gradient(135deg, #0f4c75 0%, #14b8a6 100%); color: #ffffff; border: none; padding: 10px 22px; border-radius: 20px; cursor: pointer; font-weight: 500; }
        .btn:hover { background: linear-gradient(135deg, #0a3455 0%, #0d9488 100%); }
        .hero-section { background: linear-gradient(135deg, #0a1628 0%, #0f2d40 100%); padding: 60px 48px; display: flex; justify-content: space-between; align-items: center; gap: 40px; position: relative; overflow: hidden; }
        .hero-section::before { content: ''; position: absolute; top: -50%; right: -20%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(20, 184, 166, 0.15) 0%, transparent 70%); border-radius: 50%; }
        .hero-content { flex: 1; color: white; position: relative; z-index: 1; }
        .course-badges { display: flex; gap: 12px; margin-bottom: 20px; }
        .badge { background: rgba(255, 255, 255, 0.15); padding: 6px 16px; border-radius: 20px; font-size: 14px; font-weight: 500; }
        .hero-content h1 { font-size: 48px; margin-bottom: 20px; font-weight: 700; text-shadow: 0 0 40px rgba(20, 184, 166, 0.35); }
        .hero-content p { font-size: 18px; margin-bottom: 30px; line-height: 1.6; opacity: 0.95; }
        .course-stats { display: flex; gap: 30px; margin-bottom: 30px; flex-wrap: wrap; }
        .stat-item { display: flex; align-items: center; gap: 8px; font-size: 16px; }
        .stat-item i { font-size: 20px; color: #14b8a6; }
        .hero-image { flex: 0 0 400px; background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4); position: relative; z-index: 1; }
        .image-placeholder { width: 100%; height: 300px; background: #0a1628; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
        .image-placeholder::before { content: ''; position: absolute; width: 100%; height: 100%; background-image: repeating-linear-gradient(0deg, transparent, transparent 28px, rgba(20, 184, 166, 0.04) 28px, rgba(20, 184, 166, 0.04) 30px), repeating-linear-gradient(90deg, transparent, transparent 28px, rgba(20, 184, 166, 0.04) 28px, rgba(20, 184, 166, 0.04) 30px); }
        .hero-icon-wrap { position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; gap: 12px; }
        .hero-icon-wrap i { font-size: 90px; color: #14b8a6; filter: drop-shadow(0 0 20px rgba(20, 184, 166, 0.5)); }
        .hero-icon-wrap span { color: #5eead4; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; }
        .instructor-card { background: #1e293b; }
        .tabs-container { background: #1e293b; padding: 0 48px; }
        .tabs { display: flex; gap: 0; }
        .tab { background: transparent; padding: 16px 40px; font-size: 16px; font-weight: 500; color: #94a3b8; text-decoration: none; cursor: pointer; border-radius: 12px 12px 0 0; transition: all 0.3s; display: inline-block; }
        .tab.active { background: #0f172a; color: #ffffff; }
        .tab:hover { background: #334155; }
        .tab.active:hover { background: #0f172a; }
        .content-section { background: #1e293b; padding: 50px 48px; margin: 0 48px 40px; border-radius: 12px; box-shadow: 0 1px 3px rgba(20, 184, 166, 0.1); border: 1px solid rgba(51, 65, 85, 0.5); }
        .content-section h2 { font-size: 28px; margin-bottom: 20px; color: #ffffff; }
        .about-text { font-size: 16px; color: #cbd5e1; line-height: 1.6; margin-bottom: 30px; }
        .content-section h3 { font-size: 20px; margin-bottom: 20px; color: #ffffff; font-weight: 600; }
        .learning-list { list-style: none; }
        .learning-list li { display: flex; align-items: center; gap: 12px; padding: 12px 0; font-size: 16px; color: #cbd5e1; }
        .learning-list li i { color: #14b8a6; font-size: 20px; }
        .footer { background: #0f172a; color: #cbd5e1; padding: 0; }
        .footer-content {
        padding: 40px 60px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; }
        .footer h4 { color: #14b8a6; margin-bottom: 12px; }
        .footer a { display: block; text-decoration: none; color: #cbd5e1; margin-bottom: 8px; font-size: 14px; }
        .footer a:hover { color: #14b8a6; }
        .footer p { font-size: 14px; margin-bottom: 8px; color: #cbd5e1; }
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
        @media (max-width: 968px) {
            .hero-section { flex-direction: column; padding: 40px 24px; }
            .hero-image { flex: 0 0 auto; width: 100%; max-width: 400px; }
            .hero-content h1 { font-size: 36px; }
            .navbar { padding: 16px 24px; }
            .tabs-container { padding: 0 24px; }
            .content-section { padding: 40px 24px; margin: 0 24px 40px; }
            .footer { padding: 0; }
        }
    </style>
</head>
<body>

<?php include '../partials/nav.php'; ?>

<section class="hero-section">
    <div class="hero-content">
        <div class="course-badges">
            <span class="badge">Cyber Awareness</span>
            <span class="badge">Beginner</span>
        </div>
        <h1>Digital Detective: Spot the Fake</h1>
        <p>Learn how to identify fake news, manipulated images, deepfakes, phishing attempts, and online misinformation using digital verification techniques and critical thinking skills.</p>
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
            <div class="hero-icon-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Cyber Investigation</span>
            </div>
        </div>
        <div class="instructor-card"></div>
    </div>
</section>

<div class="tabs-container">
    <div class="tabs">
        <a href="overview4.php" class="tab active">Overview</a>
        <a href="material4.php" class="tab">Materials</a>
        <a href="quiz4.php" class="tab">Quizzes</a>
    </div>
</div>

<section class="content-section">
    <h2>About This Course</h2>
    <p class="about-text">In the digital world, misinformation spreads faster than facts. Digital Detective teaches you how to verify online content, analyze suspicious posts, detect manipulated media, and avoid scams.</p>
    <p class="about-text">This course develops your critical thinking, verification skills, and digital literacy to help you navigate social media and online platforms safely.</p>
    <h3>What You'll Learn:</h3>
    <ul class="learning-list">
        <li><i class="fa-solid fa-check"></i><span>How misinformation spreads</span></li>
        <li><i class="fa-solid fa-check"></i><span>How to verify online sources</span></li>
        <li><i class="fa-solid fa-check"></i><span>Detecting fake images and deepfakes</span></li>
        <li><i class="fa-solid fa-check"></i><span>Identifying phishing and scams</span></li>
        <li><i class="fa-solid fa-check"></i><span>Building a digital verification checklist</span></li>
    </ul>
</section>

<?php include '../partials/footer.php'; ?>


</body>
</html>
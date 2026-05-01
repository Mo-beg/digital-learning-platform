<?php
/*
 * LEARNING NOTE - AUTH GUARD
 * -------------------------------------------------------------
 * These first few lines run BEFORE any HTML is sent to the browser.
 * PHP always processes <?php ... ?> blocks first.
 *
 * session_start() - opens the "locker" system so we can read
 *   $_SESSION variables that were set during login.
 *
 * require_once - includes another PHP file. Like copy-pasting
 *   its code here. The "../" means "go up one folder".
 *
 * auth_check.php checks: is user logged in AND enrolled?
 *   If not -> it redirects automatically and stops this file.
 * -------------------------------------------------------------
 */
session_start();
require_once "../db.php";
$course_id = 4;
require_once "../partials/auth_check.php";

// Check if this user has already watched the video for this course
// We read the video_watched column from the enrollments table
$uid = $_SESSION["user_id"];
$vstmt = mysqli_prepare($conn,
    "SELECT video_watched FROM enrollments WHERE user_id=? AND course_id=?");
mysqli_stmt_bind_param($vstmt, "ii", $uid, $course_id);
mysqli_stmt_execute($vstmt);
mysqli_stmt_bind_result($vstmt, $video_watched);
mysqli_stmt_fetch($vstmt);
mysqli_stmt_close($vstmt);
// $video_watched is now 1 (watched) or 0 (not yet)
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Materials - Digital Detective - LearnHub</title>
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
        .tabs-container { background: #1e293b; padding: 0 48px; }
        .tabs { display: flex; gap: 0; }
        .tab { background: transparent; padding: 16px 40px; font-size: 16px; font-weight: 500; color: #94a3b8; text-decoration: none; cursor: pointer; border-radius: 12px 12px 0 0; transition: all 0.3s; display: inline-block; }
        .tab.active { background: #0f172a; color: #ffffff; }
        .tab:hover { background: #334155; }
        .tab.active:hover { background: #0f172a; }
        .lesson-container { max-width: 1100px; margin: 0 auto; padding: 50px 48px 80px; }
        .lesson-hero { width: 100%; height: 350px; background: linear-gradient(135deg, #0a1628 0%, #0f2d40 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 50px; position: relative; overflow: hidden; }
        .lesson-hero::before { content: ''; position: absolute; width: 100%; height: 100%; background-image: repeating-linear-gradient(0deg, transparent, transparent 28px, rgba(20, 184, 166, 0.04) 28px, rgba(20, 184, 166, 0.04) 30px), repeating-linear-gradient(90deg, transparent, transparent 28px, rgba(20, 184, 166, 0.04) 28px, rgba(20, 184, 166, 0.04) 30px); }
        .lesson-hero-content { position: relative; z-index: 1; text-align: center; }
        .lesson-hero-content i { font-size: 120px; color: #14b8a6; filter: drop-shadow(0 0 30px rgba(20, 184, 166, 0.6)); margin-bottom: 20px; display: block; }
        .lesson-hero-content p { color: #5eead4; font-size: 18px; }
        .lesson-section { background: #1e293b; padding: 50px; border-radius: 16px; margin-bottom: 30px; border: 1px solid rgba(51, 65, 85, 0.5); }
        .lesson-section.alt { background: #0f172a; }
        .lesson-section h2 { font-size: 32px; color: #ffffff; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; }
        .lesson-section h2 i { color: #14b8a6; font-size: 28px; }
        .lesson-section h3 { font-size: 24px; color: #14b8a6; margin-top: 35px; margin-bottom: 18px; }
        .lesson-section p { font-size: 17px; color: #cbd5e1; line-height: 1.8; margin-bottom: 20px; }
        .lesson-list { list-style: none; margin: 25px 0; }
        .lesson-list li { display: flex; align-items: flex-start; gap: 15px; padding: 14px 0; font-size: 16px; color: #cbd5e1; line-height: 1.7; }
        .lesson-list li i { color: #14b8a6; font-size: 20px; margin-top: 2px; flex-shrink: 0; }
        .highlight-box { background: linear-gradient(135deg, rgba(20, 184, 166, 0.1) 0%, rgba(15, 76, 117, 0.08) 100%); border-left: 4px solid #14b8a6; padding: 25px 30px; margin: 30px 0; border-radius: 8px; }
        .highlight-box h4 { color: #5eead4; font-size: 18px; margin-bottom: 12px; display: flex; align-items: center; gap: 10px; }
        .highlight-box h4 i { font-size: 20px; }
        .highlight-box p { color: #e2e8f0; font-size: 16px; line-height: 1.7; margin: 0; }
        .warning-box { background: rgba(239, 68, 68, 0.07); border-left: 4px solid #f87171; padding: 25px 30px; margin: 30px 0; border-radius: 8px; }
        .warning-box h4 { color: #fca5a5; font-size: 18px; margin-bottom: 12px; display: flex; align-items: center; gap: 10px; }
        .warning-box h4 i { font-size: 20px; }
        .warning-box p { color: #cbd5e1; font-size: 16px; line-height: 1.7; margin: 0; }
        .screenshot-container { background: #0a1628; border: 1px solid rgba(20, 184, 166, 0.25); border-radius: 10px; padding: 0; margin: 20px 0; overflow: hidden; }
        .screenshot-bar { background: #0f2d40; padding: 10px 16px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(20, 184, 166, 0.15); }
        .screenshot-dot { width: 10px; height: 10px; border-radius: 50%; }
        .screenshot-dot.red { background: #f87171; }
        .screenshot-dot.yellow { background: #fbbf24; }
        .screenshot-dot.green { background: #34d399; }
        .screenshot-url { background: #1e293b; border-radius: 4px; padding: 4px 12px; font-size: 12px; color: #64748b; font-family: 'Courier New', monospace; margin-left: 8px; flex: 1; }
        .screenshot-body { padding: 20px 24px; }
        .screenshot-body p { font-size: 15px; color: #94a3b8; line-height: 1.7; margin: 0; }
        .comparison-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 30px 0; }
        .comparison-card { border-radius: 10px; overflow: hidden; }
        .comparison-card .comp-header { padding: 12px 20px; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
        .comparison-card.fake .comp-header { background: rgba(239, 68, 68, 0.15); color: #f87171; border-bottom: 1px solid rgba(239, 68, 68, 0.2); }
        .comparison-card.real .comp-header { background: rgba(20, 184, 166, 0.12); color: #5eead4; border-bottom: 1px solid rgba(20, 184, 166, 0.2); }
        .comparison-card .comp-body { padding: 20px; }
        .comparison-card.fake .comp-body { background: #1a0a0a; border: 1px solid rgba(239, 68, 68, 0.2); border-top: none; border-radius: 0 0 10px 10px; }
        .comparison-card.real .comp-body { background: #0a1628; border: 1px solid rgba(20, 184, 166, 0.2); border-top: none; border-radius: 0 0 10px 10px; }
        .comparison-card .comp-body p { font-size: 15px; line-height: 1.7; margin: 0; }
        .comparison-card.fake .comp-body p { color: #fca5a5; }
        .comparison-card.real .comp-body p { color: #5eead4; }
        .phishing-msg { background: #1a0a0a; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 10px; overflow: hidden; margin: 30px 0; }
        .phishing-msg-header { background: rgba(239, 68, 68, 0.1); padding: 14px 20px; border-bottom: 1px solid rgba(239, 68, 68, 0.2); }
        .phishing-msg-header p { font-size: 13px; color: #94a3b8; margin: 0 0 4px 0; }
        .phishing-msg-header p span { color: #f87171; font-weight: 600; }
        .phishing-msg-body { padding: 20px 24px; }
        .phishing-msg-body p { font-size: 15px; color: #cbd5e1; line-height: 1.8; margin-bottom: 12px; }
        .phishing-msg-body p:last-child { margin-bottom: 0; }
        .phishing-msg-body .phishing-link { color: #f87171; text-decoration: underline; cursor: pointer; }
        .numbered-steps { display: flex; flex-direction: column; gap: 20px; margin: 30px 0; }
        .step-item { background: #0f172a; padding: 25px; border-radius: 12px; display: flex; gap: 20px; align-items: flex-start; border: 1px solid rgba(20, 184, 166, 0.15); }
        .step-number { width: 40px; height: 40px; background: linear-gradient(135deg, #0f4c75 0%, #14b8a6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #ffffff; flex-shrink: 0; }
        .step-content h4 { color: #ffffff; font-size: 18px; margin-bottom: 8px; }
        .step-content p { color: #94a3b8; font-size: 15px; line-height: 1.6; margin: 0; }
        .framework-box { background: #0a1628; border: 2px solid rgba(20, 184, 166, 0.4); border-radius: 14px; padding: 34px 36px; margin: 30px 0; position: relative; overflow: hidden; }
        .framework-box::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #0f4c75 0%, #14b8a6 100%); }
        .framework-label { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #14b8a6; margin-bottom: 18px; }
        .formula-row { display: flex; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
        .formula-tag { background: linear-gradient(135deg, rgba(20, 184, 166, 0.12) 0%, rgba(15, 76, 117, 0.1) 100%); border: 1px solid rgba(20, 184, 166, 0.35); color: #5eead4; padding: 8px 18px; border-radius: 6px; font-size: 15px; font-weight: 600; font-family: 'Courier New', Courier, monospace; }
        .formula-plus { color: #14b8a6; font-size: 22px; font-weight: 700; }
        .framework-box .example-block { background: #1e293b; border-radius: 8px; padding: 20px 24px; margin-top: 10px; }
        .framework-box .example-block p { font-size: 15px; color: #94a3b8; margin-bottom: 8px; line-height: 1.7; }
        .framework-box .example-block p:last-child { margin-bottom: 0; }
        .framework-box .example-block span.field { color: #5eead4; font-weight: 600; }
        .workflow-placeholder { width: 100%; height: 160px; background: #0a1628; border-radius: 10px; border: 1px dashed rgba(20, 184, 166, 0.3); display: flex; align-items: center; justify-content: center; margin: 20px 0; gap: 14px; flex-wrap: wrap; padding: 20px; }
        .workflow-node { background: rgba(20, 184, 166, 0.1); border: 1px solid rgba(20, 184, 166, 0.35); border-radius: 8px; padding: 10px 16px; color: #5eead4; font-size: 13px; font-weight: 600; text-align: center; }
        .workflow-arrow { color: #14b8a6; font-size: 18px; }
        .image-container {
    width: 100%;
    margin: 40px 0;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #1e293b;
    background: #0f172a;
}

.image-container img {
    width: 100%;
    display: block;
}

.image-caption {
    padding: 15px;
    text-align: center;
    color: #14b8a6;
    font-size: 15px;
}

        .section-divider { height: 1px; background: linear-gradient(90deg, transparent 0%, rgba(20, 184, 166, 0.4) 50%, transparent 100%); margin: 50px 0; }
        .quiz-prep-section { background: linear-gradient(135deg, #0a1628 0%, #0f2d40 100%); padding: 50px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 8px 24px rgba(20, 184, 166, 0.15); border: 1px solid rgba(20, 184, 166, 0.15); }
        .quiz-prep-section h2 { color: #ffffff; font-size: 32px; margin-bottom: 15px; }
        .quiz-prep-section > p { color: rgba(255, 255, 255, 0.9); font-size: 17px; margin-bottom: 30px; }
        .quiz-prep-section .lesson-list li { color: #ffffff; }
        .quiz-prep-section .lesson-list li i { color: #fbbf24; }
        .motivational-message { background: rgba(255, 255, 255, 0.07); padding: 20px 25px; border-radius: 10px; margin-top: 30px; text-align: center; border: 1px solid rgba(94, 234, 212, 0.2); }
        .motivational-message p { color: #ffffff; font-size: 18px; font-weight: 500; margin: 0; }
        .references-section { background: #1e293b; padding: 40px 50px; border-radius: 16px; border: 1px solid rgba(51, 65, 85, 0.5); }
        .references-section h2 { color: #ffffff; font-size: 26px; margin-bottom: 20px; }
        .references-section p { color: #94a3b8; font-size: 15px; margin-bottom: 25px; }
        .reference-links { display: flex; flex-direction: column; gap: 15px; }
        .reference-link { display: flex; align-items: center; gap: 12px; color: #14b8a6; text-decoration: none; font-size: 16px; padding: 12px 0; transition: all 0.3s; }
        .reference-link:hover { color: #5eead4; padding-left: 10px; }
        .reference-link i { font-size: 20px; }
        @media (max-width: 768px) {
            .navbar { padding: 16px 24px; }
            .tabs-container { padding: 0 24px; }
            .lesson-container { padding: 30px 24px 60px; }
            .lesson-section { padding: 35px 25px; }
            .lesson-section h2 { font-size: 26px; }
            .lesson-section h3 { font-size: 20px; }
            .lesson-hero { height: 250px; }
            .lesson-hero-content i { font-size: 80px; }
            .quiz-prep-section { padding: 35px 25px; }
            .comparison-grid { grid-template-columns: 1fr; }
            .formula-row { gap: 8px; }
        }
    </style>
</head>
<body>
<?php if (isset($_GET['msg']) && $_GET['msg'] === 'watch_video'): ?>
<div style="
    background: rgba(239,68,68,0.15);
    border: 1px solid rgba(239,68,68,0.5);
    color: #fca5a5;
    padding: 16px 24px;
    text-align: center;
    font-size: 15px;
    font-weight: 500;
">
    <i class="fa-solid fa-lock"></i>
    You must watch the video for at least 90 seconds before taking the quiz.
</div>
<?php endif; ?>

<?php include '../partials/nav.php'; ?>

<div class="tabs-container">
    <div class="tabs">
        <a href="overview4.php" class="tab">Overview</a>
        <a href="material4.php" class="tab active">Materials</a>
        <a href="quiz4.php"     class="tab">Quizzes</a>
    </div>
</div>

<div class="lesson-container">

    <!-- HERO -->
    <div class="lesson-hero">
        <div class="lesson-hero-content">
            <i class="fa-solid fa-magnifying-glass"></i>
            <p>Digital Detective: Spot the Fake</p>
        </div>
    </div>

    <!-- SECTION 1 -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-globe"></i> The Rise of Digital Misinformation</h2>
        <p>We live in an era where a single post can reach millions of people in minutes. Social media platforms, messaging apps, and online news sites have dramatically accelerated the speed at which information travels - and unfortunately, false information travels just as fast, often faster. Understanding this landscape is the first step in defending yourself against it.</p>
        <p>Misinformation is not always created with malicious intent. Sometimes people share content they genuinely believe is true without verifying it first. Other times, deliberately crafted false narratives exploit emotional triggers - fear, anger, outrage - to maximize sharing. Once false content goes viral, it is nearly impossible to fully retract, even when corrections are published.</p>
        <p>The consequences of digital misinformation are real and serious. False health claims have caused people to refuse life-saving treatments. Fabricated political stories have influenced elections. Fake emergency announcements have triggered public panic. The digital information environment demands a new kind of literacy - the ability to critically evaluate what you encounter before you believe or share it.</p>
        <p>This course equips you with a practical toolkit: how to verify sources, detect manipulated media, recognize psychological manipulation tactics, and apply a structured investigation framework to any suspicious content you encounter online.</p>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-triangle-exclamation"></i> Core Awareness</h4>
            <p><strong>Not Everything You See Online Is Real.</strong> A convincing headline, a viral image, or an urgent message does not make something true. Your first instinct should always be to verify - not to share.</p>
        </div>

        
    </section>

    <!-- SECTION 2 -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-shield-halved"></i> How to Verify Online Information</h2>

        <h3>2.1 Check the Source</h3>
        <p>The most fundamental verification step is examining who published the content. Legitimate news organizations have recognizable domain names, editorial standards, and verifiable contact information. Look carefully at the URL - misinformation sites often use domains that closely mimic trusted outlets (e.g., "abcnews.com.co" instead of "abcnews.com"). Check whether the account that posted the content is verified, how old it is, and whether its history is consistent.</p>

        <h3>2.2 Cross-Verification</h3>
        <p>One source is never enough. When you encounter a significant claim, search for the same story across multiple independent and reputable outlets. If a major event occurred, trusted news agencies worldwide would be reporting on it. If only one obscure site is covering it, that is a serious red flag. Use fact-checking organizations such as Snopes, FactCheck.org, or PolitiFact to search for assessments of specific claims.</p>

        <h3>2.3 Date and Context</h3>
        <p>Old content is frequently reshared without its original date, stripped of its original context, and presented as current news to mislead audiences. A video from a protest five years ago might be reposted today with a false caption claiming it happened last week. Always check the original publication date and investigate the full context before drawing conclusions from any piece of media.</p>

        <div class="comparison-grid">
            <div class="comparison-card fake">
                <div class="comp-header"> Fake Headline Example</div>
                <div class="comp-body">
                    <div class="screenshot-container" style="border:none; margin:0;">
                        <div class="screenshot-bar">
                            <span class="screenshot-dot red"></span>
                            <span class="screenshot-dot yellow"></span>
                            <span class="screenshot-dot green"></span>
                            <span class="screenshot-url">breaking-news-today247.net</span>
                        </div>
                        <div class="screenshot-body">
                            <p><strong style="color:#f87171;">BREAKING: Government Secretly Adds Chemicals to Drinking Water - Leaked Documents Prove It</strong><br><br>
                            Shared 847K times * Posted 3 hours ago * No author listed * No references * Urgent share request</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comparison-card real">
                <div class="comp-header"> Verified News Breakdown</div>
                <div class="comp-body">
                    <div class="screenshot-container" style="border:none; margin:0;">
                        <div class="screenshot-bar">
                            <span class="screenshot-dot red"></span>
                            <span class="screenshot-dot yellow"></span>
                            <span class="screenshot-dot green"></span>
                            <span class="screenshot-url">reuters.com * Verified</span>
                        </div>
                        <div class="screenshot-body">
                            <p><strong style="color:#5eead4;">Water Safety Report: Routine Chlorination Levels Reviewed by EPA</strong><br><br>
                            Published by Reuters * Authored journalist * Linked to official EPA report * Corroborated by WHO * No urgent share request</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 3 -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-image"></i> Spotting Fake Images &amp; Deepfakes</h2>

        <p>Visual media is among the most powerful and most frequently manipulated forms of online content. A single edited photograph or AI-generated video can spread globally within hours and alter public perception of events, people, and organizations. Understanding how to evaluate visual content is an essential modern skill.</p>

        <h3>Reverse Image Search</h3>
        <p>Reverse image search allows you to upload or paste an image into a search engine (Google Images, TinEye, or Bing Visual Search) to find where it originally appeared online. This technique quickly reveals whether an image is being used in a false context - for example, a photograph from a 2010 flood being recirculated as evidence of a current disaster.</p>

        <h3>Signs of Edited Photos</h3>
        <p>Digitally manipulated images often contain subtle visual artifacts that reveal tampering. Look for inconsistent lighting and shadow directions across different elements in the image. Examine edges of people or objects - over-sharpened or blurry outlines suggest cut-and-paste editing. Backgrounds with unnatural repetition, distorted architectural lines, or pixelation around specific areas are additional indicators of image manipulation.</p>

        <h3>Basic Deepfake Indicators</h3>
        <p>Deepfakes are AI-generated videos where a person's face, voice, or both have been synthetically altered. Early deepfakes showed obvious artifacts - unnatural blinking patterns, facial edges that blur or shimmer during head movement, inconsistent skin tone under different lighting, and audio that does not perfectly match lip movements. As technology improves, these indicators become subtler, making critical evaluation more important than ever.</p>
  <div class="image-container">
    <img src="../image/course4deepfake.jpg" alt="Deepfake Example">
    <div class="image-caption">Image with suspicious shadows / distorted facial features - Deepfake Example</div>
  </div>
    <div class="highlight-box">
            <h4><i class="fa-solid fa-eye"></i> Why Visual Manipulation Is Dangerous</h4>
            <p>Human brains are wired to trust visual information. We instinctively believe what we see far more readily than what we read. This cognitive bias makes manipulated images and deepfakes uniquely effective as misinformation tools. A fabricated image of a public figure in a compromising situation can permanently damage reputations before any correction reaches a fraction of the original audience.</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 4 -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-fish"></i> Phishing &amp; Online Scams</h2>

        <p>Phishing is a social engineering attack in which a malicious actor impersonates a trusted entity - a bank, a government agency, a tech company, or even a friend - to trick you into revealing sensitive information or clicking a harmful link. It is one of the most common and effective forms of cybercrime because it exploits human psychology rather than technical vulnerabilities.</p>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-triangle-exclamation"></i><span><strong>Fake Emails:</strong> Phishing emails are designed to look identical to legitimate communications. They copy logos, formatting, and sender names. Always verify the actual email address - not just the display name - before trusting any message.</span></li>
            <li><i class="fa-solid fa-triangle-exclamation"></i><span><strong>Urgent Language Tactics:</strong> Phrases like "Your account will be suspended in 24 hours," "Immediate action required," or "You have been selected" create artificial panic that overrides rational thinking and rushes you into clicking without verifying.</span></li>
            <li><i class="fa-solid fa-triangle-exclamation"></i><span><strong>Suspicious Links:</strong> Hover over any link before clicking it. The displayed URL and the actual destination URL are often different in phishing attempts. Watch for subtle misspellings like "paypa1.com" or "arnazon.com".</span></li>
            <li><i class="fa-solid fa-triangle-exclamation"></i><span><strong>Impersonation Scams:</strong> Scammers impersonate banks, government tax agencies, tech support teams, or trusted contacts. They may know your name, partial account details, or other information gathered from data breaches to make their approach seem legitimate.</span></li>
        </ul>

        <div class="phishing-msg">
            <div class="phishing-msg-header">
                <p><strong style="color:#f87171;"> Real-World Phishing Example</strong></p>
                <p>From: <span>security-alert@paypa1-support.com</span> &nbsp;|&nbsp; Subject: <span>URGENT: Your Account Has Been Compromised</span></p>
            </div>
            <div class="phishing-msg-body">
                <p>Dear Valued Customer,</p>
                <p>We have detected suspicious activity on your PayPal account. Your account has been <strong style="color:#f87171;">temporarily limited</strong> and will be permanently closed within <strong style="color:#f87171;">12 hours</strong> unless you verify your identity immediately.</p>
                <p>Click the link below to confirm your details and restore full access:</p>
                <p><span class="phishing-link">-> http://paypa1-secure-verify.net/confirm?id=93821</span></p>
                <p style="color:#64748b; font-size:13px;"> Red flags: Misspelled domain (paypa1), artificial urgency, suspicious external link, no personalization, threat of account closure.</p>
            </div>
        </div>

        <div class="warning-box">
            <h4><i class="fa-solid fa-lock"></i> Phishing Defence Rule</h4>
            <p>Legitimate organizations - banks, governments, tech companies - will <strong>never</strong> ask you to provide passwords, PINs, or sensitive account information via email or unsolicited messages. When in doubt, navigate directly to the official website by typing the address yourself.</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 5 -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-brain"></i> Psychological Tricks Behind Fake Content</h2>

        <p>Effective misinformation does not rely solely on false facts - it is engineered to exploit predictable patterns in human psychology. Understanding these mechanisms gives you the cognitive tools to recognize when you are being manipulated, regardless of whether the specific claim is one you have seen before.</p>

        <div class="numbered-steps">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Emotional Manipulation</h4>
                    <p>Content designed to provoke intense emotions - outrage, fear, disgust, or excitement - bypasses rational evaluation. When you feel a strong emotional reaction to content, that is precisely the moment to slow down and verify rather than react and share.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Fear-Based Headlines</h4>
                    <p>Fear is the most powerful emotional trigger for viral spread. Headlines that warn of immediate, catastrophic, or hidden threats create an urgency response that overrides critical thinking. "They don't want you to know this" and "What the media is hiding" are classic fear-based manipulation formats.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Confirmation Bias</h4>
                    <p>People naturally gravitate toward information that confirms what they already believe. Misinformation creators deliberately target existing beliefs and biases, making false content feel intuitively true to the intended audience. If content perfectly confirms everything you already think - be especially skeptical.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Clickbait Strategy</h4>
                    <p>Clickbait uses deliberately incomplete or misleading framing to generate clicks. Headlines like "You Won't Believe What This Celebrity Did" withhold information to exploit curiosity. The content rarely delivers on the headline's implied promise and often contains embedded misinformation or advertising.</p>
                </div>
            </div>
        </div>

        <div class="workflow-placeholder">
            <div class="workflow-node">Emotional Trigger</div>
            <div class="workflow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="workflow-node">Rational Bypass</div>
            <div class="workflow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="workflow-node">Impulsive Share</div>
            <div class="workflow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="workflow-node">Misinformation Spreads</div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 6 -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-list-check"></i> Digital Detective Framework</h2>

        <p>The most reliable way to evaluate any suspicious online content is to apply a consistent, structured investigation process. This framework condenses the verification principles from this course into a single repeatable formula that works across news articles, social media posts, images, videos, and messages.</p>

        <div class="framework-box">
            <div class="framework-label">The Digital Detective Investigation Formula</div>
            <div class="formula-row">
                <span class="formula-tag">Source</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Evidence</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Context</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Intent</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Verification</span>
            </div>
            <div class="example-block">
                <p><span class="field">Source:</span> Who published this? Is the domain legitimate? Is the account verified and established?</p>
                <p><span class="field">Evidence:</span> What proof is offered? Are there links to primary documents, official statements, or expert testimony?</p>
                <p><span class="field">Context:</span> When was this created? Is it being shared with its original context, or has it been stripped and reframed?</p>
                <p><span class="field">Intent:</span> What does this content want you to feel or do? Does it push toward a specific emotional reaction or action?</p>
                <p><span class="field">Verification:</span> Can this be confirmed by three or more independent reputable sources? What do fact-checkers say?</p>
            </div>
        </div>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-magnifying-glass-chart"></i> Real-World Case: Applying the Framework</h4>
            <p>A viral post claims: <em>"Scientists confirm drinking lemon water cures cancer - Big Pharma is suppressing the cure."</em><br><br>
            <strong>Source:</strong> Unknown blog, no author. <strong>Evidence:</strong> No study citation, no institution named. <strong>Context:</strong> Post date unclear, reshared thousands of times. <strong>Intent:</strong> Creates fear of institutions, implies conspiracy. <strong>Verification:</strong> No credible medical or scientific source confirms this claim. <strong>Verdict: Misinformation.</strong></p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 7 -->
    <section class="quiz-prep-section">
        <h2>Final Investigation Review: Before Taking the Quiz</h2>
        <p>Review these essential digital verification principles before testing your knowledge.</p>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-star"></i> The first step in verifying information is always to perform a <strong>Source Check</strong> - examine who published the content and whether the domain or account is credible.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Cross-Verification</strong> means confirming a claim across multiple independent and reputable sources - one source is never sufficient proof.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Reverse Search</strong> (reverse image search) allows you to find the original context and publication source of any image circulating online.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Context</strong> matters critically - old content is frequently reshared without its original date to mislead audiences about current events.</li>
            <li><i class="fa-solid fa-star"></i> A <strong>Deepfake</strong> is an AI-generated video or image in which a person's appearance or voice has been synthetically manipulated.</li>
            <li><i class="fa-solid fa-star"></i> Phishing emails use <strong>urgent language</strong> and impersonation to psychologically pressure targets into revealing sensitive information or clicking harmful links.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Emotional manipulation</strong> and fear-based headlines are deliberately designed to bypass rational thinking and trigger impulsive sharing behavior.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Confirmation bias</strong> makes people more likely to believe misinformation that aligns with their existing beliefs - always apply the same scrutiny regardless of whether you agree with the content.</li>
            <li><i class="fa-solid fa-star"></i> The Digital Detective Framework is: <strong>Source + Evidence + Context + Intent + Verification</strong>.</li>
            <li><i class="fa-solid fa-star"></i> Legitimate organizations never request passwords or sensitive data via unsolicited email or messages - always navigate directly to official websites to verify claims.</li>
        </ul>

        <div class="motivational-message">
            <p> You now have the tools to think like a Digital Detective. Question everything, verify before sharing, and help stop the spread of misinformation. Take the quiz to prove your investigative skills!</p>
        </div>
    </section>

    <!-- SECTION 8 -->
    <section class="references-section">
        <h2>Reference Resources</h2>
        <p>Explore these additional materials to strengthen your digital verification knowledge:</p>
        <div class="reference-links">
            <a href="https://www.snopes.com" target="_blank" class="reference-link">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Snopes - Fact-Checking Organization</span>
            </a>
            <a href="https://newslit.org" target="_blank" class="reference-link">
                <i class="fa-solid fa-book"></i>
                <span>News Literacy Project - Media Literacy Guide</span>
            </a>
            <a href="https://www.youtube.com/results?search_query=cyber+awareness+misinformation+tutorial" target="_blank" class="reference-link">
                <i class="fa-solid fa-video"></i>
                <span>Cyber Awareness &amp; Digital Verification Tutorial Video</span>
            </a>
        </div>
    </section>


    <!-- ==========================================================
         VIDEO SECTION - Watch to unlock the quiz
         LEARNING NOTE (HTML/PHP mix):
           - PHP  blocks can appear INSIDE HTML
           - The browser only sees the final HTML output
           - PHP runs on the server and replaces itself with HTML
         ========================================================== -->
    <section class="video-section" id="videoSection" style="
        background: #1e293b;
        padding: 50px;
        border-radius: 16px;
        margin-bottom: 30px;
        border: 1px solid rgba(51,65,85,0.5);
        text-align: center;
    ">
        <h2 style="color:#fff; font-size:28px; margin-bottom:10px;">
            <i class="fa-brands fa-youtube" style="color:#ef4444"></i>
            Watch the Video
        </h2>
        <p style="color:#94a3b8; margin-bottom:30px; font-size:15px;">
            Watch at least <strong style="color:#3b82f6">90 seconds</strong>
            to unlock the quiz below.
        </p>

        <!-- YouTube embed - runs LIVE on your website -->
        <!-- The iframe loads YouTube's player inside your page -->
        <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:12px; margin-bottom:30px;">
            <iframe
                id="ytPlayer" 
                src="https://www.youtube.com/embed/EHqXMxY4_Nk?enablejsapi=1&origin=http://localhost"
                style="position:absolute; top:0; left:0; width:100%; height:100%; border:none; border-radius:12px;"
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>

        <!-- Watch status message - changes dynamically with JavaScript -->
        <div id="watchStatus" style="margin-bottom:24px;">
            <?php if ($video_watched): ?>
                <!-- PHP already knows they watched it - show green tick -->
                <div style="background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.4);
                     padding:14px 24px; border-radius:8px; color:#6ee7b7; font-size:16px; display:inline-block;">
                    <i class="fa-solid fa-circle-check"></i>
                    Video watched! Quiz is unlocked.
                </div>
            <?php else: ?>
                <!-- Not watched yet - JS will update this message -->
                <div id="watchMsg" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3);
                     padding:14px 24px; border-radius:8px; color:#fca5a5; font-size:16px; display:inline-block;">
                    <i class="fa-solid fa-clock"></i>
                    <span id="watchText">Watch the video to unlock the quiz (0s / 90s)</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quiz button - disabled until video is watched -->
        <a href="quiz4.php"
           id="quizBtn"
           <?php if (!$video_watched): ?>
               onclick="return checkVideoWatched(event)"
           <?php endif; ?>
           style="
               display:inline-block;
               background: <?php echo $video_watched ? 'linear-gradient(135deg,#10b981,#059669)' : '#334155'; ?>;
               color: <?php echo $video_watched ? '#fff' : '#64748b'; ?>;
               padding: 14px 40px;
               border-radius: 8px;
               text-decoration: none;
               font-size: 16px;
               font-weight: 600;
               transition: all 0.3s;
               cursor: <?php echo $video_watched ? 'pointer' : 'not-allowed'; ?>;
           ">
            <i class="fa-solid fa-pen-to-square"></i>
            <?php echo $video_watched ? 'Take the Quiz ->' : 'Quiz Locked - Watch Video First'; ?>
        </a>
    </section>

    <script>
    /*
     * LEARNING NOTE - JavaScript on this page does 3 things:
     *
     * 1. Uses the YouTube IFrame API to detect how long the video
     *    has been playing (YouTube sends events to our page)
     *
     * 2. When watch time reaches 15 seconds -> calls our PHP file
     *    mark_watched.php using fetch() (this is called an AJAX call -
     *    it talks to the server WITHOUT reloading the page)
     *
     * 3. Updates the button and message on screen so the user
     *    can click "Take the Quiz"
     */

    let watchedSeconds = 0;
    let watchTimer     = null;
    let alreadyMarked  = <?php echo $video_watched ? 'true' : 'false'; ?>;
    const REQUIRED_SEC = 90;
    const COURSE_ID    = 4;

    // YouTube IFrame API - loaded asynchronously
    // When it's ready, it calls this function automatically
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    document.head.appendChild(tag);

    var player;
    function onYouTubeIframeAPIReady() {
        // Connect to the iframe we created above
        player = new YT.Player('ytPlayer', {
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.PLAYING) {
            // Video started playing - count seconds
            watchTimer = setInterval(function() {
                if (alreadyMarked) { clearInterval(watchTimer); return; }
                watchedSeconds++;
                updateWatchDisplay();
                if (watchedSeconds >= REQUIRED_SEC) {
                    clearInterval(watchTimer);
                    markVideoWatched();
                }
            }, 1000);
        } else {
            // Video paused or stopped - stop counting
            clearInterval(watchTimer);
        }
    }

    function updateWatchDisplay() {
        var el = document.getElementById('watchText');
        if (el) el.textContent = 'Watch the video to unlock the quiz (' + watchedSeconds + 's / ' + REQUIRED_SEC + 's)';
    }

    function markVideoWatched() {
        // fetch() sends a POST request to mark_watched.php
        // This is AJAX - page doesn't reload, just sends data in background
        fetch('/digital learning platform/mark_watched.php', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ course_id: COURSE_ID })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alreadyMarked = true;
                unlockQuizButton();
            }
        });
    }

    function unlockQuizButton() {
        // Update the status message to green
        document.getElementById('watchMsg').innerHTML = '<i class="fa-solid fa-circle-check"></i> Video watched! Quiz is unlocked.';
        document.getElementById('watchMsg').style.background = 'rgba(16,185,129,0.15)';
        document.getElementById('watchMsg').style.border     = '1px solid rgba(16,185,129,0.4)';
        document.getElementById('watchMsg').style.color      = '#6ee7b7';

        // Enable the quiz button
        var btn = document.getElementById('quizBtn');
        btn.style.background = 'linear-gradient(135deg,#10b981,#059669)';
        btn.style.color      = '#fff';
        btn.style.cursor     = 'pointer';
        btn.textContent      = 'Take the Quiz ->';
        btn.removeAttribute('onclick');
    }

    function checkVideoWatched(e) {
        if (!alreadyMarked) {
            e.preventDefault();
            alert('Please watch the video for at least 15 seconds to unlock the quiz.');
            return false;
        }
        return true;
    }
    </script>
</div>
</body>
</html>
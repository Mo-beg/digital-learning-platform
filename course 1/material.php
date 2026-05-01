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
$course_id = 1;
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
    <title>Course Materials - LearnHub</title>

    <!-- Font Awesome -->
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

/* LESSON CONTAINER */
.lesson-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 50px 48px 80px;
}

/* HERO IMAGE */
.lesson-hero {
    width: 100%;
    height: 350px;
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 50px;
    position: relative;
    overflow: hidden;
}

.lesson-hero::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(45deg, transparent 40%, rgba(59, 130, 246, 0.03) 40%, rgba(59, 130, 246, 0.03) 60%, transparent 60%),
        linear-gradient(-45deg, transparent 40%, rgba(59, 130, 246, 0.03) 40%, rgba(59, 130, 246, 0.03) 60%, transparent 60%);
    background-size: 40px 40px;
}

.lesson-hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.lesson-hero-content i {
    font-size: 120px;
    color: #3b82f6;
    margin-bottom: 20px;
}

.lesson-hero-content p {
    color: #cbd5e1;
    font-size: 18px;
}

/* SECTION */
.lesson-section {
    background: #1e293b;
    padding: 50px;
    border-radius: 16px;
    margin-bottom: 30px;
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.lesson-section.alt {
    background: #0f172a;
}

.lesson-section h2 {
    font-size: 32px;
    color: #ffffff;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.lesson-section h2 i {
    color: #3b82f6;
    font-size: 28px;
}

.lesson-section h3 {
    font-size: 24px;
    color: #3b82f6;
    margin-top: 35px;
    margin-bottom: 18px;
}

.lesson-section p {
    font-size: 17px;
    color: #cbd5e1;
    line-height: 1.8;
    margin-bottom: 20px;
}

/* BULLET LISTS */
.lesson-list {
    list-style: none;
    margin: 25px 0;
}

.lesson-list li {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 14px 0;
    font-size: 16px;
    color: #cbd5e1;
    line-height: 1.7;
}

.lesson-list li i {
    color: #10b981;
    font-size: 20px;
    margin-top: 2px;
    flex-shrink: 0;
}

/* HIGHLIGHT BOX */
.highlight-box {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
    border-left: 4px solid #3b82f6;
    padding: 25px 30px;
    margin: 30px 0;
    border-radius: 8px;
}

.highlight-box h4 {
    color: #3b82f6;
    font-size: 18px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.highlight-box h4 i {
    font-size: 20px;
}

.highlight-box p {
    color: #e2e8f0;
    font-size: 16px;
    line-height: 1.7;
    margin: 0;
}

/* EXAMPLE BOX */
.example-box {
    background: rgba(16, 185, 129, 0.08);
    border-left: 4px solid #10b981;
    padding: 25px 30px;
    margin: 30px 0;
    border-radius: 8px;
}

.example-box h4 {
    color: #10b981;
    font-size: 18px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.example-box h4 i {
    font-size: 20px;
}

.example-box p {
    color: #cbd5e1;
    font-size: 16px;
    line-height: 1.7;
    margin: 0;
}

/* COMPARISON TABLE */
.comparison-table {
    width: 100%;
    margin: 30px 0;
    border-collapse: collapse;
    background: #0f172a;
    border-radius: 12px;
    overflow: hidden;
}

.comparison-table th {
    background: #334155;
    color: #ffffff;
    padding: 18px 20px;
    text-align: left;
    font-size: 16px;
    font-weight: 600;
}

.comparison-table td {
    padding: 18px 20px;
    border-bottom: 1px solid rgba(51, 65, 85, 0.5);
    color: #cbd5e1;
    font-size: 15px;
    line-height: 1.6;
}

.comparison-table tr:last-child td {
    border-bottom: none;
}

/* IMAGE PLACEHOLDER */
.image-placeholder {
    width: 100%;
    height: 280px;
    background: #334155;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 40px 0;
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

.image-placeholder i {
    font-size: 80px;
    color: #475569;
    position: relative;
    z-index: 1;
    margin-bottom: 15px;
}

.image-placeholder p {
    color: #94a3b8;
    font-size: 16px;
    position: relative;
    z-index: 1;
    margin: 0;
}

/* SECTION DIVIDER */
.section-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(59, 130, 246, 0.3) 50%, transparent 100%);
    margin: 50px 0;
}

/* QUIZ PREP SECTION */
.quiz-prep-section {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    padding: 50px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
}

.quiz-prep-section h2 {
    color: #ffffff;
    font-size: 32px;
    margin-bottom: 15px;
}

.quiz-prep-section > p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 17px;
    margin-bottom: 30px;
}

.quiz-prep-section .lesson-list li {
    color: #ffffff;
}

.quiz-prep-section .lesson-list li i {
    color: #fbbf24;
}

.motivational-message {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px 25px;
    border-radius: 10px;
    margin-top: 30px;
    text-align: center;
}

.motivational-message p {
    color: #ffffff;
    font-size: 18px;
    font-weight: 500;
    margin: 0;
}

/* REFERENCES SECTION */
.references-section {
    background: #1e293b;
    padding: 40px 50px;
    border-radius: 16px;
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.references-section h2 {
    color: #ffffff;
    font-size: 26px;
    margin-bottom: 20px;
}

.references-section p {
    color: #94a3b8;
    font-size: 15px;
    margin-bottom: 25px;
}

.reference-links {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.reference-link {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #3b82f6;
    text-decoration: none;
    font-size: 16px;
    padding: 12px 0;
    transition: all 0.3s;
}

.reference-link:hover {
    color: #60a5fa;
    padding-left: 10px;
}

.reference-link i {
    font-size: 20px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .navbar {
        padding: 16px 24px;
    }

    .tabs-container {
        padding: 0 24px;
    }

    .lesson-container {
        padding: 30px 24px 60px;
    }

    .lesson-section {
        padding: 35px 25px;
    }

    .lesson-section h2 {
        font-size: 26px;
    }

    .lesson-section h3 {
        font-size: 20px;
    }

    .lesson-hero {
        height: 250px;
    }

    .lesson-hero-content i {
        font-size: 80px;
    }

    .quiz-prep-section {
        padding: 35px 25px;
    }

    .comparison-table {
        font-size: 14px;
    }

    .comparison-table th,
    .comparison-table td {
        padding: 12px 15px;
    }
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

<!-- NAVBAR -->
<?php include '../partials/nav.php'; ?>

<!-- TABS -->
<div class="tabs-container">
    <div class="tabs">
        <a href="psychology.php" class="tab">Overview</a>
        <a href="material.php" class="tab active">Materials</a>
        <a href="quiz.php" class="tab">Quizzes</a>
    </div>
</div>

<!-- LESSON CONTENT -->
<div class="lesson-container">

    <!-- HERO IMAGE -->
    <div class="lesson-hero">
        <div class="lesson-hero-content">
            <i class="fa-solid fa-brain"></i>
            <p>The Psychology of Everyday Decisions</p>
        </div>
    </div>

    <!-- 1. INTRODUCTION SECTION -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-lightbulb"></i> Introduction: Why Your Decisions Matter</h2>
        
        <p>
            Every single day, you make thousands of decisions. Some are small-like what to eat for breakfast or which route to take to work. Others are bigger-choosing a career, deciding how to spend money, or navigating relationships. Most of these choices feel logical and intentional, but the truth is far more complex.
        </p>

        <p>
            Beneath the surface of every decision lies a hidden web of psychological patterns. Cognitive biases distort how you process information. Emotions override logical thinking. Habits automate your responses. Social pressures shape your preferences. These invisible forces work together to guide your choices-often without you even noticing.
        </p>

        <p>
            Understanding how your mind really works is the first step toward making better decisions. In this course, you'll explore the psychological mechanisms behind everyday choices. You'll learn to recognize the biases that cloud your judgment, understand why emotions sometimes take control, and discover practical strategies for clearer thinking.
        </p>

        <p>
            By the end of this lesson, you won't just understand decision-making-you'll understand yourself better. And that awareness is the foundation of smarter, more intentional choices in every area of your life.
        </p>
    </section>

    <!-- 2. CORE CONCEPTS SECTION -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-brain"></i> Core Concepts: Understanding Cognitive Biases</h2>

        <h3>What Are Cognitive Biases?</h3>
        <p>
            Cognitive biases are systematic patterns of thinking that cause you to make irrational judgments. They're mental shortcuts your brain uses to process information quickly-but these shortcuts often lead to flawed conclusions. Biases affect everyone, regardless of intelligence or education.
        </p>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-key"></i> Key Takeaway</h4>
            <p>Cognitive biases are not character flaws-they're features of how the human brain evolved to make fast decisions with limited information. Recognizing them is the first step to overcoming them.</p>
        </div>

        <h3>1. Confirmation Bias</h3>
        <p>
            Confirmation bias is the tendency to search for, interpret, and remember information that confirms what you already believe. When you hold a strong opinion, your brain automatically filters evidence to support it-and dismisses contradictory information.
        </p>

        <div class="example-box">
            <h4><i class="fa-solid fa-lightbulb"></i> Real-Life Example</h4>
            <p>
                Imagine you believe that a particular diet is the healthiest option. You'll naturally notice news articles and social media posts that praise this diet while ignoring scientific studies that question its effectiveness. Your brain reinforces your belief by cherry-picking supportive evidence.
            </p>
        </div>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-check"></i> Confirmation bias makes it difficult to change your mind, even when presented with strong opposing evidence.</li>
            <li><i class="fa-solid fa-check"></i> It contributes to polarized thinking in politics, relationships, and personal beliefs.</li>
            <li><i class="fa-solid fa-check"></i> To counter it, actively seek out perspectives that challenge your views.</li>
        </ul>

        <h3>2. Anchoring Bias</h3>
        <p>
            Anchoring bias occurs when you rely too heavily on the first piece of information you encounter. That initial "anchor" sets a mental reference point that influences all subsequent judgments-even if the anchor is completely irrelevant.
        </p>

        <div class="example-box">
            <h4><i class="fa-solid fa-lightbulb"></i> Real-Life Example</h4>
            <p>
                You walk into a store and see a jacket originally priced at $300, now marked down to $150. The $300 anchor makes $150 seem like a great deal-even if the jacket is only worth $100. The first number you saw shaped your perception of value.
            </p>
        </div>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-check"></i> Retailers use anchoring to make prices seem more attractive through "original price" comparisons.</li>
            <li><i class="fa-solid fa-check"></i> In negotiations, the first number mentioned often sets the tone for the entire discussion.</li>
            <li><i class="fa-solid fa-check"></i> To avoid anchoring, consider the true value of something before seeing any prices or suggested numbers.</li>
        </ul>

        <h3>3. Availability Bias</h3>
        <p>
            Availability bias is the tendency to overestimate the likelihood of events based on how easily examples come to mind. If something is memorable or recent, your brain assumes it's more common than it actually is.
        </p>

        <div class="example-box">
            <h4><i class="fa-solid fa-lightbulb"></i> Real-Life Example</h4>
            <p>
                After hearing about a plane crash on the news, you might feel that flying is extremely dangerous-even though statistically, driving a car is far more risky. The vivid news story makes plane crashes feel more common than they are.
            </p>
        </div>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-check"></i> Media coverage amplifies availability bias by repeatedly showing dramatic but rare events.</li>
            <li><i class="fa-solid fa-check"></i> Personal experiences also distort probability-if you know someone who won the lottery, you might think it's easier to win than it really is.</li>
            <li><i class="fa-solid fa-check"></i> To counter this bias, seek out statistical data rather than relying on memorable stories.</li>
        </ul>

        <div style="background:#0f172a; border-radius:12px; padding:30px; margin:30px 0;">
    <h4 style="color:#3b82f6; text-align:center; margin-bottom:20px; font-size:18px;">
        <i class="fa-solid fa-brain"></i> The 3 Core Cognitive Biases
    </h4>
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
        <div style="background:#1e293b; border-radius:10px; padding:20px; border-top:4px solid #ef4444; text-align:center;">
            <div style="font-size:32px; margin-bottom:8px;">🎯</div>
            <div style="color:#ef4444; font-weight:700; margin-bottom:6px;">Confirmation Bias</div>
            <div style="color:#94a3b8; font-size:13px;">We seek information that confirms what we already believe</div>
        </div>
        <div style="background:#1e293b; border-radius:10px; padding:20px; border-top:4px solid #f59e0b; text-align:center;">
            <div style="font-size:32px; margin-bottom:8px;">⚓</div>
            <div style="color:#f59e0b; font-weight:700; margin-bottom:6px;">Anchoring Bias</div>
            <div style="color:#94a3b8; font-size:13px;">First information seen becomes the reference for all decisions</div>
        </div>
        <div style="background:#1e293b; border-radius:10px; padding:20px; border-top:4px solid #10b981; text-align:center;">
            <div style="font-size:32px; margin-bottom:8px;">📰</div>
            <div style="color:#10b981; font-weight:700; margin-bottom:6px;">Availability Bias</div>
            <div style="color:#94a3b8; font-size:13px;">Memorable events feel more common than they really are</div>
        </div>
    </div>
</div>
    </section>

    <div class="section-divider"></div>

    <!-- 3. DEEP UNDERSTANDING SECTION -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-rotate"></i> The Power of Habit Loops</h2>

        <h3>How Habits Control Your Decisions</h3>
        <p>
            Habits are automatic behaviors triggered by specific cues. Once a habit is formed, your brain no longer needs to make a conscious decision-it simply follows the established pattern. This saves mental energy, but it also means many of your daily choices are made on autopilot.
        </p>

        <p>
            Every habit follows a three-step loop: <strong>Cue -> Routine -> Reward</strong>. Understanding this structure is key to changing unwanted behaviors and building better ones.
        </p>

        <table class="comparison-table">
            <thead>
                <tr>
                    <th>Stage</th>
                    <th>Description</th>
                    <th>Example</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Cue</strong></td>
                    <td>A trigger that initiates the behavior</td>
                    <td>Feeling stressed at work</td>
                </tr>
                <tr>
                    <td><strong>Routine</strong></td>
                    <td>The automatic behavior itself</td>
                    <td>Scrolling through social media</td>
                </tr>
                <tr>
                    <td><strong>Reward</strong></td>
                    <td>The benefit your brain receives</td>
                    <td>Temporary distraction and dopamine hit</td>
                </tr>
            </tbody>
        </table>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-key"></i> Key Takeaway</h4>
            <p>Habits are not about willpower-they're about pattern recognition. To change a habit, you need to identify the cue and replace the routine while keeping the same reward.</p>
        </div>

        <h3>Breaking Bad Habits</h3>
        <ul class="lesson-list">
            <li><i class="fa-solid fa-check"></i> <strong>Identify the cue:</strong> What triggers the unwanted behavior? Is it a time of day, an emotion, or a specific location?</li>
            <li><i class="fa-solid fa-check"></i> <strong>Keep the reward:</strong> Your brain needs the same benefit, so find a healthier routine that delivers it.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Replace the routine:</strong> Instead of scrolling social media when stressed, try a 5-minute walk or deep breathing.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Be patient:</strong> It takes time for your brain to rewire the habit loop-consistency is more important than perfection.</li>
        </ul>

        <div style="background:#0f172a; border-radius:12px; padding:30px; margin:30px 0; text-align:center;">
    <h4 style="color:#3b82f6; margin-bottom:24px; font-size:18px;">
        <i class="fa-solid fa-rotate"></i> The Habit Loop
    </h4>
    <div style="display:flex; justify-content:center; align-items:center; gap:0; flex-wrap:wrap;">
        <div style="background:#1e3a8a; border-radius:50%; width:120px; height:120px; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:10px;">
            <div style="font-size:28px;">🔔</div>
            <div style="color:#fff; font-weight:700; font-size:14px; margin-top:4px;">CUE</div>
            <div style="color:#93c5fd; font-size:11px;">Trigger</div>
        </div>
        <div style="color:#3b82f6; font-size:28px; padding:0 8px;">→</div>
        <div style="background:#065f46; border-radius:50%; width:120px; height:120px; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:10px;">
            <div style="font-size:28px;">⚡</div>
            <div style="color:#fff; font-weight:700; font-size:14px; margin-top:4px;">ROUTINE</div>
            <div style="color:#6ee7b7; font-size:11px;">Behavior</div>
        </div>
        <div style="color:#3b82f6; font-size:28px; padding:0 8px;">→</div>
        <div style="background:#7c2d12; border-radius:50%; width:120px; height:120px; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:10px;">
            <div style="font-size:28px;">🏆</div>
            <div style="color:#fff; font-weight:700; font-size:14px; margin-top:4px;">REWARD</div>
            <div style="color:#fca5a5; font-size:11px;">Satisfaction</div>
        </div>
    </div>
    <div style="color:#64748b; font-size:13px; margin-top:16px;">Repeat this loop enough times and it becomes automatic</div>
</div>
    </section>

    <div class="section-divider"></div>

    <!-- 4. PRACTICAL APPLICATIONS SECTION -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-compass"></i> Emotions vs. Logic in Decision-Making</h2>

        <h3>Why Emotions Overrule Logic</h3>
        <p>
            You'd like to think you make decisions rationally, weighing pros and cons before acting. But research shows that emotions often drive choices-and logic comes in afterward to justify them. Your emotional brain responds faster than your rational brain, and it's far more powerful.
        </p>

        <p>
            This isn't necessarily a bad thing. Emotions help you make quick decisions in urgent situations. Fear keeps you safe. Joy motivates you to seek rewarding experiences. But when emotions take over in non-urgent situations-like impulse purchases, relationship conflicts, or career choices-they can lead to regret.
        </p>

        <h3>Practical Applications: Making Better Decisions</h3>

        <div class="example-box">
            <h4><i class="fa-solid fa-lightbulb"></i> Real-Life Scenario: Impulse Buying</h4>
            <p>
                You're online shopping late at night. You feel stressed after a long day, and you see a product that promises to make your life easier. Without thinking, you click "Buy Now." The next morning, you regret the purchase. What happened? Your emotional state (stress + desire for relief) bypassed your rational evaluation of whether you actually needed the product.
            </p>
        </div>

        <h3>Strategies to Balance Emotions and Logic</h3>
        <ul class="lesson-list">
            <li><i class="fa-solid fa-check"></i> <strong>Pause before deciding:</strong> Give yourself a 24-hour rule for non-urgent decisions. This allows your emotional response to cool down.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Name your emotion:</strong> Simply identifying what you're feeling (anger, fear, excitement) reduces its power over you.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Ask "Why now?":</strong> If you feel a sudden urge to act, question whether the timing is driven by emotion rather than necessity.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Use the 10-10-10 rule:</strong> How will you feel about this decision in 10 minutes, 10 months, and 10 years?</li>
            <li><i class="fa-solid fa-check"></i> <strong>Seek outside perspective:</strong> Talk to someone who isn't emotionally invested in the situation.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Create decision frameworks:</strong> For recurring choices (like spending limits), set rules in advance when you're thinking clearly.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Track your patterns:</strong> Notice when emotions tend to override your logic-certain times of day, stress levels, or social situations.</li>
        </ul>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-key"></i> Key Takeaway</h4>
            <p>The goal isn't to eliminate emotions from decision-making-it's to recognize when they're influencing you and create space for rational thinking to catch up.</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- 5. QUIZ PREPARATION SECTION -->
    <section class="quiz-prep-section">
        <h2>Before Taking the Quiz: Key Points to Remember</h2>
        <p>Review these essential concepts before testing your knowledge. These points directly connect to the quiz questions.</p>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-star"></i> <strong>Confirmation bias</strong> occurs when you favor information that supports your existing beliefs and ignore contradictory evidence.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Anchoring bias</strong> happens when you rely too heavily on the first piece of information you encounter when making decisions.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Availability bias</strong> causes you to overestimate the likelihood of events based on how easily examples come to mind.</li>
            <li><i class="fa-solid fa-star"></i> The <strong>habit loop</strong> consists of three stages: Cue -> Routine -> Reward.</li>
            <li><i class="fa-solid fa-star"></i> In a habit loop, the <strong>routine</strong> comes immediately after the cue-it's the automatic behavior your brain executes.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Emotional state</strong> is the strongest factor influencing impulse purchases, not logical analysis.</li>
            <li><i class="fa-solid fa-star"></i> Improving decision-making requires <strong>awareness of your biases</strong>, not eliminating emotions entirely.</li>
            <li><i class="fa-solid fa-star"></i> Cognitive biases are <strong>mental shortcuts</strong> that help your brain process information quickly but can lead to errors in judgment.</li>
            <li><i class="fa-solid fa-star"></i> To counter biases, actively seek opposing viewpoints, use statistical data, and pause before making important decisions.</li>
            <li><i class="fa-solid fa-star"></i> Understanding <strong>why</strong> you make certain choices is the foundation of making better ones in the future.</li>
        </ul>

        <div class="motivational-message">
            <p> You're now equipped with the knowledge to recognize psychological patterns in your everyday decisions. Take the quiz to test your understanding and see how well you've mastered these concepts!</p>
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
                src="https://www.youtube.com/embed/X7j8F16eSqs?enablejsapi=1&origin=http://localhost"
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
        <a href="quiz.php"
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
    const COURSE_ID    = 1;

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
            alert('Please watch the video for at least 90 seconds to unlock the quiz.');
            return false;
        }
        return true;
    }
    </script>
    <!-- 6. REFERENCES SECTION -->
    <section class="references-section">
        <h2>Reference Resources</h2>
        <p>Want to explore these topics further? Check out these additional learning materials:</p>

        <div class="reference-links">
            <a href="https://www.youtube.com/watch?v=wEwGBIr_RIw" target="_blank" class="reference-link">
                <i class="fa-solid fa-video"></i>
                <span>Video: Cognitive Biases Explained (Beginner-Friendly)</span>
            </a>
            <a href="https://eatwell.uky.edu/sites/default/files/2025-01/habit-loop-2025.pdf" target="_blank" class="reference-link">
                <i class="fa-solid fa-file-pdf"></i>
                <span>PDF Guide: Habit Loops & Decision Patterns</span>
            </a>
            <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4050437/" target="_blank" class="reference-link">
                <i class="fa-solid fa-file-lines"></i>
                <span>Article: Emotions vs Logic in Daily Life</span>
            </a>
        </div>
    </section>

</div>

</body>
</html>
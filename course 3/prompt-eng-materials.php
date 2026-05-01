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
$course_id = 3;
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
    <title>Course Materials - Prompt Engineering - LearnHub</title>

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
    background: linear-gradient(135deg, #1e1b4b 0%, #2e1065 100%);
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
        repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(99, 102, 241, 0.04) 2px, rgba(99, 102, 241, 0.04) 4px),
        repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(99, 102, 241, 0.04) 2px, rgba(99, 102, 241, 0.04) 4px);
    background-size: 30px 30px;
}

.lesson-hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.lesson-hero-content i {
    font-size: 120px;
    color: #6366f1;
    filter: drop-shadow(0 0 30px rgba(99, 102, 241, 0.6));
    margin-bottom: 20px;
    display: block;
}

.lesson-hero-content p {
    color: #a5b4fc;
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
    color: #6366f1;
    font-size: 28px;
}

.lesson-section h3 {
    font-size: 24px;
    color: #6366f1;
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
    color: #6366f1;
    font-size: 20px;
    margin-top: 2px;
    flex-shrink: 0;
}

/* HIGHLIGHT BOX */
.highlight-box {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(124, 58, 237, 0.05) 100%);
    border-left: 4px solid #6366f1;
    padding: 25px 30px;
    margin: 30px 0;
    border-radius: 8px;
}

.highlight-box h4 {
    color: #a5b4fc;
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

/* STAT BOX (warning/alert style) */
.stat-box {
    background: rgba(124, 58, 237, 0.08);
    border-left: 4px solid #7c3aed;
    padding: 25px 30px;
    margin: 30px 0;
    border-radius: 8px;
}

.stat-box h4 {
    color: #c4b5fd;
    font-size: 18px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.stat-box h4 i {
    font-size: 20px;
}

.stat-box p {
    color: #cbd5e1;
    font-size: 16px;
    line-height: 1.7;
    margin: 0;
}

/* CODE BLOCK */
.code-block {
    background: #0a0f1e;
    border: 1px solid rgba(99, 102, 241, 0.3);
    border-radius: 10px;
    padding: 24px 28px;
    margin: 20px 0;
    font-family: 'Courier New', Courier, monospace;
    font-size: 15px;
    color: #a5b4fc;
    line-height: 1.8;
    position: relative;
    overflow-x: auto;
}

.code-block::before {
    content: attr(data-label);
    position: absolute;
    top: -1px;
    right: 16px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: #fff;
    font-family: Arial, sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 0 0 6px 6px;
}

.code-block .comment {
    color: #475569;
}

.code-block .keyword {
    color: #c4b5fd;
    font-weight: bold;
}

.code-block .value {
    color: #6ee7b7;
}

/* COMPARISON BLOCK */
.comparison-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 30px 0;
}

.comparison-card {
    border-radius: 10px;
    padding: 24px;
    font-family: 'Courier New', Courier, monospace;
    font-size: 14px;
    line-height: 1.8;
}

.comparison-card.bad {
    background: #1a0a0a;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.comparison-card.good {
    background: #0a0f1e;
    border: 1px solid rgba(99, 102, 241, 0.4);
}

.comparison-card h5 {
    font-family: Arial, sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
}

.comparison-card.bad h5 {
    color: #f87171;
}

.comparison-card.good h5 {
    color: #a5b4fc;
}

.comparison-card p {
    color: #94a3b8;
    font-size: 14px;
    margin: 0;
    line-height: 1.8;
}

.comparison-card.bad p {
    color: #fca5a5;
}

.comparison-card.good p {
    color: #a5b4fc;
}

/* NUMBERED STEPS */
.numbered-steps {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin: 30px 0;
}

.step-item {
    background: #0f172a;
    padding: 25px;
    border-radius: 12px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
    border: 1px solid rgba(99, 102, 241, 0.2);
}

.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    color: #ffffff;
    flex-shrink: 0;
}

.step-content h4 {
    color: #ffffff;
    font-size: 18px;
    margin-bottom: 8px;
}

.step-content p {
    color: #94a3b8;
    font-size: 15px;
    line-height: 1.6;
    margin: 0;
}

/* FRAMEWORK BOX */
.framework-box {
    background: #0a0f1e;
    border: 2px solid rgba(99, 102, 241, 0.5);
    border-radius: 14px;
    padding: 34px 36px;
    margin: 30px 0;
    position: relative;
    overflow: hidden;
}

.framework-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
}

.framework-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #6366f1;
    margin-bottom: 18px;
}

.formula-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}

.formula-tag {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(124, 58, 237, 0.1) 100%);
    border: 1px solid rgba(99, 102, 241, 0.4);
    color: #a5b4fc;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 600;
    font-family: 'Courier New', Courier, monospace;
}

.formula-plus {
    color: #6366f1;
    font-size: 22px;
    font-weight: 700;
}

.framework-box .example-block {
    background: #1e293b;
    border-radius: 8px;
    padding: 20px 24px;
    margin-top: 10px;
}

.framework-box .example-block p {
    font-size: 15px;
    color: #94a3b8;
    margin-bottom: 8px;
    line-height: 1.7;
}

.framework-box .example-block p:last-child {
    margin-bottom: 0;
}

.framework-box .example-block span.field {
    color: #a5b4fc;
    font-weight: 600;
}

/* IMAGE PLACEHOLDER */
.image-placeholder {
    width: 100%;
    height: 280px;
    background: #1e1b4b;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 40px 0;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(99, 102, 241, 0.2);
}

.image-placeholder::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(99, 102, 241, 0.03) 2px, rgba(99, 102, 241, 0.03) 4px),
        repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(99, 102, 241, 0.03) 2px, rgba(99, 102, 241, 0.03) 4px);
    background-size: 20px 20px;
}

.image-placeholder i {
    font-size: 80px;
    color: #4f46e5;
    position: relative;
    z-index: 1;
    margin-bottom: 15px;
}

.image-placeholder p {
    color: #6366f1;
    font-size: 16px;
    position: relative;
    z-index: 1;
    margin: 0;
}

/* WORKFLOW DIAGRAM PLACEHOLDER */
.workflow-placeholder {
    width: 100%;
    height: 180px;
    background: #0a0f1e;
    border-radius: 10px;
    border: 1px dashed rgba(99, 102, 241, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px 0;
    gap: 16px;
    flex-wrap: wrap;
    padding: 20px;
}

.workflow-node {
    background: rgba(99, 102, 241, 0.12);
    border: 1px solid rgba(99, 102, 241, 0.4);
    border-radius: 8px;
    padding: 10px 18px;
    color: #a5b4fc;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
}

.workflow-arrow {
    color: #4f46e5;
    font-size: 18px;
}

/* SECTION DIVIDER */
.section-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(99, 102, 241, 0.4) 50%, transparent 100%);
    margin: 50px 0;
}

/* QUIZ PREP SECTION */
.quiz-prep-section {
    background: linear-gradient(135deg, #1e1b4b 0%, #2e1065 100%);
    padding: 50px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.2);
    border: 1px solid rgba(99, 102, 241, 0.2);
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
    background: rgba(255, 255, 255, 0.08);
    padding: 20px 25px;
    border-radius: 10px;
    margin-top: 30px;
    text-align: center;
    border: 1px solid rgba(165, 180, 252, 0.2);
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
    color: #6366f1;
    text-decoration: none;
    font-size: 16px;
    padding: 12px 0;
    transition: all 0.3s;
}

.reference-link:hover {
    color: #a5b4fc;
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

    .comparison-grid {
        grid-template-columns: 1fr;
    }

    .formula-row {
        gap: 8px;
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
        <a href="prompt-eng-nav.php" class="tab">Overview</a>
        <a href="prompt-eng-materials.php" class="tab active">Materials</a>
        <a href="prompt-eng-quiz.php" class="tab">Quizzes</a>
    </div>
</div>

<!-- LESSON CONTENT -->
<div class="lesson-container">

    <!-- HERO IMAGE -->
    <div class="lesson-hero">
        <div class="lesson-hero-content">
            <i class="fa-solid fa-microchip"></i>
            <p>Prompt Engineering for Beginners</p>
        </div>
    </div>

    <!-- SECTION 1: WHAT IS PROMPT ENGINEERING -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-terminal"></i> What is Prompt Engineering?</h2>

        <p>
            Prompt engineering is the discipline of crafting precise, structured inputs-called prompts-to guide artificial intelligence systems toward producing accurate, relevant, and high-quality outputs. It sits at the intersection of linguistics, logic, and human-computer interaction. As AI language models become more embedded in everyday workflows, the ability to communicate effectively with them becomes a critical professional skill.
        </p>

        <p>
            At its core, prompt engineering is about understanding how AI systems interpret language. Unlike traditional software that follows rigid if-then logic, large language models are probabilistic-they predict the most likely continuation of a given input based on billions of training examples. This means the phrasing, structure, and context of your prompt directly influence the probability distribution of the output. Small changes can produce dramatically different results.
        </p>

        <p>
            Large language models (LLMs) such as GPT-4, Claude, and Gemini are trained on vast datasets of human-generated text. They learn statistical patterns in language and can generate coherent, contextually appropriate responses across a wide range of domains. However, they do not "understand" in the way humans do-they infer meaning from context. This is why a well-engineered prompt acts as a precise instruction set that leaves minimal room for ambiguity.
        </p>

        <p>
            The practical value of prompt engineering is immense. Businesses use it to build internal tools, automate repetitive tasks, generate structured reports, and enhance customer service. Researchers use it to extract insights from large text corpora. Developers use it to build AI-powered applications. Regardless of your domain, mastering this skill unlocks the full potential of AI systems.
        </p>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-bolt"></i> Core Principle</h4>
            <p><strong>Output Quality = Prompt Quality.</strong> The precision, structure, and clarity of your input directly determines the usefulness of the AI's response. Garbage in, garbage out - but with AI, even slightly better inputs yield exponentially better outputs.</p>
        </div>

        <div style="background:#0f172a; border-radius:12px; padding:30px; margin:30px 0;">
    <h4 style="color:#8b5cf6; text-align:center; margin-bottom:20px; font-size:18px;">
        <i class="fa-solid fa-wand-magic-sparkles"></i> Anatomy of a Good Prompt
    </h4>
    <div style="display:flex; flex-direction:column; gap:12px;">
        <div style="background:#1e293b; border-radius:8px; padding:16px; border-left:4px solid #3b82f6; display:flex; align-items:center; gap:15px;">
            <span style="font-size:24px;">🎭</span>
            <div><div style="color:#3b82f6; font-weight:700;">Role</div><div style="color:#94a3b8; font-size:14px;">"You are an expert financial advisor..."</div></div>
        </div>
        <div style="background:#1e293b; border-radius:8px; padding:16px; border-left:4px solid #10b981; display:flex; align-items:center; gap:15px;">
            <span style="font-size:24px;">📋</span>
            <div><div style="color:#10b981; font-weight:700;">Task</div><div style="color:#94a3b8; font-size:14px;">"Explain compound interest in simple terms..."</div></div>
        </div>
        <div style="background:#1e293b; border-radius:8px; padding:16px; border-left:4px solid #f59e0b; display:flex; align-items:center; gap:15px;">
            <span style="font-size:24px;">📌</span>
            <div><div style="color:#f59e0b; font-weight:700;">Context</div><div style="color:#94a3b8; font-size:14px;">"...for a 20-year-old with no finance background..."</div></div>
        </div>
        <div style="background:#1e293b; border-radius:8px; padding:16px; border-left:4px solid #ef4444; display:flex; align-items:center; gap:15px;">
            <span style="font-size:24px;">📐</span>
            <div><div style="color:#ef4444; font-weight:700;">Format</div><div style="color:#94a3b8; font-size:14px;">"...in bullet points with one real-life example."</div></div>
        </div>
    </div>
</div>
    </section>

    <!-- SECTION 2: ANATOMY OF A HIGH-QUALITY PROMPT -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-code"></i> Anatomy of a High-Quality Prompt</h2>

        <h3>2.1 Clear Instructions</h3>
        <p>
            The most fundamental element of any effective prompt is clarity. An AI model cannot read your mind-it can only interpret what you explicitly provide. Vague or incomplete instructions force the model to make assumptions, which often leads to generic or incorrect outputs. Clarity means specifying exactly what you want: the action, the scope, the tone, and the depth of the response.
        </p>
        <p>
            For example, instead of writing "tell me about climate change," a clear instruction would be: "Write a 150-word summary of the primary causes of climate change, written for a non-scientific audience, using simple language." Every added constraint sharpens the output.
        </p>

        <h3>2.2 Context</h3>
        <p>
            Context provides the AI with background information it needs to tailor the response appropriately. Without context, the model produces a generic answer calibrated to an imaginary average reader. With context, it can adjust tone, vocabulary, depth, and framing to match your specific situation.
        </p>
        <p>
            Context can include: who you are, who the audience is, what the purpose of the output is, what domain or industry is relevant, and what prior knowledge the reader has. The more relevant context you provide, the more targeted and useful the AI's response will be.
        </p>

        <h3>2.3 Output Format</h3>
        <p>
            Specifying the desired output format is one of the most powerful tools in prompt engineering. AI models can produce tables, bullet lists, numbered steps, JSON objects, code blocks, executive summaries, essays, and more - but only if you ask. Without format instructions, the model defaults to plain prose, which may not suit your use case.
        </p>

        <div class="comparison-grid">
            <div class="comparison-card bad">
                <h5> Bad Prompt</h5>
                <p>
                    Write about marketing strategies.<br><br>
                    <span style="color:#475569;">// No role, no format, no context,<br>// no length, no audience specified.</span>
                </p>
            </div>
            <div class="comparison-card good">
                <h5> Improved Structured Prompt</h5>
                <p>
                    You are a senior marketing consultant.<br>
                    Task: List 5 digital marketing strategies<br>
                    for a SaaS startup targeting SMEs.<br>
                    Format: Numbered list, 2 sentences each.<br>
                    Tone: Professional, concise.<br>
                    Audience: Non-technical founders.
                </p>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 3: ROLE PROMPTING & FEW-SHOT -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-user-gear"></i> Role Prompting &amp; Few-Shot Prompting</h2>

        <p>
            Two of the most effective advanced techniques in prompt engineering are role prompting and few-shot prompting. Both work by giving the AI additional context that shapes how it frames and generates its response.
        </p>

        <h3>Role Prompting</h3>
        <p>
            Role prompting involves assigning the AI a specific identity or persona before issuing your main instruction. When the model is given a role, it draws on patterns associated with that role in its training data, producing responses that reflect that expertise, tone, and perspective.
        </p>

        <div class="code-block" data-label="Role Prompt Example">
            <span class="keyword">You are</span> a financial analyst with 10 years of experience<br>
            in investment strategy and risk assessment.<br><br>
            <span class="comment">// Task follows the role assignment</span><br>
            Analyze the risk profile of investing in<br>
            emerging market bonds for a conservative investor.<br>
            Format: Executive summary, 200 words.
        </div>

        <h3>Few-Shot Prompting</h3>
        <p>
            Few-shot prompting involves providing one or more examples inside the prompt itself. These examples demonstrate the pattern, format, or style you want the AI to follow. Rather than describing what you want abstractly, you show it concretely.
        </p>

        <div class="code-block" data-label="Few-Shot Example">
            <span class="comment">// Example 1 (provided to AI)</span><br>
            <span class="keyword">Input:</span>  <span class="value">"The product broke after one use."</span><br>
            <span class="keyword">Output:</span> <span class="value">"Sentiment: Negative | Issue: Durability"</span><br><br>
            <span class="comment">// Example 2 (provided to AI)</span><br>
            <span class="keyword">Input:</span>  <span class="value">"Shipping was fast, great packaging."</span><br>
            <span class="keyword">Output:</span> <span class="value">"Sentiment: Positive | Issue: None"</span><br><br>
            <span class="comment">// Now classify this:</span><br>
            <span class="keyword">Input:</span>  <span class="value">"Instructions were confusing, product works."</span>
        </div>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-layer-group"></i> Why Examples Improve Consistency</h4>
            <p>When you provide examples, the AI locks onto the structural pattern you demonstrate. It no longer has to infer format from description alone - it has a concrete template to follow. This dramatically reduces variability and increases the reliability of repeated outputs, making few-shot prompting essential for production use cases.</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 4: COMMON MISTAKES -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-triangle-exclamation"></i> Common Mistakes in Prompt Engineering</h2>

        <p>
            Understanding what makes a bad prompt is just as important as knowing what makes a good one. Many beginners make the same recurring mistakes that consistently produce poor AI outputs. Recognizing these patterns allows you to avoid them and refine your prompting strategy.
        </p>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-xmark"></i> <span><strong>Being vague:</strong> Prompts like "explain AI" give the model no target audience, no depth, and no scope. The AI fills in all blanks with generic assumptions.</span></li>
            <li><i class="fa-solid fa-xmark"></i> <span><strong>No formatting instruction:</strong> Without specifying "use a table" or "provide a numbered list," the AI defaults to free-form prose that may be hard to parse or use.</span></li>
            <li><i class="fa-solid fa-xmark"></i> <span><strong>Overly broad requests:</strong> Asking for "everything about machine learning" forces the AI to make arbitrary choices about what to include. Narrow your scope explicitly.</span></li>
            <li><i class="fa-solid fa-xmark"></i> <span><strong>Lack of constraints:</strong> Without word count limits, tone guidelines, or audience specifications, outputs vary unpredictably across generations.</span></li>
        </ul>

        <div class="stat-box">
            <h4><i class="fa-solid fa-circle-exclamation"></i> Real-World Failure Example</h4>
            <p>A developer asks an AI: <em>"Write a function."</em> The AI produces a random Hello World function with no relation to the actual project. The prompt lacked: language specification, function purpose, input/output types, error handling requirements, and code style conventions. A complete prompt would have taken 30 seconds longer to write - but saved hours of debugging.</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 5: ADVANCED TECHNIQUES -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-gears"></i> Advanced Techniques</h2>

        <p>
            Once you have mastered the basics, advanced prompting techniques allow you to handle complex tasks, multi-step reasoning, and iterative output improvement. These methods are widely used in production AI systems and represent the professional tier of prompt engineering.
        </p>

        <h3>Step-by-Step Prompting</h3>
        <p>
            Instructing the AI to break a problem into sequential steps before answering forces it to reason systematically rather than jumping to a conclusion. This is particularly effective for analytical, mathematical, and logical tasks.
        </p>

        <h3>Chain-of-Thought Guidance</h3>
        <p>
            Chain-of-thought prompting extends step-by-step prompting by explicitly asking the model to show its reasoning process. By appending phrases like "Think through this step by step" or "Explain your reasoning before giving the final answer," you activate more deliberate, structured reasoning pathways within the model.
        </p>

        <h3>Iterative Refinement Process</h3>
        <p>
            Iterative refinement treats prompting as a feedback loop rather than a one-shot process. You generate an initial output, evaluate it against your criteria, identify gaps or errors, and then revise your prompt to address them. This cycle repeats until the output meets your quality standard.
        </p>

        <div class="numbered-steps">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Draft Initial Prompt</h4>
                    <p>Write your best first attempt at a prompt based on what you need. Focus on including role, task, context, and format.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Generate and Evaluate Output</h4>
                    <p>Run the prompt and critically assess the output. What is missing? What is inaccurate? What format issues exist?</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Identify Failure Points</h4>
                    <p>Pinpoint exactly which part of your prompt caused the undesired output. Was it vague instructions? Missing context? Wrong format spec?</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Refine and Re-run</h4>
                    <p>Update the specific failing component of your prompt. Re-run and compare the new output to the previous one. Repeat until satisfied.</p>
                </div>
            </div>
        </div>

        <div class="workflow-placeholder">
            <div class="workflow-node">Draft Prompt</div>
            <div class="workflow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="workflow-node">Generate Output</div>
            <div class="workflow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="workflow-node">Evaluate</div>
            <div class="workflow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="workflow-node">Refine Prompt</div>
            <div class="workflow-arrow" style="color:#a5b4fc;"></div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 6: PRACTICAL FRAMEWORK -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-diagram-project"></i> Practical Prompt Framework</h2>

        <p>
            The most reliable way to construct effective prompts is to follow a consistent, reusable formula. This framework distills everything covered in this lesson into a single repeatable structure that works across virtually any AI task.
        </p>

        <div class="framework-box">
            <div class="framework-label">The Universal Prompt Formula</div>
            <div class="formula-row">
                <span class="formula-tag">Role</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Task</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Context</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Format</span>
                <span class="formula-plus">+</span>
                <span class="formula-tag">Constraints</span>
            </div>
            <div class="example-block">
                <p><span class="field">Role:</span> You are a senior UX designer with experience in mobile app design.</p>
                <p><span class="field">Task:</span> Write a usability review of an e-commerce checkout flow.</p>
                <p><span class="field">Context:</span> The app targets users aged 35-55 with limited technical literacy. The checkout currently has 7 steps.</p>
                <p><span class="field">Format:</span> Numbered list of 5 issues, each followed by a recommended fix.</p>
                <p><span class="field">Constraints:</span> Max 200 words. Use plain language. Do not reference specific UI frameworks.</p>
            </div>
        </div>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-circle-check"></i> Why This Framework Works</h4>
            <p>Each component of the formula eliminates a different category of ambiguity. Role shapes expertise and tone. Task defines the action. Context provides necessary background. Format specifies output structure. Constraints prevent scope creep. Together, they create a near-complete instruction set that leaves minimal room for the AI to deviate from your intent.</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 7: BEFORE THE QUIZ -->
    <section class="quiz-prep-section">
        <h2>Final Prompt Review: Before Taking the Quiz</h2>
        <p>Review these essential prompt engineering principles before testing your knowledge.</p>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-star"></i> A <strong>high-quality prompt</strong> includes clear instructions, relevant context, and a specified output format.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Output quality</strong> is directly proportional to prompt quality - precision in equals precision out.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Role prompting</strong> assigns the AI a specific identity or expertise, shaping the tone and depth of its response.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Few-shot prompting</strong> provides examples inside the prompt so the AI learns the desired pattern from demonstration.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Iterative refinement</strong> means improving a prompt step-by-step based on evaluating prior outputs - not expecting perfection on the first attempt.</li>
            <li><i class="fa-solid fa-star"></i> Specifying <strong>output format</strong> (table, list, paragraph, JSON) controls the structure of the AI's response and makes it directly usable.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Context</strong> gives the AI necessary background to tailor tone, vocabulary, and depth to your specific audience and use case.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Vagueness</strong> is the most common mistake - it forces the model to make assumptions that rarely match your intent.</li>
            <li><i class="fa-solid fa-star"></i> The <strong>Prompt Framework</strong> formula is: Role + Task + Context + Format + Constraints.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Chain-of-thought</strong> guidance activates step-by-step reasoning in the AI, improving accuracy on complex or analytical tasks.</li>
        </ul>

        <div class="motivational-message">
            <p> You now understand the core frameworks of effective prompt engineering. Take the quiz to validate your knowledge and demonstrate mastery of these principles!</p>
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
                src="https://www.youtube.com/embed/VnEoS2eQXsw?enablejsapi=1&origin=http://localhost"
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
        <a href="prompt-eng-quiz.php"
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
    const COURSE_ID    = 3;

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
    <!-- SECTION 8: REFERENCES -->
    <section class="references-section">
        <h2>Reference Resources</h2>
        <p>Explore these additional materials to deepen your prompt engineering knowledge:</p>

        <div class="reference-links">
            <a href="https://platform.openai.com/docs/guides/prompt-engineering" target="_blank" class="reference-link">
                <i class="fa-solid fa-file-lines"></i>
                <span>OpenAI Prompt Engineering Documentation</span>
            </a>
            <a href="https://learnprompting.org" target="_blank" class="reference-link">
                <i class="fa-solid fa-book"></i>
                <span>Learn Prompting - Open Source Prompt Examples Guide</span>
            </a>
            <a href="https://www.youtube.com/results?search_query=prompt+engineering+tutorial" target="_blank" class="reference-link">
                <i class="fa-solid fa-video"></i>
                <span>Prompt Engineering Tutorial Video Series</span>
            </a>
        </div>
    </section>

</div>

</body>
</html>

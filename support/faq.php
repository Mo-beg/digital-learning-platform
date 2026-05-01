<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - LearnHub</title>
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="/digital learning platform/css/shared.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .faq-hero {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            padding: 60px 48px;
            text-align: center;
        }
        .faq-hero h1 { font-size: 36px; color: #fff; margin-bottom: 12px; }
        .faq-hero p  { color: #94a3b8; font-size: 16px; }

        .faq-container {
            max-width: 800px;
            margin: 60px auto;
            padding: 0 24px 80px;
        }

        .faq-item {
            background: #1e293b;
            border-radius: 12px;
            margin-bottom: 16px;
            border: 1px solid rgba(51,65,85,0.5);
            overflow: hidden;
        }

        .faq-question {
            padding: 20px 24px;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s;
        }
        .faq-question:hover { background: #243047; }
        .faq-question i { color: #3b82f6; transition: transform 0.3s; }
        .faq-question.open i { transform: rotate(180deg); }

        .faq-answer {
            display: none;
            padding: 0 24px 20px;
            color: #94a3b8;
            font-size: 15px;
            line-height: 1.7;
        }
        .faq-answer.open { display: block; }
    </style>
</head>
<body>

<?php include '../partials/nav.php'; ?>

<div class="faq-hero">
    <h1><i class="fa-solid fa-circle-question" style="color:#3b82f6"></i> Frequently Asked Questions</h1>
    <p>Everything you need to know about LearnHub</p>
</div>

<div class="faq-container">

    <div class="faq-item">
        <div class="faq-question" onclick="toggle(this)">
            Is LearnHub completely free?
            <i class="fa-solid fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
            Yes! All courses on LearnHub are 100% free. You can sign up, enroll in any course, watch videos, take quizzes, and earn certificates without paying anything.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggle(this)">
            How do I get a certificate?
            <i class="fa-solid fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
            To earn a certificate, you need to: (1) enroll in a course, (2) watch the course video for at least 15 seconds, (3) take the quiz and score 60% or above. The certificate button will appear automatically after passing.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggle(this)">
            Why can't I access the course material?
            <i class="fa-solid fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
            Course materials are only available to registered users who have enrolled. Make sure you are signed in and have clicked the Enroll button on the course you want to access.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggle(this)">
            Can I retake a quiz?
            <i class="fa-solid fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
            Yes! You can retake any quiz as many times as you like by clicking the "Retake Quiz" button on the results screen. There is no limit.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggle(this)">
            How do I print my certificate?
            <i class="fa-solid fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
            After passing a quiz, click "Get Your Certificate". On the certificate page, click the "Print / Save as Screenshot" button. Your browser will open the print dialog — you can print it or save it as a PDF.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggle(this)">
            How do I reset my password?
            <i class="fa-solid fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
            Password reset is coming soon. For now, please contact us at info@learnhub.com and we will help you regain access to your account.
        </div>
    </div>

</div>

<?php include '../partials/footer.php'; ?>

<script>
function toggle(el) {
    el.classList.toggle('open');
    el.nextElementSibling.classList.toggle('open');
}
</script>

</body>
</html>

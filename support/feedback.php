<?php
session_start();
$submitted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real app this would save to DB or send email
    // For now we just show a thank-you message
    $submitted = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - LearnHub</title>
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="/digital learning platform/css/shared.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .fb-hero {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            padding: 60px 48px;
            text-align: center;
        }
        .fb-hero h1 { font-size: 36px; color: #fff; margin-bottom: 12px; }
        .fb-hero p  { color: #94a3b8; font-size: 16px; }

        .fb-container {
            max-width: 640px;
            margin: 60px auto 80px;
            padding: 0 24px;
        }

        .fb-card {
            background: #1e293b;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid rgba(51,65,85,0.5);
        }

        .form-group { margin-bottom: 22px; }

        label {
            display: block;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            background: #0f172a;
            border: 1px solid rgba(51,65,85,0.7);
            border-radius: 8px;
            color: #ffffff;
            font-size: 15px;
            transition: border-color 0.3s;
            font-family: Arial, sans-serif;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
        }
        input::placeholder, textarea::placeholder { color: #475569; }
        select option { background: #1e293b; }

        textarea { resize: vertical; min-height: 130px; }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59,130,246,0.35);
        }

        .success-box {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.4);
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            color: #6ee7b7;
        }
        .success-box i  { font-size: 56px; margin-bottom: 16px; }
        .success-box h3 { font-size: 24px; color: #fff; margin-bottom: 10px; }
        .success-box p  { color: #94a3b8; font-size: 15px; }
    </style>
</head>
<body>

<?php include '../partials/nav.php'; ?>

<div class="fb-hero">
    <h1><i class="fa-solid fa-comment-dots" style="color:#3b82f6"></i> Share Your Feedback</h1>
    <p>Help us improve LearnHub. Your opinion genuinely matters to us.</p>
</div>

<div class="fb-container">
    <div class="fb-card">

        <?php if ($submitted): ?>
            <div class="success-box">
                <i class="fa-solid fa-circle-check"></i>
                <h3>Thank You!</h3>
                <p>Your feedback has been received. We really appreciate you taking the time to help us improve LearnHub.</p>
                <br>
                <a href="/digital learning platform/home.php" style="color:#3b82f6; font-weight:600; text-decoration:none;">
                    &larr; Back to Home
                </a>
            </div>

        <?php else: ?>
            <form action="" method="post">

                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="e.g. Ahmed Khan" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="type">Feedback Type</label>
                    <select id="type" name="type" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="general">General Feedback</option>
                        <option value="course">Course Content</option>
                        <option value="bug">Report a Bug</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" placeholder="Write your feedback here..." required></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-paper-plane"></i> Submit Feedback
                </button>

            </form>
        <?php endif; ?>

    </div>
</div>

<?php include '../partials/footer.php'; ?>

</body>
</html>

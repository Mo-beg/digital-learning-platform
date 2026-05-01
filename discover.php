<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LearnHub | Discover</title>
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="css/discover.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'partials/nav.php'; ?>

<!-- HERO -->
<section class="hero">
    <h1>Discover LearnHub</h1>
    <p>Learn who we are, what we teach, and why it matters for your future</p>
</section>

<!-- ABOUT US -->
<section>
    <h2><i class="fa-solid fa-circle-info" style="color:#3b82f6; margin-right:10px;"></i>About Us</h2>
    <div class="featured-card">
        <p>
            LearnHub is a free digital learning platform built for the modern learner.
            We believe that access to quality education should not be limited by location, cost, or background.
            Our platform was designed from the ground up to make learning practical, structured, and genuinely useful in real life.
            <br><br>
            Every course on LearnHub is carefully crafted to address skills that are relevant in today's fast-changing world.
            We do not teach for the sake of teaching — we teach because the knowledge we offer has a direct impact on how people think, decide, and grow.
            From understanding your own psychology to managing money wisely, from spotting misinformation to communicating with AI tools,
            LearnHub covers the skills that truly matter.
            Our mission is simple: give every learner the tools they need to move forward with confidence.
        </p>
    </div>
</section>

<!-- OUR EXPERTISE -->
<section>
    <h2><i class="fa-solid fa-lightbulb" style="color:#f59e0b; margin-right:10px;"></i>Our Expertise</h2>
    <div class="featured-card">
        <p>
            Our team specializes in designing learning experiences that are focused, clear, and outcome-driven.
            We do not overload learners with unnecessary theory — instead, we distill complex subjects into structured,
            easy-to-follow modules that build understanding step by step.
            <br><br>
            Our expertise spans four core domains: behavioral psychology, personal finance, digital media literacy, and AI communication.
            Each of these areas has been identified as a critical competency for individuals navigating the digital age.
            We combine research-backed content with practical application so that every lesson you complete
            translates into a real skill you can use immediately.
            Our instructional approach is built around clarity, relevance, and measurable progress.
        </p>
    </div>
</section>

<!-- FUTURE SKILLS THAT MATTER -->
<section>
    <h2><i class="fa-solid fa-rocket" style="color:#10b981; margin-right:10px;"></i>Future Skills That Matter</h2>
    <div class="course-grid">
        <div class="course-card">
            <i class="fa-solid fa-brain" style="font-size:28px; color:#3b82f6; margin-bottom:12px; display:block;"></i>
            <h3>Critical Thinking</h3>
            <p>
                The ability to analyze information, question assumptions, and make sound judgments
                is one of the most valued skills in any field. Our psychology course develops
                this capacity by exposing learners to cognitive biases and decision-making frameworks
                that sharpen how you process the world around you.
            </p>
        </div>
        <div class="course-card">
            <i class="fa-solid fa-coins" style="font-size:28px; color:#f59e0b; margin-bottom:12px; display:block;"></i>
            <h3>Financial Intelligence</h3>
            <p>
                Understanding money is no longer optional — it is essential.
                Knowing how to budget, save, and invest puts you in control of your future.
                Our financial management course teaches these fundamentals in a practical,
                straightforward way that anyone can apply from day one, regardless of their current financial situation.
            </p>
        </div>
        <div class="course-card">
            <i class="fa-solid fa-magnifying-glass" style="font-size:28px; color:#ef4444; margin-bottom:12px; display:block;"></i>
            <h3>Digital Awareness</h3>
            <p>
                In a world flooded with information, knowing what to trust is a superpower.
                Our Digital Detective course trains you to identify misinformation, verify sources,
                and think critically about the content you consume and share online.
                This skill protects you, your decisions, and the people around you.
            </p>
        </div>
        <div class="course-card">
            <i class="fa-solid fa-wand-magic-sparkles" style="font-size:28px; color:#8b5cf6; margin-bottom:12px; display:block;"></i>
            <h3>AI Communication</h3>
            <p>
                Artificial intelligence is now part of everyday professional life.
                Learning how to write effective prompts and direct AI tools productively
                is quickly becoming a core workplace skill. Our Prompt Engineering course
                teaches you exactly how to communicate with AI systems to get accurate,
                useful, and powerful results every time.
            </p>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section>
    <h2><i class="fa-solid fa-star" style="color:#f59e0b; margin-right:10px;"></i>Why Choose LearnHub</h2>
    <div class="featured-card">
        <p>
            LearnHub stands apart because we focus on what actually helps learners grow — not just what looks impressive on paper.
            Every course is free, every certificate is real, and every lesson is designed with your time and progress in mind.
            We do not ask you to sit through hours of irrelevant content before reaching what matters.
            <br><br>
            Our platform is built for self-paced learning, meaning you move at a speed that works for you — no pressure, no deadlines.
            We also provide a verified certificate for every course you complete, giving you something tangible to show for your effort.
            Whether you are a student looking to build foundational skills, a professional seeking to stay relevant,
            or simply a curious individual who wants to learn — LearnHub was built with you in mind.
            Choose LearnHub because your growth deserves a platform that takes it seriously.
        </p>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <h2>Ready to Start Learning?</h2>
    <a href="/digital learning platform/course.php" class="btn">Browse All Courses</a>
</section>

<?php include 'partials/footer.php'; ?>

</body>
</html>

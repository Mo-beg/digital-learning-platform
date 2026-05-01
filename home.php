<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LearnHub | Home</title>
    <link rel="stylesheet" href="css/home.css">
    <!-- FONT AWESOME ICONS -->
    <link rel="icon" type="image/svg+xml" href="/digital learning platform/image/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Inline course card styles - bypass any CSS caching */
        .courses-header { text-align: center; margin-bottom: 40px; }
        .courses-header h2 { text-align: center; font-size: 38px; font-weight: 800; color: #fff; margin-bottom: 12px; }
        .courses-sub { color: #94a3b8; font-size: 16px; display: block; text-align: center; margin-bottom: 0; }

        .courses .course-container {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .courses .course-card {
            background: #0f172a !important;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(51,65,85,0.6);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex !important;
            flex-direction: column !important;
        }
        .courses .course-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(59,130,246,0.18);
        }
        .courses .course-image-wrapper {
            position: relative;
            height: 210px;
            overflow: hidden;
        }
        .courses .course-image-wrapper img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s;
        }
        .courses .course-card:hover .course-image-wrapper img { transform: scale(1.05); }

        .course-badge {
            position: absolute;
            top: 14px; left: 14px;
            background: #3b82f6;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
        }
        .courses .course-info {
            padding: 22px;
            display: flex !important;
            flex-direction: column !important;
            flex: 1;
        }
        .course-meta {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }
        .course-meta span {
            color: #64748b;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .course-meta i { color: #3b82f6; }

        .courses .course-info h3 {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff !important;
            margin-bottom: 10px;
            line-height: 1.35;
        }
        .courses .course-info p {
            font-size: 14px;
            color: #94a3b8 !important;
            line-height: 1.6;
            margin-bottom: 18px;
            flex: 1;
        }

        /* THE KEY FIX: force flex on the footer buttons */
        .course-card-footer {
            display: flex !important;
            flex-direction: row !important;
            gap: 10px !important;
            margin-top: auto;
        }
        .btn-outline-sm {
            flex: 1;
            display: block !important;
            text-align: center;
            padding: 10px 0;
            border: 2px solid #334155;
            border-radius: 8px;
            color: #94a3b8 !important;
            text-decoration: none !important;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        .btn-outline-sm:hover { border-color: #3b82f6; color: #3b82f6 !important; }

        .btn-primary-sm {
            flex: 1;
            display: block !important;
            text-align: center;
            padding: 10px 0;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 8px;
            color: #fff !important;
            text-decoration: none !important;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        .btn-primary-sm:hover { box-shadow: 0 4px 14px rgba(59,130,246,0.4); }

        @media (max-width: 768px) {
            .courses .course-container { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body>

<?php include 'partials/nav.php'; ?>
    <!-- HERO SECTION -->
<section class="hero">

    <!-- Slides will be added by JS -->

    <div class="hero-content">
        <h1>Learn Anytime, Anywhere</h1>
        <p>Upgrade your skills with high quality online courses</p>
    </div>

</section>

<!-- FEATURES -->
<section class="features">
    <h2 class="features-title">Why LearnHub Works</h2>
    <div class="features-container">
        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3>Structured Learning Support</h3>
            <p>Study with clear notes, easy explanations, and step-by-step guidance designed to help you understand every topic with confidence.</p>
        </div>

        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h3>Quality Content</h3>
            <p>Well structured and easy to understand curriculum to ensure effective learning.</p>
        </div>

        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-clock"></i>
            </div>
            <h3>Flexible Learning</h3>
            <p>Study at your own pace, anytime and anywhere. Access courses on any device at your convenience.</p>
        </div>
    </div>
</section>

<!-- COURSES SECTION -->
<section class="courses">
    <div class="courses-header">
        <h2>Popular Courses</h2>
        <p class="courses-sub">Handpicked courses to get you started on your learning journey</p>
    </div>

    <div class="course-container">

        <div class="course-card">
            <div class="course-image-wrapper">
                <img src="image/psychology.jpeg" alt="Psychology">
                <span class="course-badge">Most Popular</span>
            </div>
            <div class="course-info">
                <div class="course-meta">
                    <span><i class="fa-solid fa-signal fa-xs"></i> Beginner</span>
                    <span><i class="fa-regular fa-clock fa-xs"></i> 2 Hours</span>
                    <span><i class="fa-solid fa-certificate fa-xs"></i> Certificate</span>
                </div>
                <h3>The Psychology of Everyday Decisions</h3>
                <p>Understand cognitive biases, habit loops, and how emotions shape every choice you make daily.</p>
                <div class="course-card-footer">
                    <a href="course 1/psychology.php" class="btn-outline-sm">Overview</a>
                    <a href="/digital learning platform/enroll.php?course_id=1" class="btn-primary-sm">Enroll Free &rarr;</a>
                </div>
            </div>
        </div>

        <div class="course-card">
            <div class="course-image-wrapper">
                <img src="image/financial.jpeg" alt="Financial Management">
                <span class="course-badge" style="background:#10b981;">Top Rated</span>
            </div>
            <div class="course-info">
                <div class="course-meta">
                    <span><i class="fa-solid fa-signal fa-xs"></i> Beginner</span>
                    <span><i class="fa-regular fa-clock fa-xs"></i> 3 Hours</span>
                    <span><i class="fa-solid fa-certificate fa-xs"></i> Certificate</span>
                </div>
                <h3>Financial Management Fundamentals</h3>
                <p>Master budgeting, saving, and investing to build long-term financial security from scratch.</p>
                <div class="course-card-footer">
                    <a href="course 2/overview2.php" class="btn-outline-sm">Overview</a>
                    <a href="/digital learning platform/enroll.php?course_id=2" class="btn-primary-sm">Enroll Free &rarr;</a>
                </div>
            </div>
        </div>

    </div>

    <div style="text-align:center; margin-top:40px;">
        <a href="/digital learning platform/course.php"
           style="display:inline-block; color:#3b82f6; font-weight:600; font-size:15px; text-decoration:none; border:2px solid #3b82f6; padding:10px 28px; border-radius:8px; transition:all 0.3s;">
            View All 4 Courses &rarr;
        </a>
    </div>
</section>

<!-- WHAT MAKES US DIFFERENT SECTION -->
<section class="what-makes-different">
    <div class="different-container">
        <h2>What Makes LearnHub Different</h2>
        <p class="different-subtitle">We're not just another online learning platform - here's why students choose us</p>
        
        <div class="different-grid">
            
            <div class="different-card">
                <div class="different-number">01</div>
                <div class="different-content">
                    <h3>Your Learning Path</h3>
                    <p>Everyone learns differently. Choose a path that fits your goals, your pace, and your style. Learn step by step in a way that feels right for you.Learn at your own convenient time and pace.</p>
                </div>
            </div>

            <div class="different-card">
                <div class="different-number">02</div>
                <div class="different-content">
                    <h3>Learn By Doing</h3>
                    <p>Practice while you learn with hands-on tasks and activities. Create real things as you go, so learning feels useful, not just theoretical.The courses on our website are very useful for your future learning and give you new skills. </p>               
           </div>
            </div>

            <div class="different-card">
                <div class="different-number">03</div>
                <div class="different-content">
                    <h3>Quick Checks and Feedbacks</h3>
                    <p>Practice while you learn with hands-on tasks and activities. Create real things as you go, so learning feels useful, not just theoretical.The courses available on our website are very unique and have demands in future.</p>               
                 </div>
            </div>

            <div class="different-card">
                <div class="different-number">04</div>
                <div class="different-content">
                    <h3>Check Your Learning</h3>
<p>After every section, take a quick quiz to test what you've understood. Track your improvement, strengthen weak areas, and keep building your skills step by step.</p>
</div>

            </div>

            <div class="different-card">
                <div class="different-number">05</div>
                <div class="different-content">
                    <h3>Unique Courses</h3>
<p>Discover courses not commonly available online, including Prompt Engineering, The Psychology of Everyday Decisions, Digital Detective: Spot the Fake, and Financial Management.</p>

                </div>
            </div>

            <div class="different-card">
                <div class="different-number">06</div>
                <div class="different-content">
                    <h3>Affordable Excellence</h3>
                    <p>Good learning should be accessible to everyone. Enjoy high-quality content at a price that works for you, with flexible options available.</p>                </div>
            </div>

        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="cta">
    <h2>Start Learning Today</h2>
    <p>Join thousands of students learning with LearnHub</p>
    <a href="/digital learning platform/auth/signup.php" class="btn">Get Started - It's Free</a>
</section>
<?php include 'partials/footer.php'; ?>
 <!-- Javascript -->

<script src="js/home.js"></script>

</body>
</html>
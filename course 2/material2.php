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
$course_id = 2;
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
        repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(16, 185, 129, 0.03) 2px, rgba(16, 185, 129, 0.03) 4px),
        repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(16, 185, 129, 0.03) 2px, rgba(16, 185, 129, 0.03) 4px);
    background-size: 30px 30px;
}

.lesson-hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.lesson-hero-content i {
    font-size: 120px;
    color: #10b981;
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
    color: #10b981;
    font-size: 28px;
}

.lesson-section h3 {
    font-size: 24px;
    color: #10b981;
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
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(20, 184, 166, 0.05) 100%);
    border-left: 4px solid #10b981;
    padding: 25px 30px;
    margin: 30px 0;
    border-radius: 8px;
}

.highlight-box h4 {
    color: #10b981;
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

/* STAT BOX */
.stat-box {
    background: rgba(239, 68, 68, 0.08);
    border-left: 4px solid #ef4444;
    padding: 25px 30px;
    margin: 30px 0;
    border-radius: 8px;
}

.stat-box h4 {
    color: #ef4444;
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
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
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

/* FINANCIAL TABLE */
.financial-table {
    width: 100%;
    margin: 30px 0;
    border-collapse: collapse;
    background: #0f172a;
    border-radius: 12px;
    overflow: hidden;
}

.financial-table th {
    background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
    color: #ffffff;
    padding: 18px 20px;
    text-align: left;
    font-size: 16px;
    font-weight: 600;
}

.financial-table td {
    padding: 18px 20px;
    border-bottom: 1px solid rgba(51, 65, 85, 0.5);
    color: #cbd5e1;
    font-size: 15px;
    line-height: 1.6;
}

.financial-table tr:last-child td {
    border-bottom: none;
}

.financial-table td:first-child {
    font-weight: 600;
    color: #10b981;
}

/* IMAGE PLACEHOLDER */
/* IMAGE CONTAINER */
.image-container {
    width: 100%;
    margin: 40px 0;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(51, 65, 85, 0.5);
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
}

.image-container img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    display: block;
}

.image-caption {
    background: #0f172a;
    padding: 16px;
    text-align: center;
    color: #94a3b8;
    font-size: 15px;
}


/* SECTION DIVIDER */
.section-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(16, 185, 129, 0.3) 50%, transparent 100%);
    margin: 50px 0;
}

/* QUIZ PREP SECTION */
.quiz-prep-section {
    background: linear-gradient(135deg, #064e3b 0%, #115e59 100%);
    padding: 50px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
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
    color: #10b981;
    text-decoration: none;
    font-size: 16px;
    padding: 12px 0;
    transition: all 0.3s;
}

.reference-link:hover {
    color: #14b8a6;
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

    .financial-table {
        font-size: 14px;
    }

    .financial-table th,
    .financial-table td {
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
        <a href="overview2.php" class="tab">Overview</a>
        <a href="material2.php" class="tab active">Materials</a>
        <a href="quiz2.php" class="tab">Quizzes</a>
    </div>
</div>

<!-- LESSON CONTENT -->
<div class="lesson-container">

    <!-- HERO IMAGE -->
    <div class="lesson-hero">
        <div class="lesson-hero-content">
            <i class="fa-solid fa-chart-pie"></i>
            <p>Financial Management Fundamentals</p>
        </div>
    </div>

    <!-- SECTION 1: FOUNDATION -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-landmark"></i> The Foundation of Financial Control</h2>
        
        <p>
            Financial control is not about restriction-it is about making informed, intentional decisions with your resources. Most people operate reactively, responding to expenses as they arise without a clear plan. This approach leads to stress, debt, and missed opportunities.
        </p>

        <p>
            True financial management begins with awareness. You need to know where your money comes from, where it goes, and why. Without this foundation, even high income can disappear without creating lasting value. Many high earners struggle financially because they lack control systems.
        </p>

        <p>
            Building financial stability requires structure, discipline, and regular review. It is a skill that anyone can learn, regardless of current income level. The principles remain consistent whether you earn $30,000 or $300,000 annually. What changes is the scale of application.
        </p>

        <p>
            In this course, you will develop the frameworks that create financial clarity and control. These are not theoretical concepts-they are practical tools used by successful individuals and organizations worldwide.
        </p>

        <div class="stat-box">
            <h4><i class="fa-solid fa-triangle-exclamation"></i> Critical Reality</h4>
            <p>Studies show that 78% of Americans live paycheck to paycheck-not due to low income, but due to poor budgeting and financial planning systems.</p>
        </div>

        <div style="background:#0f172a; border-radius:12px; padding:30px; margin:30px 0;">
    <h4 style="color:#10b981; text-align:center; margin-bottom:20px; font-size:18px;">
        <i class="fa-solid fa-chart-pie"></i> The 50/30/20 Budget Rule
    </h4>
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
        <div style="background:#1e293b; border-radius:10px; padding:20px; border-top:4px solid #3b82f6; text-align:center;">
            <div style="font-size:36px; font-weight:900; color:#3b82f6; margin-bottom:6px;">50%</div>
            <div style="color:#ffffff; font-weight:700; margin-bottom:6px;">Needs</div>
            <div style="color:#94a3b8; font-size:13px;">Rent, food, transport, bills</div>
        </div>
        <div style="background:#1e293b; border-radius:10px; padding:20px; border-top:4px solid #f59e0b; text-align:center;">
            <div style="font-size:36px; font-weight:900; color:#f59e0b; margin-bottom:6px;">30%</div>
            <div style="color:#ffffff; font-weight:700; margin-bottom:6px;">Wants</div>
            <div style="color:#94a3b8; font-size:13px;">Dining out, hobbies, shopping</div>
        </div>
        <div style="background:#1e293b; border-radius:10px; padding:20px; border-top:4px solid #10b981; text-align:center;">
            <div style="font-size:36px; font-weight:900; color:#10b981; margin-bottom:6px;">20%</div>
            <div style="color:#ffffff; font-weight:700; margin-bottom:6px;">Savings</div>
            <div style="color:#94a3b8; font-size:13px;">Emergency fund, investments</div>
        </div>
    </div>
</div>
    </section>

    <!-- SECTION 2: BUDGET SYSTEM -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-wallet"></i> Building a Powerful Budget System</h2>

        <h3>2.1 Income Analysis</h3>
        <p>
            Understanding your income sources is the first step in financial planning. Most people only consider their salary, but comprehensive income analysis includes all monetary inflows.
        </p>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-check"></i> <strong>Active Income:</strong> Money earned through direct work-salary, wages, freelance projects, business revenue.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Passive Income:</strong> Money earned with minimal ongoing effort-dividends, rental income, royalties, interest.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Total Inflow Tracking:</strong> Document every source monthly to establish a baseline for budgeting decisions.</li>
        </ul>

        <h3>2.2 Expense Structuring</h3>
        <p>
            Not all expenses are equal. Categorizing them correctly allows you to identify areas where you have control and areas where flexibility exists.
        </p>

        <table class="financial-table">
            <thead>
                <tr>
                    <th>Expense Type</th>
                    <th>Description</th>
                    <th>Examples</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Fixed Expenses</td>
                    <td>Regular, unchanging costs</td>
                    <td>Rent, insurance, loan payments</td>
                </tr>
                <tr>
                    <td>Variable Expenses</td>
                    <td>Costs that fluctuate monthly</td>
                    <td>Groceries, utilities, entertainment</td>
                </tr>
                <tr>
                    <td>Lifestyle Inflation</td>
                    <td>Expense increases with income growth</td>
                    <td>Upgraded housing, luxury purchases</td>
                </tr>
            </tbody>
        </table>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-lightbulb"></i> The 50/30/20 Framework Explained</h4>
            <p>
                This budgeting rule allocates: <strong>50% to Needs</strong> (housing, food, utilities), <strong>30% to Wants</strong> (entertainment, dining, hobbies), and <strong>20% to Savings/Debt Repayment</strong>. It provides balance between current enjoyment and future security.
            </p>
        </div>

        <h3>Building Your Budget: 5-Step Process</h3>

        <div class="numbered-steps">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Calculate Total Monthly Income</h4>
                    <p>Add all income sources after taxes. Use conservative estimates if income varies.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>List All Fixed Expenses</h4>
                    <p>Document non-negotiable monthly costs. These form your baseline requirement.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Track Variable Spending</h4>
                    <p>Monitor discretionary expenses for 30 days to identify patterns and waste.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Apply the 50/30/20 Rule</h4>
                    <p>Distribute income according to the framework, adjusting based on personal priorities.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">5</div>
                <div class="step-content">
                    <h4>Review and Adjust Monthly</h4>
                    <p>Budgets evolve. Regular review ensures alignment with goals and life changes.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 3: CASH FLOW -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-arrows-rotate"></i> Cash Flow Mechanics</h2>

        <h3>Understanding Cash Flow vs Profit</h3>
        <p>
            Many people confuse profit with cash flow, leading to financial stress even when income appears strong. <strong>Profit</strong> is revenue minus expenses on paper. <strong>Cash flow</strong> is the actual movement of money in and out of your accounts.
        </p>

        <p>
            You can be profitable but cash-poor if money is tied up in assets, unpaid invoices, or future commitments. This is why businesses with strong revenue sometimes fail-they run out of operational cash before receivables arrive.
        </p>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-key"></i> Key Insight</h4>
            <p><strong>Positive cash flow</strong> means more money enters your accounts than leaves. <strong>Negative cash flow</strong> means you are spending more than you earn. Sustained negative cash flow leads to debt accumulation.</p>
        </div>

        <h3>Common Cash Flow Mistakes</h3>
        <ul class="lesson-list">
            <li><i class="fa-solid fa-xmark"></i> Assuming income will remain constant without building reserves</li>
            <li><i class="fa-solid fa-xmark"></i> Making large purchases without considering timing of income</li>
            <li><i class="fa-solid fa-xmark"></i> Ignoring the gap between earning money and receiving payment</li>
            <li><i class="fa-solid fa-xmark"></i> Failing to account for irregular but predictable expenses (annual insurance, taxes)</li>
            <li><i class="fa-solid fa-xmark"></i> Using credit to cover shortfalls instead of adjusting spending</li>
        </ul>

        <div class="image-container">
    <img src="../image/course2cash.webp" alt="Cash Flow Chart">
    <div class="image-caption">
        Cash Flow Visualization: Inflows vs Outflows
    </div>
</div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 4: INVESTMENTS -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-seedling"></i> Investment Fundamentals</h2>

        <h3>The Risk vs Return Principle</h3>
        <p>
            One of the most fundamental concepts in finance is the relationship between risk and return. In general, <strong>higher potential returns come with higher risk</strong>. Lower risk investments offer more stability but lower growth potential.
        </p>

        <p>
            This does not mean high-risk investments are bad or low-risk investments are always safe. It means you must understand what you are accepting when you choose an investment vehicle. Risk tolerance varies based on age, income stability, and financial goals.
        </p>

        <h3>Asset Types and Characteristics</h3>

        <table class="financial-table">
            <thead>
                <tr>
                    <th>Asset Type</th>
                    <th>Risk Level</th>
                    <th>Return Potential</th>
                    <th>Best For</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Stocks</td>
                    <td>High</td>
                    <td>High (7-10% average)</td>
                    <td>Long-term growth</td>
                </tr>
                <tr>
                    <td>Bonds</td>
                    <td>Low to Medium</td>
                    <td>Moderate (3-5% average)</td>
                    <td>Income and stability</td>
                </tr>
                <tr>
                    <td>Savings Accounts</td>
                    <td>Very Low</td>
                    <td>Low (1-2% average)</td>
                    <td>Emergency funds</td>
                </tr>
                <tr>
                    <td>Real Estate</td>
                    <td>Medium</td>
                    <td>Moderate to High</td>
                    <td>Diversification and income</td>
                </tr>
            </tbody>
        </table>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-lightbulb"></i> Diversification Strategy</h4>
            <p>
                Diversification means spreading investments across different asset types to reduce overall risk. When one investment underperforms, others may compensate. This is the foundation of portfolio management.
            </p>
        </div>

        <div class="image-placeholder">
            <i class="fa-solid fa-chart-line"></i>
            <p>Investment Growth Over Time</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 5: RISK MANAGEMENT -->
    <section class="lesson-section">
        <h2><i class="fa-solid fa-shield-halved"></i> Risk Management & Financial Stability</h2>

        <p>
            Financial stability is not just about earning more-it is about protecting what you have and preparing for uncertainty. Risk management involves identifying potential threats to your financial health and taking preventive action.
        </p>

        <h3>Core Risk Management Strategies</h3>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-check"></i> <strong>Emergency Fund Strategy:</strong> Maintain 3-6 months of living expenses in liquid, accessible accounts. This buffer prevents debt during job loss or unexpected costs.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Diversification Rule:</strong> Never concentrate all assets in one investment type. Spread risk across stocks, bonds, real estate, and cash equivalents.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Insurance Basics:</strong> Protect against catastrophic losses through health, life, disability, and property insurance. Pay premiums to avoid devastating financial hits.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Avoid Emotional Investing:</strong> Market panic and euphoria drive poor decisions. Stick to your plan regardless of short-term volatility.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Regular Portfolio Review:</strong> Rebalance investments annually to maintain target asset allocation as markets shift.</li>
            <li><i class="fa-solid fa-check"></i> <strong>Debt Management:</strong> Prioritize high-interest debt elimination. Avoid using credit as a substitute for income.</li>
        </ul>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 6: DISCIPLINE FRAMEWORK -->
    <section class="lesson-section alt">
        <h2><i class="fa-solid fa-compass"></i> Financial Discipline Framework</h2>

        <p>
            Knowledge without action produces no results. Financial success requires consistent application of principles over time. This framework creates accountability and continuous improvement.
        </p>

        <div class="numbered-steps">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Track Every Transaction</h4>
                    <p>Use apps or spreadsheets to record all income and expenses. Awareness prevents unconscious spending.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Plan Monthly Budget</h4>
                    <p>Before each month begins, allocate every dollar to a category. Give your money a purpose.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Review Weekly Progress</h4>
                    <p>Check spending against budget each week. Early detection of overspending allows quick correction.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Adjust Based on Reality</h4>
                    <p>If your budget consistently fails in one area, adjust allocations. Your plan should match your life.</p>
                </div>
            </div>
        </div>

        <div class="highlight-box">
            <h4><i class="fa-solid fa-key"></i> The Discipline Principle</h4>
            <p>
                Financial discipline is not about perfection-it is about consistency. Small, repeated actions compound over time into significant wealth and security.
            </p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- SECTION 7: QUIZ PREP -->
    <section class="quiz-prep-section">
        <h2>Final Financial Check: Before Taking the Quiz</h2>
        <p>Review these essential financial management principles before testing your knowledge.</p>

        <ul class="lesson-list">
            <li><i class="fa-solid fa-star"></i> The <strong>50/30/20 rule</strong> allocates 50% to needs, 30% to wants, and 20% to savings or debt repayment.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Positive cash flow</strong> occurs when income exceeds expenses-money flows into your accounts faster than it leaves.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Higher expected returns</strong> in investments usually come with higher risk. There is no guaranteed high return without accepting uncertainty.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Diversification</strong> is a strategy to reduce risk by spreading investments across different asset types.</li>
            <li><i class="fa-solid fa-star"></i> <strong>Emergency funds</strong> should cover 3-6 months of living expenses to protect against income disruption.</li>
            <li><i class="fa-solid fa-star"></i> Fixed expenses remain constant month-to-month, while variable expenses fluctuate based on usage and choices.</li>
            <li><i class="fa-solid fa-star"></i> Profit measures revenue minus expenses on paper; <strong>cash flow</strong> measures actual money movement in accounts.</li>
            <li><i class="fa-solid fa-star"></i> Financial discipline requires tracking, planning, reviewing, and adjusting-not just setting goals.</li>
            <li><i class="fa-solid fa-star"></i> Insurance protects against catastrophic financial losses that could destroy accumulated wealth.</li>
            <li><i class="fa-solid fa-star"></i> Successful financial management is about <strong>control and awareness</strong>, not income level.</li>
        </ul>

        <div class="motivational-message">
            <p> You now understand the fundamental frameworks of financial management. Take the quiz to validate your knowledge and demonstrate mastery of these principles!</p>
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
                src="https://www.youtube.com/embed/2xr2HuwHlg8?enablejsapi=1&origin=http://localhost"
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
        <a href="quiz2.php"
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
    const COURSE_ID    = 2;

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
        <p>Explore these additional materials to deepen your financial knowledge:</p>

        <div class="reference-links">
            <a href="https://www.capstonetradingsystems.com/money-management-algorithms" class="reference-link" target="_blank">
                <i class="fa-solid fa-file-lines"></i>
                <span>Money Algorithm(Article)</span>
            </a>
            <a href="https://www.fpinternational.com/documents/inv-beg-guide-row.pdf" target="_blank" class="reference-link">
                <i class="fa-solid fa-book"></i>
                <span>Beginner Investment Guide (PDF)</span>
            </a>
            <a href="https://www.youtube.com/watch?v=0laavBo25ew" class="reference-link" target="_blank"> 
                <i class="fa-solid fa-video"></i>
                <span>Educational Finance Video Series</span>
            </a>
        </div>
    </section>

</div>

</body>
</html>
<?php
/*
 * LEARNING NOTE - Why PHP at the top of a quiz file?
 * ---------------------------------------------------------
 * The quiz itself runs in JavaScript (in the browser).
 * But when the user PASSES, we need to:
 *   1. Tell the SERVER to mark quiz_passed=1 in the database
 *   2. Show a certificate button
 *
 * So PHP sets up the session and passes the course_id
 * to JavaScript, which then calls mark_passed.php via fetch().
 * ---------------------------------------------------------
 */
session_start();
require_once "../db.php";
$course_id = 3;
require_once "../partials/auth_check.php";

// -- VIDEO WATCH GUARD ------------------------------------------
// auth_check.php already verified: logged in + enrolled
// Now we check: did this user watch the video yet?
// If not, send them back to the material page.
$uid = $_SESSION["user_id"];
$vcheck = mysqli_prepare($conn,
    "SELECT video_watched FROM enrollments WHERE user_id=? AND course_id=?");
mysqli_stmt_bind_param($vcheck, "ii", $uid, $course_id);
mysqli_stmt_execute($vcheck);
mysqli_stmt_bind_result($vcheck, $video_watched_check);
mysqli_stmt_fetch($vcheck);
mysqli_stmt_close($vcheck);

if (!$video_watched_check) {
    // Video not watched yet - redirect back to material page
    header("Location: /digital learning platform/course 3/prompt-eng-materials.php?msg=watch_video");
    exit;
}
// -- END VIDEO GUARD --------------------------------------------

$user_name = $_SESSION["user_name"];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prompt Engineering Quiz - LearnHub</title>

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

/* QUIZ CONTAINER */
.quiz-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 24px;
}

/* QUIZ HEADER */
.quiz-header {
    background: linear-gradient(135deg, #1e1b4b 0%, #2e1065 100%);
    padding: 40px;
    border-radius: 12px;
    color: white;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    border: 1px solid rgba(99, 102, 241, 0.15);
}

.quiz-header h1 {
    font-size: 36px;
    margin-bottom: 12px;
}

.quiz-header p {
    font-size: 16px;
    opacity: 0.95;
    margin-bottom: 20px;
}

.quiz-info {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.quiz-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
}

.quiz-info-item i {
    font-size: 18px;
    color: #a5b4fc;
}

/* START SCREEN */
.start-screen {
    background: #1e293b;
    padding: 60px 40px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.start-screen h2 {
    font-size: 28px;
    color: #ffffff;
    margin-bottom: 20px;
}

.start-screen p {
    font-size: 16px;
    color: #cbd5e1;
    margin-bottom: 30px;
    line-height: 1.6;
}

.start-screen ul {
    list-style: none;
    text-align: left;
    max-width: 500px;
    margin: 0 auto 30px;
}

.start-screen li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    font-size: 15px;
    color: #cbd5e1;
}

.start-screen li i {
    color: #6366f1;
    font-size: 18px;
}

.btn-start {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    border: none;
    padding: 14px 40px;
    font-size: 18px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-start:hover {
    background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
}

/* QUIZ CONTENT */
.quiz-content {
    display: none;
}

.quiz-content.active {
    display: block;
}

/* PROGRESS BAR */
.progress-container {
    background: #1e293b;
    padding: 20px 30px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.progress-text {
    font-size: 14px;
    color: #cbd5e1;
    font-weight: 500;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #334155;
    border-radius: 10px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 10px;
    transition: width 0.4s ease;
}

/* QUESTION CARD */
.question-card {
    background: #1e293b;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(51, 65, 85, 0.5);
    margin-bottom: 20px;
}

.question-number {
    color: #6366f1;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 12px;
}

.question-text {
    font-size: 22px;
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 30px;
    line-height: 1.4;
}

/* OPTIONS */
.options {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.option {
    background: #0f172a;
    border: 2px solid rgba(51, 65, 85, 0.5);
    padding: 18px 24px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 16px;
}

.option:hover {
    border-color: #6366f1;
    background: #1e293b;
}

.option input[type="radio"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #6366f1;
}

.option-label {
    font-size: 16px;
    color: #cbd5e1;
    cursor: pointer;
    flex: 1;
}

.option.selected {
    border-color: #6366f1;
    background: #1e293b;
}

/* NAVIGATION BUTTONS */
.quiz-navigation {
    display: flex;
    justify-content: space-between;
    gap: 16px;
}

.btn-nav {
    padding: 12px 32px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    border: none;
    transition: all 0.3s;
}

.btn-previous {
    background: transparent;
    color: #6366f1;
    border: 2px solid #6366f1;
}

.btn-previous:hover {
    background: #1e293b;
}

.btn-previous:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.btn-previous:disabled:hover {
    background: transparent;
}

.btn-next {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
}

.btn-next:hover {
    background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
}

.btn-next:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.btn-next:disabled:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
}

.btn-submit {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
}

.btn-submit:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.btn-submit:disabled:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
}

/* RESULT SCREEN */
.result-screen {
    display: none;
    background: #1e293b;
    padding: 50px 40px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.result-screen.active {
    display: block;
}

.result-icon {
    font-size: 80px;
    margin-bottom: 20px;
}

.result-icon.pass {
    color: #6366f1;
}

.result-icon.fail {
    color: #ef4444;
}

.result-screen h2 {
    font-size: 32px;
    color: #ffffff;
    margin-bottom: 16px;
}

.result-score {
    font-size: 48px;
    font-weight: 700;
    color: #6366f1;
    margin-bottom: 12px;
}

.result-message {
    font-size: 18px;
    color: #cbd5e1;
    margin-bottom: 30px;
}

.result-details {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-bottom: 30px;
}

.result-detail {
    text-align: center;
}

.result-detail-value {
    font-size: 32px;
    font-weight: 700;
    color: #ffffff;
}

.result-detail-label {
    font-size: 14px;
    color: #94a3b8;
    margin-top: 4px;
}

.result-detail.correct .result-detail-value {
    color: #6366f1;
}

.result-detail.incorrect .result-detail-value {
    color: #ef4444;
}

.btn-restart {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    border: none;
    padding: 14px 40px;
    font-size: 18px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    margin-right: 12px;
}

.btn-restart:hover {
    background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
}

.btn-review {
    background: transparent;
    color: #6366f1;
    border: 2px solid #6366f1;
    padding: 14px 40px;
    font-size: 18px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-review:hover {
    background: #1e293b;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .navbar {
        padding: 16px 24px;
    }

    .quiz-header {
        padding: 30px 24px;
    }

    .quiz-header h1 {
        font-size: 28px;
    }

    .question-card {
        padding: 30px 24px;
    }

    .question-text {
        font-size: 18px;
    }

    .start-screen {
        padding: 40px 24px;
    }

    .result-screen {
        padding: 40px 24px;
    }

    .result-details {
        flex-direction: column;
        gap: 20px;
    }

    .quiz-navigation {
        flex-direction: column;
    }

    .btn-nav {
        width: 100%;
    }
}
    </style>
</head>

<body>

<!-- NAVBAR -->
<?php include '../partials/nav.php'; ?>

<!-- QUIZ CONTAINER -->
<div class="quiz-container">

    <!-- QUIZ HEADER -->
    <div class="quiz-header">
        <h1>Prompt Engineering for Beginners - Quiz</h1>
        <p>Test your understanding of prompt structure, role prompting, few-shot techniques, and iterative refinement</p>
        <div class="quiz-info">
            <div class="quiz-info-item">
                <i class="fa-solid fa-question-circle"></i>
                <span>5 Questions</span>
            </div>
            <div class="quiz-info-item">
                <i class="fa-regular fa-clock"></i>
                <span>No Time Limit</span>
            </div>
            <div class="quiz-info-item">
                <i class="fa-solid fa-trophy"></i>
                <span>Pass Score: 60%</span>
            </div>
        </div>
    </div>

    <!-- START SCREEN -->
    <div class="start-screen" id="startScreen">
        <h2>Ready to Test Your Prompt Engineering Knowledge?</h2>
        <p>This quiz will assess your understanding of prompt engineering principles. Read each question carefully and select the best answer.</p>

        <ul>
            <li>
                <i class="fa-solid fa-check"></i>
                <span>5 multiple choice questions</span>
            </li>
            <li>
                <i class="fa-solid fa-check"></i>
                <span>No time limit - take your time</span>
            </li>
            <li>
                <i class="fa-solid fa-check"></i>
                <span>You can navigate between questions</span>
            </li>
            <li>
                <i class="fa-solid fa-check"></i>
                <span>Review your answers before submission</span>
            </li>
        </ul>

        <button class="btn-start" onclick="startQuiz()">Start Quiz</button>
    </div>

    <!-- QUIZ CONTENT -->
    <div class="quiz-content" id="quizContent">

        <!-- PROGRESS BAR -->
        <div class="progress-container">
            <div class="progress-info">
                <span class="progress-text">Question <span id="currentQuestion">1</span> of 5</span>
                <span class="progress-text"><span id="progressPercent">0</span>% Complete</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <!-- QUESTION CARD -->
        <div class="question-card">
            <div class="question-number">Question <span id="questionNum">1</span></div>
            <div class="question-text" id="questionText"></div>

            <div class="options" id="optionsContainer">
                <!-- Options inserted dynamically -->
            </div>
        </div>

        <!-- NAVIGATION -->
        <div class="quiz-navigation">
            <button class="btn-nav btn-previous" id="btnPrevious" onclick="previousQuestion()" disabled>
                <i class="fa-solid fa-arrow-left"></i> Previous
            </button>
            <button class="btn-nav btn-next" id="btnNext" onclick="nextQuestion()">
                Next <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- RESULT SCREEN -->
    <div class="result-screen" id="resultScreen">
        <div class="result-icon" id="resultIcon">
            <i class="fa-solid fa-trophy"></i>
        </div>
        <h2 id="resultTitle">Quiz Completed!</h2>
        <div class="result-score" id="resultScore">0%</div>
        <p class="result-message" id="resultMessage"></p>

        <div class="result-details">
            <div class="result-detail correct">
                <div class="result-detail-value" id="correctAnswers">0</div>
                <div class="result-detail-label">Correct</div>
            </div>
            <div class="result-detail incorrect">
                <div class="result-detail-value" id="incorrectAnswers">0</div>
                <div class="result-detail-label">Incorrect</div>
            </div>
        </div>

        <div>
            <button class="btn-restart" onclick="restartQuiz()">
                <i class="fa-solid fa-rotate-right"></i> Retake Quiz
            </button>
            <a class="btn-review" href="/digital learning platform/course.php">
                <i class="fa-solid fa-book"></i> Back to Course
            </a>
        </div>
    </div>

</div>

<script>
    // Quiz Questions Data
    const quizData = [
        {
            question: "A high-quality prompt must include:",
            options: [
                "Random details",
                "Clear instructions and format",
                "Only one word",
                "No context"
            ],
            correct: 1
        },
        {
            question: "Role prompting means:",
            options: [
                "Assigning AI a specific role",
                "Asking multiple questions",
                "Making prompts shorter",
                "Removing context"
            ],
            correct: 0
        },
        {
            question: "Few-shot prompting includes:",
            options: [
                "No examples",
                "Providing examples",
                "No structure",
                "Removing formatting"
            ],
            correct: 1
        },
        {
            question: "Iterative refinement means:",
            options: [
                "Asking once",
                "Improving the prompt step-by-step",
                "Ignoring feedback",
                "Making prompts vague"
            ],
            correct: 1
        },
        {
            question: "Output format instructions help to:",
            options: [
                "Confuse AI",
                "Reduce clarity",
                "Control structure of response",
                "Increase randomness"
            ],
            correct: 2
        }
    ];

    let currentQuestionIndex = 0;
    let userAnswers = new Array(quizData.length).fill(null);

    // Start Quiz
    function startQuiz() {
        document.getElementById('startScreen').style.display = 'none';
        document.getElementById('quizContent').classList.add('active');
        loadQuestion();
    }

    // Load Question
    function loadQuestion() {
        const question = quizData[currentQuestionIndex];

        document.getElementById('currentQuestion').textContent = currentQuestionIndex + 1;
        document.getElementById('questionNum').textContent = currentQuestionIndex + 1;
        document.getElementById('questionText').textContent = question.question;

        const progress = ((currentQuestionIndex) / quizData.length) * 100;
        document.getElementById('progressPercent').textContent = Math.round(progress);
        document.getElementById('progressFill').style.width = progress + '%';

        const optionsContainer = document.getElementById('optionsContainer');
        optionsContainer.innerHTML = '';

        question.options.forEach((option, index) => {
            const optionDiv = document.createElement('div');
            optionDiv.className = 'option';
            if (userAnswers[currentQuestionIndex] === index) {
                optionDiv.classList.add('selected');
            }

            optionDiv.innerHTML = `
                <input type="radio" name="answer" id="option${index}" value="${index}" ${userAnswers[currentQuestionIndex] === index ? 'checked' : ''}>
                <label for="option${index}" class="option-label">${option}</label>
            `;

            optionDiv.onclick = function() {
                selectOption(index);
            };

            optionsContainer.appendChild(optionDiv);
        });

        updateNavigationButtons();
    }

    // Select Option
    function selectOption(optionIndex) {
        userAnswers[currentQuestionIndex] = optionIndex;

        const options = document.querySelectorAll('.option');
        options.forEach((opt, idx) => {
            if (idx === optionIndex) {
                opt.classList.add('selected');
                opt.querySelector('input').checked = true;
            } else {
                opt.classList.remove('selected');
                opt.querySelector('input').checked = false;
            }
        });

        updateNavigationButtons();
    }

    // Update Navigation Buttons
    function updateNavigationButtons() {
        const btnPrevious = document.getElementById('btnPrevious');
        const btnNext = document.getElementById('btnNext');

        btnPrevious.disabled = currentQuestionIndex === 0;

        const isAnswered = userAnswers[currentQuestionIndex] !== null;

        if (currentQuestionIndex === quizData.length - 1) {
            btnNext.innerHTML = 'Submit Quiz <i class="fa-solid fa-check"></i>';
            btnNext.className = 'btn-nav btn-submit';
        } else {
            btnNext.innerHTML = 'Next <i class="fa-solid fa-arrow-right"></i>';
            btnNext.className = 'btn-nav btn-next';
        }

        btnNext.disabled = !isAnswered;
    }

    // Next Question
    function nextQuestion() {
        if (currentQuestionIndex < quizData.length - 1) {
            currentQuestionIndex++;
            loadQuestion();
        } else {
            submitQuiz();
        }
    }

    // Previous Question
    function previousQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            loadQuestion();
        }
    }

    // Submit Quiz
    function submitQuiz() {
        let correctCount = 0;
        userAnswers.forEach((answer, index) => {
            if (answer === quizData[index].correct) {
                correctCount++;
            }
        });

        const scorePercentage = Math.round((correctCount / quizData.length) * 100);
        const incorrectCount = quizData.length - correctCount;

        document.getElementById('resultScore').textContent = scorePercentage + '%';
        document.getElementById('correctAnswers').textContent = correctCount;
        document.getElementById('incorrectAnswers').textContent = incorrectCount;

        const resultIcon = document.getElementById('resultIcon');
        const resultTitle = document.getElementById('resultTitle');
        const resultMessage = document.getElementById('resultMessage');

        if (scorePercentage >= 60) {
            resultIcon.className = 'result-icon pass';
            resultIcon.innerHTML = '<i class="fa-solid fa-trophy"></i>';
            resultTitle.textContent = 'Excellent!';
            resultMessage.textContent = 'Excellent. You understand how to structure effective AI prompts.';
        } else {
            resultIcon.className = 'result-icon fail';
            resultIcon.innerHTML = '<i class="fa-solid fa-xmark-circle"></i>';
            resultTitle.textContent = 'Keep Learning!';
            resultMessage.textContent = 'Review the materials and refine your prompting strategy.';
        }

        document.getElementById('quizContent').classList.remove('active');
        document.getElementById('resultScreen').classList.add('active');
    }

    // Restart Quiz
    function restartQuiz() {
        currentQuestionIndex = 0;
        userAnswers = new Array(quizData.length).fill(null);

        document.getElementById('resultScreen').classList.remove('active');
        document.getElementById('quizContent').classList.add('active');

        loadQuestion();
    }

    // -- CERTIFICATE + DATABASE SAVE (injected) ------------------
    const COURSE_ID_JS = 3;

    // We override the original submitQuiz to also save to DB and show cert button
    const _origSubmit = submitQuiz;
    submitQuiz = function() {
        _origSubmit();

        // Calculate score again to know if passed
        let correct = 0;
        userAnswers.forEach((ans, i) => { if (ans === quizData[i].correct) correct++; });
        const pct = Math.round((correct / quizData.length) * 100);

        if (pct >= 60) {
            // Tell the server: this user passed this course quiz
            // fetch() = AJAX - sends data to PHP without reloading page
            fetch('/digital learning platform/mark_passed.php', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json' },
                body:    JSON.stringify({ course_id: COURSE_ID_JS })
            });

            // Add a certificate button to the result screen
            setTimeout(function() {
                const existingBtns = document.querySelector('.result-screen > div');
                if (existingBtns && !document.getElementById('certBtn')) {
                    const certBtn = document.createElement('a');
                    certBtn.id        = 'certBtn';
                    certBtn.href      = '/digital learning platform/certificate.php?course_id=' + COURSE_ID_JS;
                    certBtn.innerHTML = '<i class="fa-solid fa-certificate"></i> Get Your Certificate';
                    certBtn.style.cssText = `
                        display:inline-block; margin-top:16px;
                        background: linear-gradient(135deg,#f59e0b,#d97706);
                        color:#fff; padding:14px 36px; border-radius:8px;
                        text-decoration:none; font-size:18px; font-weight:700;
                        box-shadow: 0 4px 14px rgba(245,158,11,0.4);
                    `;
                    existingBtns.appendChild(document.createElement('br'));
                    existingBtns.appendChild(certBtn);
                }
            }, 300);
        }
    };
    // -- END CERTIFICATE INJECT -----------------------------------
</script>

</body>
</html>

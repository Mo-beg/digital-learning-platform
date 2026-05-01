-- ============================================================
-- setup.sql — RUN THIS IN phpMyAdmin TO CREATE YOUR TABLES
-- ============================================================
-- HOW TO USE:
--   1. Open http://localhost/phpmyadmin
--   2. Create database named "learnhub" if you haven't
--   3. Click on "learnhub" database (left sidebar)
--   4. Click "SQL" tab at the top
--   5. Paste ALL of this file content → click Go
-- ============================================================

-- Make sure we're using the right database
USE learnhub;

-- ─────────────────────────────────────────────────────────
-- TABLE 1: users
-- Stores everyone who signs up on your website
-- ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,   -- unique ID for each user
    name       VARCHAR(100) NOT NULL,            -- full name
    email      VARCHAR(150) NOT NULL UNIQUE,     -- email must be unique (no duplicates)
    password   VARCHAR(255) NOT NULL,            -- we store hashed (encrypted) password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- when they signed up
);

-- ─────────────────────────────────────────────────────────
-- TABLE 2: courses
-- Stores your 4 courses with their YouTube video links
-- ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS courses (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(200) NOT NULL,
    description   TEXT,
    youtube_url   VARCHAR(300),   -- YouTube embed URL (we use the embed format)
    image         VARCHAR(200),   -- path to course image like image/psychology.jpeg
    overview_file VARCHAR(200),   -- e.g. course 1/psychology.php
    material_file VARCHAR(200),   -- e.g. course 1/material.php
    quiz_file     VARCHAR(200)    -- e.g. course 1/quiz.php
);

-- ─────────────────────────────────────────────────────────
-- TABLE 3: enrollments
-- Links users to courses — the FOREIGN KEYS live here
-- This table answers: "Which user enrolled in which course?"
-- ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS enrollments (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT NOT NULL,                  -- FK → users.id
    course_id     INT NOT NULL,                  -- FK → courses.id
    video_watched TINYINT(1) DEFAULT 0,          -- 0 = not watched, 1 = watched
    quiz_passed   TINYINT(1) DEFAULT 0,          -- 0 = not passed, 1 = passed
    enrolled_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- FOREIGN KEY means: user_id must exist in users table
    -- ON DELETE CASCADE means: if user is deleted, their enrollments are deleted too
    FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,

    -- Prevent same user enrolling in same course twice
    UNIQUE KEY unique_enrollment (user_id, course_id)
);

-- ─────────────────────────────────────────────────────────
-- INSERT the 4 courses into the courses table
-- YouTube URLs use the embed format: youtube.com/embed/VIDEO_ID
-- ─────────────────────────────────────────────────────────
INSERT INTO courses (title, description, youtube_url, image, overview_file, material_file, quiz_file) VALUES
(
    'The Psychology of Everyday Decisions',
    'Understand cognitive biases, habit loops, and how emotions drive your daily choices.',
    'https://www.youtube.com/embed/lbuHb3Rm_aQ',
    'image/psychology.jpeg',
    'course 1/psychology.php',
    'course 1/material.php',
    'course 1/quiz.php'
),
(
    'Financial Management Fundamentals',
    'Master the basics of budgeting, saving, investing, and building long-term financial security.',
    'https://www.youtube.com/embed/EIedMoIiX0E',
    'image/financial.jpeg',
    'course 2/overview2.php',
    'course 2/material2.php',
    'course 2/quiz2.php'
),
(
    'Prompt Engineering Mastery',
    'Learn how to write effective prompts to get the best results from AI tools like ChatGPT.',
    'https://www.youtube.com/embed/T9aRN5JkmL8',
    'image/prompt.jpeg',
    'course 3/prompt-eng-nav.php',
    'course 3/prompt-eng-materials.php',
    'course 3/prompt-eng-quiz.php'
),
(
    'Digital Detective: Spot the Fake',
    'Master the fundamentals of digital detective work.',
    'https://www.youtube.com/embed/EHqXMxY4_Nk',
    'image/digital.webp',
    'course 4/overview4.php',
    'course 4/material4.php',
    'course 4/quiz4.php'
);

-- ─────────────────────────────────────────────────────────
-- All done! You should see:
--   ✅ users table (empty, ready for signups)
--   ✅ courses table (4 courses pre-loaded)
--   ✅ enrollments table (empty, fills as users enroll)
-- ─────────────────────────────────────────────────────────

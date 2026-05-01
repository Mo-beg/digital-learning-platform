# 🎓 LearnHub — Digital Learning Platform

> An e-learning web platform built as an **ICAT Project at NUTECH**.  
> Features user authentication, 4 full courses, quizzes, and certificate generation.

---

## 📸 Preview

> ![alt text](image-1.png)

---

## ✨ Features

- 🔐 User Signup & Login system
- 📚 4 Courses with embedded YouTube videos
- 📝 Quiz system per course
- 🏆 Certificate generation on completion
- 📊 Enrollment tracking per user

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Server | Apache (via XAMPP) |

---

## ⚙️ How to Run This Project Locally

Since this is a **PHP + MySQL** project, you cannot just open the files directly in a browser.  
You need a local server. Follow these steps carefully:

---

### ✅ Step 1 — Install XAMPP

1. Download XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)
2. Install it (keep all default settings)
3. Open **XAMPP Control Panel**
4. Click **Start** next to **Apache**
5. Click **Start** next to **MySQL**

Both should turn green ✅

---

### ✅ Step 2 — Download This Project

Click the green **Code** button on this page → **Download ZIP**  
Then extract the ZIP file.

---

### ✅ Step 3 — Put Project in the Right Folder

Copy the extracted folder and paste it here:

```
C:\xampp\htdocs\
```

Rename the folder to:
```
digital-learning-platform
```

So the path looks like:
```
C:\xampp\htdocs\digital-learning-platform\
```

---

### ✅ Step 4 — Set Up the Database

1. Open your browser and go to:
   ```
   http://localhost/phpmyadmin
   ```
2. Click **New** on the left sidebar
3. Create a database named exactly:
   ```
   learnhub
   ```
4. Click on **learnhub** in the left sidebar
5. Click the **SQL** tab at the top
6. Open the file `setup.sql` from the project folder
7. Copy **all** its contents and paste into the SQL box
8. Click **Go**

You should see ✅ success — 3 tables created + 4 courses inserted.

---

### ✅ Step 5 — Open the Website

Open your browser and go to:
```
http://localhost/digital-learning-platform/home.php
```

That's it! The website should be fully running. 🎉

---

## 📁 Project Structure

```
digital-learning-platform/
│
├── auth/              → Login & Signup pages
├── course 1/          → Psychology course files
├── course 2/          → Financial Management course files
├── course 3/          → Prompt Engineering course files
├── course 4/          → Digital Detective course files
├── css/               → Stylesheets
├── js/                → JavaScript files
├── image/             → Course images
├── partials/          → Reusable PHP components (header, footer)
├── support/           → Support page files
│
├── home.php           → 🏠 Main homepage
├── course.php         → Course listing page
├── discover.php       → Discover page
├── about.php          → About page
├── enroll.php         → Enrollment handler
├── certificate.php    → Certificate generator
├── db.php             → Database connection
├── setup.sql          → ⭐ Run this to set up your database
└── README.md          → This file
```

---

## ⚠️ Common Issues & Fixes

| Problem | Fix |
|---------|-----|
| Page not opening | Make sure Apache & MySQL are running in XAMPP |
| Database error | Make sure you created `learnhub` DB and ran `setup.sql` |
| Blank page | Check that project is inside `C:\xampp\htdocs\` |
| Login not working | Re-run `setup.sql` in phpMyAdmin |

---

## 👨‍💻 Developer

**Mo-beg**  
ICAT Project — NUTECH University  

---

## 📄 License

This project was built for academic purposes as part of the ICAT curriculum at NUTECH.

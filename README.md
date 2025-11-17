# 📚 Project: Feedback Platform (School Feedback)

This project is a complete web application built from scratch in native PHP, following an MVC architecture. It allows a training institution to collect, manage, and analyze feedback from students and instructors on course modules.

The application manages three distinct roles (Student, Instructor, Admin), each with a secure portal and specific functionalities.

## ✨ Key Features

### 👨‍🎓 Student Space
* **Secure Authentication:** Login with a BCRYPT hashed password.
* [cite_start]**Password Change:** Forced redirect on first login to set a personal password that complies with security standards [cite: 162-164].
* **Dashboard:** Overview of available actions.
* [cite_start]**Feedback Submission:** Interactive feedback form (1-5 star rating) for modules taken that day [cite: 21-28, 88-95, 204-211].
* **Submission Constraints:**
    * **Time-based:** A module is only eligible for feedback on the day of the course (the list is empty after midnight).
    * **Uniqueness:** A student can only submit one feedback per module session.
* [cite_start]**History:** View all previously submitted feedback [cite: 56-58].
* [cite_start]**Profile Management:** Modify personal information (name, email) [cite: 53-55].

### 👨‍🏫 Instructor Space
* **Secure Authentication:** Dedicated login portal.
* **Dashboard:** Displays completed sessions awaiting feedback and a history of submitted feedback.
* [cite_start]**Class Feedback:** A form allowing the instructor to rate the class's performance (participation, overall work) [cite: 79-82].

### ⚙️ Admin Space
* **Secure Authentication:** Dedicated login portal.
* **Centralized Dashboard:**
    * [cite_start]**Statistics:** A summary view with feedback counts and average scores for each criterion, grouped by module and class [cite: 38-41].
    * **Visualization:** A complete table of *all* feedback submitted by students.
* [cite_start]**Dynamic Filters:** The statistics and main table can be filtered by Class, Module, or Student [cite: 34-37]. Reports update based on the applied filters.

### 🔑 Security & Backend
* **MVC Architecture:** Code is structured into Models (DB logic), Views (HTML/CSS), and Controllers (business logic) for easy maintenance.
* **Front Controller:** All requests are routed through `public/index.php`.
* [cite_start]**Password Generation:** A PHP CLI script (`scripts/generate_passwords.php`) is provided to initialize student accounts with secure passwords (CNIL compliant) and store them (hashed in DB, plaintext in a `logins.txt` file for distribution) [cite: 155-176].

## 🛠️ Technologies Used
* **Backend:** Native PHP 8
* **Frontend:** HTML5, CSS3, JavaScript (ES6)
* **Database:** MySQL
* **Server:** Apache (via XAMPP)
* **Architecture:** MVC (Model-View-Controller)

## 🚀 Installation and Setup Instructions

Follow these steps to launch the project on your local machine.

### Prerequisites
* A local server environment like **XAMPP** (with Apache and MySQL).
* A database client (like **phpMyAdmin**, included with XAMPP).

### Step 1: Start XAMPP
Launch the XAMPP Control Panel and start the **Apache** and **MySQL** services.

### Step 2: Create and Import the Database
1.  Open **phpMyAdmin** (by navigating to `http://localhost/phpmyadmin/`).
2.  Create a new database named `school_feedback` (using `utf8mb4_general_ci` collation).
3.  Select this new database and click the "SQL" tab.
4.  Open the `database_schema.sql` file (available in this repository), copy its entire content, and paste it into the SQL window.
5.  Click "Go" or "Run".
6.  **Important:** Also run the SQL scripts in `database_seed.sql` to create the test instructors and admins.

### Step 3: Generate Student Passwords
1.  Open a terminal (like Git Bash or Command Prompt) and navigate to the project folder:
    ```bash
    cd C:\xampp\htdocs\school_feedback
    ```
2.  Run the password generation script to populate the `Etudiants` table:
    ```bash
    C:\xampp\php\php.exe scripts\generate_passwords.php
    ```
3.  This will create a `logins.txt` file in the root directory (this file is ignored by `.gitignore` and should never be shared).

### Step 4: Launch the Application
1.  Open your browser.
2.  Navigate to: **`http://localhost/school_feedback/public/`**

## 🔑 Test Credentials

* **Administrator:**
    * **Email:** `admin@ecole.fr`
    * **Password:** `admin123`

* **Instructor:**
    * **Email:** `jean.dupont@ecole.fr`
    * **Password:** `password123`

* **Student:**
    * **Email:** (See the `logins.txt` file generated in Step 3)
    * **Password:** (See the `logins.txt` file generated in Step 3)

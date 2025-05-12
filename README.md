
# BlogVerse – PHP Blog App with Search, Pagination, and Responsive UI
![PHP](https://img.shields.io/badge/PHP-MySQLi-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![Security](https://img.shields.io/badge/Security-Enhanced-brightgreen)
![Role-Based Access](https://img.shields.io/badge/Access-Control-orange)
![Status](https://img.shields.io/badge/Task-4%20Complete-success)
![MySQL](https://img.shields.io/badge/MySQL-5.7-orange)
![License](https://img.shields.io/badge/license-MIT-green)

BlogVerse is a clean and minimal blogging platform built with **PHP**, **MySQL**, and **Bootstrap 5**.  
It allows users to create, view, search, and manage blog posts with pagination and a responsive interface.

---

# 📘 BlogVerse – Final Project

A secure, responsive blogging platform built with **PHP**, **MySQLi**, and **Bootstrap**. BlogVerse supports CRUD operations, role-based access, image upload, search, pagination, and dark mode.

---

## 🚀 Features

- ✅ **User Authentication**
  - Register/Login with hashed passwords
  - Role-based access (Admin, Editor, User)

- ✅ **Post Management**
  - Create, Edit, Delete posts
  - Upload & display post images

- ✅ **Enhanced Functionality**
  - Search by title or content
  - Pagination (6 posts/page)
  - Dark mode toggle

- ✅ **Security**
  - Prepared statements (MySQLi)
  - Server/client form validation
  - Session-based protection

---

## 🧪 Testing Checklist

| Test Area | Description | Status |
|-----------|-------------|--------|
| Login/Register | Correct user credentials, wrong input handling | ✅ |
| Role-Based Access | Admin can access panel, editor can post, user can view only | ✅ |
| CRUD | All create, edit, delete operations tested | ✅ |
| Image Upload | Upload .jpg/.png, preview in posts | ✅ |
| Search | Accurate results on keyword input | ✅ |
| Pagination | Navigation works across multiple pages | ✅ |
| Dark Mode | Toggle + persistence via `localStorage` | ✅ |
| Security | SQL injection attempts blocked, session checks in place | ✅ |

---

## 🧰 Technologies Used

- PHP (MySQLi)
- MySQL
- Bootstrap 5
- HTML5, CSS3
- JavaScript

---

## 🧠 What I Learned

> I learned how to integrate front-end and back-end efficiently, structure secure queries using prepared statements, manage user sessions, and build a clean, mobile-friendly UI using Bootstrap. I also practiced testing and debugging a full-stack project.

---

## 📁 Folder Structure
├── uploads/           # where images go (empty or sample)
├── db.php
├── login.php
├── register.php
├── blog.php
├── create_post.php
├── edit_post.php
├── delete_post.php
├── view_post.php
├── admin_panel.php
└── README.md


## Project Setup
- Local server: XAMPP
- Language: PHP
- Database: MySQL
- Version control: Git and GitHub

## How to Run
1. Install XAMPP and start Apache and MySQL.
2. Place the project folder inside `htdocs`.
3. Access via `http://localhost/php_crud_project/` in your browser.
# PHP CRUD Project



## How to Run Locally

1. Install and start **XAMPP** or **WAMP** server.
2. Clone this repository or download the ZIP file.
3. Move the project folder to the `htdocs` directory (XAMPP) or `www` directory (WAMP).
4. Open **phpMyAdmin** and run the following SQL script to create the database:


## Initial Structure
- `index.php` — Main entry point
- `README.md` — Project description

## Author
- Name: Zakir Hussain
- Internship Program: Web Development (PHP & MySQL)

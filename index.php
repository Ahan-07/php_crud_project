<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body ,html{
            background-color:rgb(202, 222, 254);
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .blog-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .blog-img {
            height: 200px;
            object-fit: cover;
        }
        .blog-title {
            font-weight: 600;
            color: #343a40;
        }
        .blog-text {
            color: #555;
        }
        .blog-btn {
            background-color: #6c63ff;
            color: #fff;
        }
        .blog-btn:hover {
            background-color: #5848e5;
        }
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7));
            height: 100%;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 0 10px;
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }
        .hero p {
            font-size: 1.3rem;
            margin-top: 1rem;
            margin-bottom: 2rem;
        }
        .btn-custom {
            background-color: #6c63ff;
            color: #fff;
            padding: 0.75rem 2rem;
            margin: 0 0.5rem;
            font-size: 1.1rem;
            border: none;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #5848e5;
        }
    </style>
</head>
<body class="container py-4 mt-1 round">
<div class="hero">
    <div>
        <h1>Welcome to <span class="text-warning">BlogVerse</span></h1>
        <p>Share your stories, read others, and express yourself in the most creative way.</p>
        <div>
            <a href="login.php" class="btn btn-custom">Login</a>
            <a href="register.php" class="btn btn-outline-light">Register</a>
        </div>
    </div>
</div>
  </body>
</html>

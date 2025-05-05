<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
          body ,html{
            background-color:rgb(202, 222, 254);
            height: 100%;
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
<body>
<?php
    session_start();
    include 'db.php';

    echo '<div class="mb-4 mt-2 text-end">';
    if (isset($_SESSION['user_id'])) {
        echo "<a class='btn btn-primary me-2' href='create_post.php'>Create New Post</a>";
        echo "<a class='btn btn-outline-danger' href='logout.php'>Logout</a>";
     }
      else {
        // echo "<a class='btn btn-success me-2' href='login.php'>Login</a>";
        // echo "<a class='btn btn-warning' href='register.php'>Register</a>";
        include 'index.php';
    }
    echo '</div>';

    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
if( isset( $_SESSION['user_id']) ){
    echo '<div class="row g-4">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-6 col-lg-4">';
        echo '<div class="card blog-card">';
        echo '<img src="https://source.unsplash.com/600x400/?nature,blog" class="card-img-top blog-img" alt="Post Image">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title blog-title">' . htmlspecialchars($row['title']) . '</h5>';
        echo '<p class="card-text blog-text">' . substr(strip_tags($row['content']), 0, 300) . '...</p>';
        echo '<a href="view_post.php?id=' . $row['id'] . '" class="btn blog-btn btn-sm">Continue Reading</a>';
        if (isset($_SESSION['user_id'])) {
            echo '<a href="edit_post.php?id=' . $row['id'] . '" class="btn btn-outline-info btn-sm ms-2">Edit</a>';
            echo '<a href="delete_post.php?id=' . $row['id'] . '" class="btn btn-outline-danger btn-sm ms-2">Delete</a>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}
    ?>
</body>
</html>
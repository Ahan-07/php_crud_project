<?php
session_start();
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid Post ID.</div>";
    exit;
}

$post_id = (int)$_GET['id'];
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) !== 1) {
    echo "<div class='alert alert-danger'>Post not found.</div>";
    exit;
}

$post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?> | BlogVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(202, 222, 254);
            font-family: 'Segoe UI', sans-serif;
        }
        .post-container {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-top: 2rem;
        }
        .post-title {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .post-meta {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 1rem;
        }
        .post-content {
            font-size: 1.2rem;
            color: #333;
            white-space: pre-line;
        }
        .btn-back {
            background-color: #6c63ff;
            color: #fff;
        }
        .btn-back:hover {
            background-color: #5848e5;
        }
        .post-image {
            max-height: 500px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-end mt-4">
        <a href="blog.php" class="btn btn-back">← Back to Blog</a>
    </div>

    <div class="post-container mt-3">
        <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
        <div class="post-meta">Posted on <?= date('F j, Y, g:i a', strtotime($post['created_at'])) ?></div>
        <hr>
        <?php if (!empty($post['image']) && file_exists('uploads/' . $post['image'])): ?>
            <div class="text-center mb-4">
                <img src="uploads/<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded shadow post-image" alt="Post Image">
            </div>
        <?php endif; ?>
        <div class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></div>
    </div>
</div>

</body>
</html>
